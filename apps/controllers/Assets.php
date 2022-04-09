<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Assets.php
 *  Path: application/controllers/Assets.php
 *  Description: Controller used for show webpage assets. 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         07/06/2019              Created

 *
 *  Copyright (c) 2018 - AdGyde Solutions Private Limited
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of AdGyde Solutions Private Limited.
 *  The intellectual and technical concepts contained herein
 *  are proprietary to AdGyde Solutions Private Limited and
 *  are considered trade secrets and/or confidential under Law
 *  Dissemination of this information or reproduction of this material,
 *  in whole or in part, is strictly forbidden unless prior written
 *  permission is obtained from AdGyde Solutions Private Limited.
 *
 */
if (!class_exists('Assets')) {

    class Assets extends CI_Controller {

        public function __construct() {
            parent::__construct();
        }

        public function config() {
            $config = [];
            $config["base_url"] = url("/", true);
            $config["page_name"] = $this->sessions->get_page();
            if (is_login()) {
                $config["user_id"] = $this->user->get_logged_in_user_id();
                $config["blog_id"] = $this->sessions->get_active_blog();
            }
            header('Content-Type: application/javascript');
            echo 'custom_config = ' . json_encode(array_merge($config, $this->config->item('js_config')));
        }

    }

}