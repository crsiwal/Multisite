<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        user_checks(["activeblog"], "blog", "blog/summery");
    }

    public function error_404() {
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'Page not found - Sab News');
        $this->template->addMeta('description', "We're sorry, We can't find this page you were trying to reach.");
        $this->template->show('errors/html/error_404', $data, 'pagenotfound');
    }

    public function test() {
        $binary = file_get_contents(path("public/1/1/isAWYBEN.jpg"));
        $this->load->library('Bucket');
        $url = $this->bucket->upload($binary, "IMGUR");
        var_dump($url);
    }

}
