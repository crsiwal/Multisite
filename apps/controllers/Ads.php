<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkLogin();
    }

    public function index() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login'),
        );
        $this->template->addMeta('title', 'Banners - Sab News');
        $this->template->addMeta('description', 'Show banners list.');
        $this->template->show('dashboard/banners/setup/list', $data, 'setupbanner', 'access');
    }

    public function adgroup() {
        user_checks(["activeblog"], "blog");
        $data = array(
            'popup' => array('login', 'adgroup'),
        );
        $this->template->addMeta('title', 'Ad Group - Sab News');
        $this->template->addMeta('description', 'Show Adgroup list.');
        $this->template->show('dashboard/ads/adgroup', $data, 'adgrouplist', 'VIEW_ADS_GROUP_LIST');
    }

    public function adsize() {
        user_checks(["activeblog"], "blog");
        $this->load->helper(array('form'));
        $data = array(
            'popup' => array('login', 'adsize'),
        );
        $this->template->addMeta('title', 'AdSize - Sab News');
        $this->template->addMeta('description', 'Show Adsize list.');
        $this->template->show('dashboard/ads/adsize', $data, 'adsizelist', 'VIEW_ADSIZE_LIST');
    }

}
