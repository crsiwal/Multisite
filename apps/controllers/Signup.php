<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        next_page("google");
    }

    public function google() {
        $success = FALSE;
        if (!empty($this->input->get('code', TRUE))) {
            $this->load->library('Google');
            $auth = $this->google->get_access_token_auth();
            if ($auth) {
                $g_user = $this->google->get_user_details($auth['access_token']);
                if ($g_user && isset($g_user["email"])) {
                    $user = email_exists($g_user["email"]);
                    $success = TRUE;
                    if ($user && isset($user->id)) {
                        $this->user->update_user_access_token($auth, $user->id);
                        $this->user->log_in_this_user($user);
                    } else {
                        $user_id = $this->user->add_new_user($g_user);
                        if ($user_id) {
                            $this->user->add_user_access_token($user_id, $auth);
                            $user = $this->user->get_user_by_id($user_id);
                            $this->user->log_in_this_user($user);
                            next_page("settings/password");
                        }
                    }
                }
            }
        }
        next_page((!$success) ? "login" : "/");
    }

}
