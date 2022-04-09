<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Pages.php
 *  Path: application/libraries/Pages.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         22/06/2020              Created
 *
 */
if (!class_exists('Pages')) {

    class Pages {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('PageModel', 'mod_page');
        }

        public function save() {
            $success = FALSE;
            $this->ci->load->helper(array('form'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('title', 'Title', 'trim|required|strip_tags|min_length[30]|max_length[256]');
            $this->ci->form->set_rules('editor', 'Content', 'trim|required|min_length[12]');
            $this->ci->form->set_rules('desc', 'Short Description', 'trim|required|strip_tags|min_length[30]|max_length[256]');
            if ($this->ci->form->run() != FALSE) {
                $page = array(
                    "title" => $this->ci->input->post('title', TRUE),
                    "slug" => $this->ci->input->post('slug', TRUE),
                    "content" => $this->ci->input->post('editor'),
                    "desc" => $this->ci->input->post('desc', TRUE),
                    "reference" => $this->ci->input->post('reference', TRUE),
                    "status" => (get_boolean_input('publish')) ? "publish" : "draft"
                );
                $page_id = $this->ci->mod_page->insert($page);
                if ($page_id) {
                    $success = TRUE;
                    set_msg(get_boolean_input('publish') ? "Page published successfully" : "Page saved successfully");
                } else {
                    set_error("Unable to create page right now.");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "saved" => $success,
                "data" => ($success) ? get_msg() : get_error()
            );
        }

        public function update() {
            $success = FALSE;
            $this->ci->load->helper(array('form'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('id', 'Post Id', 'trim|required|min_length[1]|max_length[10]');
            $this->ci->form->set_rules('title', 'Post title', 'trim|required|min_length[30]|max_length[256]');
            $this->ci->form->set_rules('editor', 'Post Content', 'trim|required|min_length[12]');
            $this->ci->form->set_rules('desc', 'Post Description', 'trim|required|min_length[30]|max_length[256]');
            if ($this->ci->form->run() != FALSE) {
                $page = array(
                    "id" => $this->ci->input->post('id', TRUE),
                    "title" => $this->ci->input->post('title', TRUE),
                    "slug" => $this->ci->input->post('slug', TRUE),
                    "content" => $this->ci->input->post('editor'),
                    "desc" => $this->ci->input->post('desc', TRUE),
                    "reference" => $this->ci->input->post('reference', TRUE),
                    "status" => (get_boolean_input('publish')) ? "publish" : "draft"
                );
                $page_id = $this->ci->mod_page->update($page);
                if ($page_id) {
                    $success = TRUE;
                    set_msg(get_boolean_input('publish') ? "Page published successfully" : "Page updated successfully");
                } else {
                    set_error("Unable to update this page");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "saved" => $success,
                "data" => ($success) ? get_msg() : get_error()
            );
        }

        public function delete() {
            $page = array(
                "id" => $this->ci->input->input_stream('id', TRUE)
            );
            $success = ($this->ci->mod_page->delete($page)) ? TRUE : FALSE;
            set_msg($success ? "Deleted Successfully" : "Unable to delete this page");
            return array(
                "error" => !$success,
                "data" => ($success) ? get_msg() : get_error()
            );
        }

    }

}