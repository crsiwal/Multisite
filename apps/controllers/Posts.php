<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        next_page("blog/posts");
    }

    public function new() {
        user_checks(["activeblog"], "blog");
        $this->load->library('Category');
        $categories = $this->category->get(0, 0);
        $data = [
            'popup' => array('login'),
            "category" => $categories,
            "update" => FALSE,
            "post" => ["type" => "post"]
        ];
        $this->template->addMeta('title', 'New Post - Sab News');
        $this->template->addMeta('description', 'Create new post.');
        $this->template->show('dashboard/posts/new', $data, 'newpost', 'ADD_NEW_POST');
    }

    public function edit($post_id = "") {
        user_checks(["activeblog"], "blog");
        $this->load->library('Post');
        $post = $this->post->get_post($post_id);
        if (empty($post)) {
            next_page("blog/posts");
        } else {
            $this->load->library('Category');
            $categories = $this->category->get(0, 0);
            $post["tags"] = $this->post->get_tags($post_id);
            $data = [
                'popup' => array('login'),
                "post" => $post,
                "category" => $categories,
                "update" => TRUE,
            ];
            $this->template->addMeta('title', 'Edit Post - Sab News');
            $this->template->addMeta('description', 'Edit post.');
            $this->template->show('dashboard/posts/edit', $data, 'editpost', 'EDIT_POST');
        }
    }

}
