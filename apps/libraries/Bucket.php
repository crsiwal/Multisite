<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Bucket.php
 *  Path: application/libraries/Bucket.php
 *  Description: 
 *  This library used for save file in cloud
 *  
 *  How to Use IMGUR Bucket.
 *  $binary = new CURLFile(path($data["path"]), 'application/octet-string');
 *  $imgur = $this->ci->bucket->upload($binary, "IMGUR");
 *  
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         28/01/2020              Created
 *
 */
if (!class_exists('Bucket')) {

    class Bucket {

        private $ci;
        private $bucket;

        function __construct() {
            $this->ci = & get_instance();
        }

        public function upload($file, $bucket = "HOST") {
            $response = FALSE;
            $this->set_bucket($bucket);
            switch ($this->bucket) {
                case "IMGUR":
                    $response = $this->uploadToImgur($file);
                    break;
                case "GPHOTOS":
                    $response = $this->uploadToGooglePhotos($file);
                    break;
                case "HOST" :
                    $file_path = (isset($file["path"])) ? $file["path"] : "public/tmp";
                    $response = (isset($file["file"])) ? $this->uploadToHost($file["file"], $file_path) : FALSE;
                    break;
            }
            return $response;
        }

        public function set_bucket($bucket) {
            $buckets = ["IMGUR", "HOST", "GPHOTOS"];
            $this->bucket = (in_array(strtoupper($bucket), $buckets)) ? strtoupper($bucket) : FALSE;
        }

        private function uploadToGooglePhotos($file) {
            if (isset($file["file"])) {
                $this->ci->load->library('GooglePhotos');
                $url = $this->ci->googlephotos->upload($file);
            }
            return FALSE;
        }

        private function uploadToImgur($binary) {
            $request = array(
                "url" => $this->ci->config->item('imgur-endpoint') . "image",
                "fields" => array('image' => $binary)
            );
            $header = ['Authorization: Client-ID ' . $this->ci->config->item('imgur_clientid')];
            $image = $this->ci->curl->post($request, $header, TRUE);
            return (isset($image["success"]) && $image["success"] == TRUE && isset($image["data"]["link"])) ? array("src" => $image["data"]["link"], 'w' => $image["data"]["width"], 'h' => $image["data"]["height"]) : FALSE;
        }

        private function uploadToHost($field_name, $file_path) {
            $options = array(
                'file_name' => unique_key(),
                'upload_path' => path($file_path),
                'allowed_types' => 'gif|jpg|png|jpeg|pdf',
                'overwrite' => false,
                'max_size' => (1024 * 5)
            );
            $this->ci->load->library('upload', $options);
            if ($this->ci->upload->do_upload($field_name)) {
                return $this->ci->upload->data();
            }
            return $this->ci->upload->display_errors();
        }

    }

}