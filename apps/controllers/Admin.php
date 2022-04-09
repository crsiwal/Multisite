<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        user_checks(["activeblog"], "blog", "blog");
    }

    public function users() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'Users - Sab News');
        $this->template->addMeta('description', 'Show user list.');
        $this->template->show('dashboard/users/list', $data, 'setupuser', 'access');
    }

    public function userrole() {
        user_checks([], "blog");
        $data = array(
            'popup' => array('login', 'userrole'),
        );
        $this->template->addMeta('title', 'User Role - Sab News');
        $this->template->addMeta('description', 'Show User Roles list.');
        $this->template->show('dashboard/access/userrole', $data, 'userroles', 'VIEW_USER_ROLE_LIST');
    }

    public function roleaccess($role_id = 0) {
        user_checks([], "blog");
        $data = array(
            'popup' => array('login'),
            'role_id' => $role_id
        );
        $this->template->addMeta('title', 'User Role Access - Sab News');
        $this->template->addMeta('description', 'Change the user role access.');
        $this->template->show('dashboard/access/roleaccess', $data, 'roleaccess', 'CHANGE_USER_ROLE_ACCESS');
    }

    public function access() {
        user_checks([], "blog");
        $data = array(
            'popup' => array('login', 'access'),
        );
        $this->template->addMeta('title', 'Access - Sab News');
        $this->template->addMeta('description', 'Show Access names list');
        $this->template->show('dashboard/access/accesslist', $data, 'access', 'VIEW_ACCESS_LIST');
    }

    public function accessGroup() {
        user_checks([], "blog");
        $data = array(
            'popup' => array('login', 'accessgroup'),
        );
        $this->template->addMeta('title', 'Access Group - Sab News');
        $this->template->addMeta('description', 'Show Access Group list.');
        $this->template->show('dashboard/access/groups', $data, 'accessgroup', 'VIEW_ACCESS_GROUP_LIST');
    }

}
