<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Users.php
 *  Path: application/libraries/Users.php
 *  Description: This is user library which is used for maintain user action and meta data of user.
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         16/04/2019              Created
 *
 */

if (!class_exists('Users')) {

    class Users {

        private $ci;
        private $user;
        private $permission;

        public function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('UserModel', 'mod_user');
            if ($this->user_logged_in()) {
                $this->user = $this->get();
                $this->set_user_permissions();
            }
        }

        public function get() {
            $user_id = $this->get_logged_in_user_id();
            if ($user_id != FALSE) {
                return $this->get_user_by("id", $user_id);
            }
            return FALSE;
        }

        public function get_user_by_id($user_id) {
            return $this->get_user_by("id", $user_id);
        }

        public function get_user_by($field, $value) {
            $user = FALSE;
            switch ($field) {
                case "id":
                    $user = $this->ci->mod_user->get_user_by_id($value);
                    break;
                case "email":
                    $user = $this->ci->mod_user->get_user_by_email($value);
                    break;
            }
            if ($user) {
                $user->blog_count = $this->ci->mod_user->count_user_blogs($user->id);
            }
            return $user;
        }

        /**
         * 
         * @param type $permission
         * @return type
         */
        public function is_accessable($permission) {
            return in_array($permission, $this->permission) ? TRUE : FALSE;
        }

        /**
         * It will make user logout
         * @return boolean
         */
        public function logged_out_user() {
            return ($this->ci->session->sess_destroy()) ? TRUE : FALSE;
        }

        /**
         * This will check either user is login or not
         * @return type
         */
        public function user_logged_in() {
            return ($this->ci->sessions->get_login() === TRUE) ? TRUE : FALSE;
        }

        /**
         * This will return in logged in user id
         * @return boolean
         */
        public function get_logged_in_user_id() {
            $logged_in_user_id = $this->ci->sessions->get_user();
            return (!empty($logged_in_user_id)) ? $logged_in_user_id : false;
        }

        /**
         * This function will try to login to user and set session after successfully login
         * Either return FALSE in case login Failed
         * @param type $username
         * @param type $password
         */
        public function log_in_user($username, $password) {
            $user = $this->ci->mod_user->get_user_by_namekey($username);
            if ($user !== FALSE && isset($user->password)) {
                $loginPassword = $this->user_password($password, $user->password);
                /* Check username and password */
                if ($loginPassword === TRUE) {
                    $this->log_in_this_user($user);
                    return TRUE;
                }
            }
            return FALSE;
        }

        public function log_in_this_user($user) {
            if (isset($user->id)) {
                $this->ci->sessions->set_login();
                $this->ci->sessions->set_user($user->id);
                $this->action_on_login($user);
                return true;
            }
            return false;
        }

        public function is_user_blog($blog_id, $user_id = 0) {
            $user_id = ($user_id === 0) ? $this->ci->user->get_logged_in_user_id() : $user_id;
            return $this->ci->mod_user->is_user_blog($user_id, $blog_id);
        }

        public function add_new_user($data) {
            if (is_array($data)) {
                $user_data = array(
                    "gid" => (isset($data["gid"]) ? $data["gid"] : ""),
                    "first_name" => (isset($data["first_name"]) ? $data["first_name"] : ""),
                    "middle_name" => (isset($data["middle_name"]) ? $data["middle_name"] : ""),
                    "last_name" => (isset($data["last_name"]) ? $data["last_name"] : ""),
                    "display_name" => (isset($data["display_name"]) ? $data["display_name"] : ""),
                    "email" => (isset($data["email"]) ? $data["email"] : ""),
                    "username" => (isset($data["username"]) ? $data["username"] : $data["email"]),
                    "password" => $this->user_password((isset($data["password"]) ? $data["password"] : unique_key())),
                    "pic_url" => (isset($data["picture"]) ? $data["picture"] : ""),
                    "user_role" => $this->ci->dbconfig->get_default_user_role(),
                    "state" => 0,
                    "reg_date" => get_time(),
                    "last_active" => get_time()
                );
                return $this->ci->mod_user->add_user($user_data);
            }
            return false;
        }

        public function add_user_meta($user_id, $data) {
            if (is_array($data)) {
                $user_data = array(
                    "user_id" => (isset($user_id) ? $user_id : 0),
                );
                //return $this->ci->mod_user->add_user($user_data);
            }
            return false;
        }

        public function change_password() {
            $success = false;
            $this->ci->load->helper(array('form'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('pass', 'Password', 'trim|required|min_length[5]|max_length[56]');
            if ($this->ci->form->run() != FALSE) {
                $password = $this->ci->input->post('pass', true);
                $dbPassword = $this->user_password($password);
                $user_id = $this->get_logged_in_user_id();
                $success = $this->ci->mod_user->change_password($dbPassword, $user_id);
                if (!$success) {
                    $this->ci->sessions->set_error("You should use a different password from older.");
                }
            } else {
                $error = $this->ci->form->error_array();
                $this->ci->sessions->set_error(reset($error));
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Password successfully changed" : $this->ci->sessions->get_error()
            );
        }

        public function get_access_token($user_id = 0) {
            $user_id = ($user_id === 0) ? $this->ci->user->get_logged_in_user_id() : $user_id;
            return $this->ci->mod_user->get_access_token($user_id);
        }

        public function add_user_access_token($user_id, $auth) {
            if (is_array($auth)) {
                $access_data = array(
                    "user_id" => (isset($user_id) ? $user_id : 0),
                    "access_token" => (isset($auth["access_token"]) ? $auth["access_token"] : ""),
                    "refresh_token" => (isset($auth["refresh_token"]) ? $auth["refresh_token"] : ""),
                    "valid_access" => TRUE,
                );
                return $this->ci->mod_user->add_user_access_token($access_data);
            }
            return false;
        }

        public function update_user_access_token($auth, $user_id = 0) {
            if (is_array($auth)) {
                $user_id = ($user_id === 0) ? $this->ci->user->get_logged_in_user_id() : $user_id;
                $access_token = (isset($auth["access_token"]) ? $auth["access_token"] : "");
                $refresh_token = (isset($auth["refresh_token"]) ? $auth["refresh_token"] : "");
                return $this->ci->mod_user->update_user_access_token($user_id, $access_token, $refresh_token);
            }
            return false;
        }

        public function get_session_data() {
            return array(
                'name' => $this->get_user_meta("name"),
                'username' => $this->get_user_meta("username"),
                'email' => $this->get_user_meta("email"),
                'picture' => $this->get_user_meta("picture"),
                'blog_id' => $this->ci->sessions->get_blog_meta("id"),
                'blog_name' => $this->ci->sessions->get_blog_meta("name"),
                'blog_logo' => (empty($this->ci->sessions->get_blog_meta("logo"))) ? icon_url("blogger.png", TRUE) : user_asset_url($this->ci->sessions->get_blog_meta("logo"), TRUE),
            );
        }

        public function get_user_meta($meta, $user_id = 0) {
            if (in_array($meta, ["id", "gid", "username", "email", "picture", "name", "user_role", "blog_count"])) {
                if ($user_id === 0) {
                    return $this->user->$meta;
                } else {
                    $user = $this->ci->mod_user->get_user_by_id($user_id);
                    return (isset($user->$meta) ? $user->$meta : "");
                }
            }
            return false;
        }

        private function action_on_login($user) {
            // Actions
        }

        private function user_password($password, $dbPassword = FALSE) {
            $this->ci->load->library('Password', NULL, 'password');
            if ($dbPassword !== FALSE) {
                return $this->ci->password->checkPassword($password, $dbPassword);
            } else {
                return $this->ci->password->hashPassword($password);
            }
        }

        /**
         * 
         * @return type
         */
        private function set_user_permissions() {
            if (isset($this->user->user_role)) {
                $this->permission = $this->ci->mod_user->get_user_permissions($this->user->user_role);
            } else {
                $this->logged_out_user();
                next_page("login");
            }
        }

    }

}