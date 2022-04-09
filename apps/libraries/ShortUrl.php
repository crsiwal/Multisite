<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Bucket.php
 *  Path: application/libraries/ShortUrl.php
 *  Description: 
 *  This library used for short any large url using online service
 *  
 *  
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         28/01/2020              Created
 *
 */
if (!class_exists('ShortUrl')) {

    class ShortUrl {

        private $ci;
        private $service;

        function __construct() {
            $this->ci = & get_instance();
            $this->service = "BITLY";
        }

        public function set_bucket($service) {
            $this->service = (in_array(strtoupper($service), ["BITLY", "HOST"])) ? strtoupper($service) : "BITLY";
        }

        public function get($url) {
            $short_url = FALSE;
            switch ($this->service) {
                case "BITLY":
                    $short_url = $this->bitly_url($url);
                    break;
                case "HOST" :
                    $short_url = $this->host_url($url);
                    break;
            }
            return $short_url;
        }

        private function bitly_url($long_url) {
            if (is_string($long_url) && strlen($long_url) > 20) {
                $data = array();
                $this->ci->load->library('Curl');
                $request = array(
                    "url" => $this->ci->config->item('bitly_apiurl'),
                    "fields" => array(
                        'format' => 'json',
                        'apikey' => $this->ci->config->item('bitly_apikey'),
                        'login' => $this->ci->config->item('bitly_login'),
                        'longUrl' => $long_url
                    )
                );
                $urlContent = $this->ci->curl->run($request);
                return (isset($urlContent->status_code) && $urlContent->status_code == 200) ? $urlContent->data->url : '';
            }
            return "";
        }

    }

}