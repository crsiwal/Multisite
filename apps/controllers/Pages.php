<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        next_page("blog/pages");
    }

    public function new() {
        user_checks(["activeblog"], "blog");
        $this->load->library('Category');
        $data = array(
            'popup' => array('login'),
            "update" => FALSE,
            "post" => array(
                "type" => "page",
            )
        );
        $this->template->addMeta('title', 'New Page - Sab News');
        $this->template->addMeta('description', 'Create new page.');
        $this->template->show('dashboard/pages/new', $data, 'newpage', 'ADD_NEW_PAGE');
    }

    public function edit($page_id = "") {
        user_checks(["activeblog"], "blog");
        $page_array = $this->collection->select_row("posts", array("*"), array("user_id", "blog_id", "id", "type"), array("id" => $page_id, "type" => "page"));
        if (empty($page_array)) {
            next_page("blog/pages");
        } else {
            $data = array(
                'popup' => array('login'),
                "post" => is_array($page_array) ? $page_array : [],
                "update" => TRUE
            );
            $this->template->addMeta('title', 'Edit Page - Sab News');
            $this->template->addMeta('description', 'Edit Page.');
            $this->template->show('dashboard/pages/edit', $data, 'editpage', 'EDIT_PAGE');
        }
    }

}
