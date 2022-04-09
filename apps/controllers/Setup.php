<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        user_checks(["activeblog"], "blog", "blog");
    }

    public function blog() {
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'First Blog - Sab News');
        $this->template->addMeta('description', 'Add your first blog with sabnews');
        $this->template->header('blank');
        $this->template->sidebar('left', FALSE);
        $this->template->show('dashboard/blogs/setup/new', $data, 'blog_add', 'ADD_NEW_BLOG');
    }

    public function category() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login', 'category'),
        );
        $this->template->addMeta('title', 'Category - Sab News');
        $this->template->addMeta('description', 'Show category list.');
        $this->template->show('dashboard/category/setup/list', $data, 'categorylist', 'VIEW_CATEGORY_LIST');
    }

}
