<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Uploads.php
 *  Path: application/libraries/Uploads.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         19/04/2020              Created
 *
 */
if (!class_exists('Uploads')) {

    class Uploads {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('UploadModel', 'mod_upload');
        }

        public function get($type = "i", $onlyme = TRUE, $onlyblog = TRUE, $offset = 0, $search = 0) {
            return $this->ci->mod_upload->get(NULL, $type, $onlyme, $onlyblog, $offset, $search);
        }

        public function upload() {
            $success = false;
            $this->ci->load->helper(array('security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('clnfile', 'File', 'trim|xss_clean');
            if ($this->ci->form->run() != FALSE) {
                $this->ci->load->library('Bucket');
                $file_route = get_logged_in_user_id() . "/" . get_active_blog_id();
                $file_path = "public/" . $file_route;
                $meta_data = $this->ci->bucket->upload(["path" => $file_path, "file" => "clnfile"]);
                if (isset($meta_data["file_name"])) {
                    $data = array(
                        "name" => empty($this->ci->input->post("name", true)) ? ((isset($meta_data["client_name"]) && !empty($meta_data["client_name"])) ? $meta_data["client_name"] : "") : $this->ci->input->post("name", true),
                        "privacy" => empty($this->ci->input->post("privacy", true)) ? "o" : $this->ci->input->post("privacy", true),
                        "tags" => is_array($this->ci->input->post("tags", true)) ? implode(",", $this->ci->input->post("tags", true)) : "",
                        "path" => $file_path . "/" . $meta_data["file_name"],
                        "is_image" => $meta_data["is_image"],
                        "file_type" => $meta_data["file_type"],
                        "file_size" => $meta_data["file_size"],
                        "image_width" => empty($meta_data["image_width"]) ? 0 : $meta_data["image_width"],
                        "image_height" => empty($meta_data["image_height"]) ? 0 : $meta_data["image_height"],
                        "url" => cdn_url($file_route . "/" . $meta_data["file_name"])
                    );
                    if ($this->ci->mod_upload->insert($data)) {
                        $success = true;
                    } else {
                        set_error("Unable to upload");
                    }
                } else {
                    set_error("Unable to upload");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? $data["url"] : get_error()
            );
        }

        public function delete() {
            $success = false;
            $post = array(
                "id" => $this->ci->input->input_stream('id', TRUE)
            );
            if ($this->ci->collection->exist("uploads", array("user_id", "id"), ["id" => $post["id"]])) {
                $success = ($this->ci->mod_upload->delete($post)) ? TRUE : FALSE;
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Deleted Successfully" : "Unable to delete"
            );
        }

    }

}
