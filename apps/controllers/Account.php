<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        nextPage(base_url("/"));
    }

    public function logout() {
        $this->user->logged_out_user();
        next_page("/login");
    }

    public function setblog($blog_id = "") {
        checkLogin();
        $this->load->library('Blogs');
        if ($blog = $this->blogs->get_user_blogs(NULL, $blog_id)) {
            $this->sessions->set_active_blog($blog_id);
            $this->sessions->set_blog($blog);
            next_page("blog/summery");
        } else {
            next_page("blog");
        }
    }

}
