<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: ApiLibrary.php
 *  Path: application/controllers/ApiLibrary.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         24/01/2020              Created
 *
 */
if (!class_exists('RestApi')) {

    class RestApi {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
        }

        public function check_login() {
            if (!is_login()/* || !$this->ci->input->is_ajax_request() */) {
                $this->ci->user->logged_out_user();
                $this->response(base_url("/login"), FALSE, FALSE, TRUE);
            }
        }

        public function response($response, $error = FALSE, $data = array(), $redirect = FALSE) {
            $error = (is_array($response) && isset($response["error"]) && $response["error"] == TRUE) ? TRUE : $error;
            $response = (is_array($response) && isset($response["error"]) && isset($response["data"])) ? $response["data"] : $response;
            $send = [
                "status" => ($error) ? 'false' : 'true',
                "logout" => (is_login()) ? 'false' : 'true',
                "action" => (!$redirect) ? "process" : "redirect",
                (!$error) ? 'data' : ((!$redirect) ? "msg" : "url") => $response,
            ];
            if (is_array($data) && count($data) > 0) {
                $send = array_merge($send, $data);
            }
            $this->output($send);
        }

        /**
         * Convert array to json for send response to request
         * @param type $result
         */
        public function output($result = array()) {
            header('Content-Type: application/json');
            echo json_encode($result);
            die();
        }

    }

}
