<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: YouTube.php
 *  Path: application/libraries/YouTube.php
 *  Description: 
 *  This library for Youtube Communication
 *  
 *  
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         06/06/2020              Created
 *
 */
if (!class_exists('YouTube')) {

    class YouTube {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
        }

        public function video($id = "") {
            $cache = $this->cache($id);
            if (!$cache) {
                $url = $this->ci->config->item('yt-endpoint') . "videos";
                $data = array(
                    "part" => "snippet",
                    "id" => $id,
                    "key" => $this->ci->config->item('g-apikey')
                );
                $response = $this->response($url, $data);
                $this->ci->logger->info(json_encode($response));
                if (!empty($response) && isset($response["items"][0]["snippet"])) {
                    $data = $response["items"][0]["snippet"];
                    $this->cache($id, $data);
                    return $data;
                }
                return [];
            } else {
                return $cache;
            }
        }

        public function search($search = "") {
            if (empty($search) || strlen($search) <= 3) {
                return [];
            }
            $url = $this->ci->config->item('yt-endpoint') . "search";
            $data = array(
                "part" => "snippet",
                "q" => $search,
                "maxResults" => 50,
                "type" => "video",
                "key" => $this->ci->config->item('g-apikey')
            );
            $response = $this->response($url, $data);
            $this->ci->logger->info(json_encode($response));
            return (!empty($response) && isset($response["items"])) ? $response["items"] : [];
        }

        private function response($url, $data = [], $header = [], $method = "GET") {
            $response = FALSE;
            $request = array("url" => $url, "fields" => $data);
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
            return $response;
        }

        private function cache($video_id, $save = FALSE) {
            return (!$save) ? $this->ci->sessions->get_youtube_cache($video_id) : $this->ci->sessions->set_youtube_cache($video_id, $save);
        }

    }

}