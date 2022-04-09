<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Blogs.php
 *  Path: application/libraries/Blogs.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/02/2020              Created
 *
 */
if (!class_exists('Blogs')) {

    class Blogs {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('BlogModel', 'mod_blog');
        }

        public function new_blog() {
            $success = false;
            $this->ci->load->helper(array('form'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('name', 'Blog Name', 'trim|required|min_length[5]|max_length[64]');
            $this->ci->form->set_rules('url', 'Blog Address', 'trim|required|min_length[5]|max_length[32]|is_unique[blogs.username]', array(
                'is_unique' => 'Sorry, this blog address is not available.'
            ));
            $this->ci->form->set_rules('category', 'Blog Category', 'trim|required|min_length[1]');
            $this->ci->form->set_rules('theme', 'Blog Theme', 'trim|required|min_length[1]');
            if ($this->ci->form->run() != FALSE) {
                $blog_details = array(
                    "name" => $this->ci->input->post('name', true),
                    "url" => $this->ci->input->post('url', true),
                    "category_id" => $this->ci->input->post('category', true),
                    "theme" => $this->ci->input->post('theme', true),
                    "desc" => $this->ci->input->post('desc', true),
                );
                $blog_id = $this->ci->mod_blog->new_user_blog($blog_details);
                $this->action_blog_create($blog_id);
                $success = true;
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Blog successfully created" : get_error()
            );
        }

        public function check_url_available() {
            $success = false;
            $this->ci->load->helper(array('form'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_data(array(
                'url' => $this->ci->input->put('url', TRUE),
            ));
            $this->ci->form->set_rules('url', 'Blog Address', 'trim|required|min_length[5]|max_length[30]|is_unique[blogs.username]', array(
                'is_unique' => 'Sorry, this blog address is not available.'
            ));
            if ($this->ci->form->run() != FALSE) {
                $success = true;
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Address available" : get_error()
            );
        }

        public function edit_user_blog() {
            
        }

        /** Do not delete record. Only marked delete * */
        public function remove_user_blog() {
            
        }

        public function get_user_blogs($user_id = NULL, $blog_id = NULL) {
            $_user_id = (empty($user_id)) ? get_logged_in_user_id() : $user_id;
            if (!empty($_user_id)) {
                return $this->ci->mod_blog->get_user_blogs($_user_id, $blog_id);
            }
            return FALSE;
        }

        private function action_blog_create($blog_id) {
            
        }

    }

}
