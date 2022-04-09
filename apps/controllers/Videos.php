<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        next_page("blog/videos");
    }

    public function search() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'Add new video - Sab News');
        $this->template->addMeta('description', 'Search new videos from enabled platforms like youtube etc.');
        $this->template->show('dashboard/videos/search', $data, 'searchvideo', 'SEARCH_VIDEOS');
    }

    public function new($source = "") {
        user_checks(["activeblog"], "blog");
        $explode = explode('-', $source, 2);
        $redirect = true;
        if (is_array($explode) && count($explode) == 2) {
            $this->load->library('Post');
            $video = $this->post->get_video_data($explode[0], $explode[1]);
            if (is_array($video) && isset($video["title"])) {
                $redirect = false;
                $this->load->library('Category');
                $categories = $this->category->get(0, 0);
                $data = array(
                    'popup' => array('login'),
                    "update" => FALSE,
                    "category" => $categories,
                    "post" => $this->post->retrive_post_data($video, $explode)
                );
                $this->template->addMeta('title', 'New Video Post - Sab News');
                $this->template->addMeta('description', 'Create new post.');
                $this->template->show('dashboard/videos/new', $data, 'newvideo', 'ADD_NEW_VIDEO');
            }
        }
        if ($redirect) {
            next_page("videos/search");
        }
    }

    public function edit($post_id = "") {
        user_checks(["activeblog"], "blog");
        $this->load->library('Post');
        $post = $this->post->get_post($post_id);
        if (empty($post)) {
            next_page("blog/videos");
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
            $this->template->show('dashboard/videos/edit', $data, 'editvideo', 'EDIT_VIDEO');
        }
    }

}
