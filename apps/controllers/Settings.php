<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        next_page("settings/account");
    }

    public function account() {
        $data = array(
            'popup' => array('login')
        );
        $this->template->addMeta('title', 'Account Settings - Sab News');
        $this->template->addMeta('description', 'Change account details');
        $this->template->sidebar('left', FALSE);
        $this->template->show('dashboard/settings/account', $data, 'stgaccount', 'ACCOUNT_SETTINGS');
    }

    public function password() {
        $data = array(
            'popup' => array('login')
        );
        $this->template->addMeta('title', 'Change Password - Sab News');
        $this->template->addMeta('description', 'Change user password');
        $this->template->sidebar('left', FALSE);
        $this->template->show('dashboard/settings/password', $data, 'stgpass', 'CHANGE_PASSWORD');
    }

}
