<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        user_checks(["noblog", "removeblog"], "setup/blog");
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'Blogs - Sab News');
        $this->template->addMeta('description', 'These are user blogs.');
        $this->template->header('blank');
        $this->template->sidebar('left', FALSE);
        $this->template->show('dashboard/blogs/list', $data, 'bloggrid', 'VIEW_BLOG_LIST');
    }

    public function summery() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login')
        );
        $this->template->addMeta('title', 'Summery - Sab News');
        $this->template->addMeta('description', 'All Summery of blog');
        $this->template->show('dashboard/home/summery', $data, 'summery', 'VIEW_SUMMERY');
    }

    public function posts() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'Posts - Sab News');
        $this->template->addMeta('description', 'Show post list.');
        $this->template->show('dashboard/posts/list', $data, 'postlist', 'VIEW_POST_LIST');
    }

    public function videos() {
        user_checks(["activeblog"], "blog");
        $data = array();
        $this->template->addMeta('title', 'Videos - Sab News');
        $this->template->addMeta('description', 'Show Videos list.');
        $this->template->show('dashboard/videos/list', $data, 'videolist', 'VIEW_VIDEO_LIST');
    }

    public function pages() {
        user_checks(["activeblog"], "blog");
        $data = array();
        $this->template->addMeta('title', 'Pages - Sab News');
        $this->template->addMeta('description', 'Show Pages list.');
        $this->template->show('dashboard/pages/list', $data, 'pagelist', 'VIEW_PAGE_LIST');
    }

    public function images() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login', 'uploads'),
            'default' => "images"
        );
        $this->template->addMeta('title', 'Images - Sab News');
        $this->template->addMeta('description', 'Show images list.');
        $this->template->show('dashboard/uploads/list', $data, 'uploads', 'VIEW_IMAGE_LIST');
    }

    public function documents() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login', 'uploads'),
            'default' => "documents"
        );
        $this->template->addMeta('title', 'Documents - Sab News');
        $this->template->addMeta('description', 'Show Documents list.');
        $this->template->show('dashboard/uploads/list', $data, 'uploads', 'VIEW_DOCUMENT_LIST');
    }

    public function test() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'Test Page - Sab News');
        $this->template->addMeta('description', 'This is test page');
        $this->template->show('test', $data, 'testpage', 'VIEW_ADS_GROUP_LIST');
    }

}
