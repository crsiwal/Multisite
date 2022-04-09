<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (is_login()) {
            next_page("/");
        } else {
            $this->load->library('Google');
            $data = array(
                'popup' => array('login'),
                'loginurl' => url("login/request", true),
                'g_login_url' => $this->google->get_login_url(),
                'error' => $this->sessions->get_error()
            );
            $this->template->addMeta('title', 'Login In - Sab News');
            $this->template->addMeta('description', 'Login to your account.');
            $this->template->header('login');
            $this->template->sidebar('left', FALSE);
            $this->template->show('dashboard/users/login', $data, 'login', 'public');
        }
    }

    public function google() {
        $success = FALSE;
        if (!empty($this->input->get('code', TRUE))) {
            $this->load->library('Google');
            $auth = $this->google->get_access_token_auth(TRUE);
            if ($auth) {
                $g_user = $this->google->get_user_details($auth['access_token']);
                if ($g_user && isset($g_user["email"])) {
                    $user = email_exists($g_user["email"]);
                    $success = TRUE;
                    if ($user && isset($user->id)) {
                        $this->user->update_user_access_token($auth, $user->id);
                        $this->user->log_in_this_user($user);
                    } else {
                        if (isset($auth["refresh_token"])) {
                            $user_id = $this->user->add_new_user($g_user);
                            if ($user_id) {
                                $this->user->add_user_access_token($user_id, $auth);
                                $user = $this->user->get_user_by_id($user_id);
                                $this->user->log_in_this_user($user);
                                next_page("settings/password");
                            }
                        } else {
                            next_page($this->google->get_signup_url(), FALSE);
                        }
                    }
                }
            }
        }
        next_page((!$success) ? "login" : "/");
    }

    public function request() {
        $redirect_url = "login";
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation', NULL, 'form');
        $this->form->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[56]');
        $this->form->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[56]');
        if ($this->form->run() != FALSE) {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            if ($this->user->log_in_user($username, $password) === true) {
                $redirect_url = "/";
            } else {
                $this->sessions->set_error("Invalid username or password");
            }
        } else {
            $this->sessions->set_error(reset($this->form->error_array()));
        }
        next_page($redirect_url);
    }

}
