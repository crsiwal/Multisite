<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: GooglePhotos.php
 *  Path: application/libraries/GooglePhotos.php
 *  Description: 
 *  This library used for handle request of Google Photos
 * 
 *  Functions List
 *  01. set_access_token($access_token = "")
 * 
 * 
 * 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         12/05/2020              Created
 *
 */
if (!class_exists('GooglePhotos')) {

    class GooglePhotos {

        private $ci;
        private $access_token;

        function __construct($access_token = "") {
            $this->ci = & get_instance();
            $this->ci->load->library('Google');
            $this->set_access_token($access_token);
        }

        public function set_access_token($access_token = "") {
            $this->access_token = (!empty($access_token)) ? $access_token : $this->ci->google->get_user_access_token();
        }

        public function upload($image) {
            return $this->uploadByte($image);
        }

        private function uploadByte($image) {
            $url = $this->ci->config->item('gp-endpoint') . "uploads";
            $header = ["X-Goog-Upload-Content-Type: " . (isset($image["mime"]) ? $image["mime"] : "image/jpeg")];
            $upload_token = $this->response($url, $image["file"], $header, "RAW");
            if (!empty($upload_token)) {
                $image = $this->createItem($image, $upload_token);
                var_dump($image);
            }
        }

        private function createItem($image, $upload_token) {
            $url = $this->ci->config->item('gp-endpoint') . "mediaItems:batchCreate";
            $data = array(
                "newMediaItems" => array(
                    array(
                        "description" => "This is test",
                        "simpleMediaItem" => array(
                            "fileName" => (isset($image["name"]) ? $image["name"] : unique_key()),
                            "uploadToken" => $upload_token
                        )
                    )
                )
            );
            return $this->response($url, $data, [], "POST");
        }

        private function response($url, $data = [], $header = [], $method = "GET") {
            $response = FALSE;
            if (!empty($this->access_token)) {
                $header[] = 'Authorization: OAuth ' . $this->access_token;
                $request = array(
                    "url" => $url,
                    "fields" => $data
                );
                switch (strtoupper($method)) {
                    case 'GET':
                        $response = $this->ci->curl->get($request, $header);
                        break;
                    case 'POST':
                        if (is_array($request["fields"])) {
                            $encoded = json_encode($request["fields"]);
                            $header[] = 'Content-Length: ' . strlen($encoded);
                        }
                        $response = $this->ci->curl->post($request, $header, TRUE, 'blogger_json');
                        break;
                    case 'RAW':
                        $header[] = "X-Goog-Upload-Protocol: raw";
                        $response = $this->ci->curl->raw($request, $header, FALSE, 'octet_stream');
                        break;
                }
            }
            return $response;
        }

    }

}