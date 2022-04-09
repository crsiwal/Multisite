<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Open.php
 *  Path: application/controllers/Open.php
 *  Description: Controller user for public api. 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/06/2020              Created
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
if (!class_exists('Open')) {

    class Open extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->library('RestApi');
        }

        public function print() {
            echo "<pre>";
            print_r($this->session);
            echo "</pre>";
        }

        public function unset($name) {
            var_dump($this->session->unset_userdata($name));
        }

        public function test() {
            $success = false;
            $this->load->helper(array('form', 'security'));
            $this->load->library('form_validation', NULL, 'form');
            $this->form->set_rules('role_id', 'Role ID', 'trim|required|min_length[1]|max_length[30]|xss_clean|is_exist[access.id]', array(
                'is_exist' => 'This key already exist'
            ));
            if ($this->form->run() != FALSE) {
                var_dump($this->input->post('access', true));
                $success = true;
            } else {
                set_input_error();
            }
            $this->restapi->response(array(
                "error" => !$success,
                "data" => ($success) ? "Success message" : get_error()
            ));
        }

        public function diff() {
            echo "<pre>";
            $one = [1, 2, 3, 4, 5, 6, 7];
            $two = [2, 3];
            $res = array_diff($one, $two);
            var_dump($one, $two, $res);
        }

    }

}