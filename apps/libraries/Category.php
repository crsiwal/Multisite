<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Category.php
 *  Path: application/libraries/Category.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/02/2020              Created
 *
 */
if (!class_exists('Category')) {

    class Category {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('CategoryModel', 'mod_cat');
        }

        public function get($offset = 0, $parent = "", $id = 0) {
            return $this->ci->mod_cat->get($offset, $parent, $id);
        }

        public function save() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('name', 'Category Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[category.name]', array(
                'is_unique' => 'This category already exists.'
            ));
            $this->ci->form->set_rules('slug', 'Category Slug', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[category.slug]', array(
                'is_unique' => 'This category slug already exists.'
            ));
            $this->ci->form->set_rules('parent', 'Parent Category', 'trim|xss_clean|required|min_length[1]');
            if ($this->ci->form->run() != FALSE) {
                $name = $this->ci->input->post('name', true);
                $slug = $this->ci->input->post('slug', true);
                $parent = $this->ci->input->post('parent', true);
                $category = ["name" => $name, "slug" => $slug, "parent" => $parent];
                $cat_id = $this->ci->mod_cat->insert($category);
                if ($cat_id) {
                    $success = true;
                } else {
                    $this->ci->sessions->set_error("Unable to add this blog");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Category successfully added" : $this->ci->sessions->get_error()
            );
        }

        public function update() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('id', 'Category', 'trim|xss_clean|required|min_length[1]');
            $this->ci->form->set_rules('name', 'Category Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[category.name]', array(
                'is_unique' => 'This category %s already exists.'
            ));
            $this->ci->form->set_rules('slug', 'Category Slug', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[category.slug]', array(
                'is_unique' => 'This category slug %s already exists.'
            ));
            $this->ci->form->set_rules('parent', 'Parent Category', 'trim|xss_clean|required|min_length[1]');
            if ($this->ci->form->run() != FALSE) {
                $id = $this->ci->input->post('id', true);
                $name = $this->ci->input->post('name', true);
                $slug = $this->ci->input->post('slug', true);
                $parent = $this->ci->input->post('parent', true);
                $category = ["id" => $id, "name" => $name, "slug" => $slug, "parent" => $parent];
                if ($this->ci->mod_cat->update($category)) {
                    $success = true;
                } else {
                    $this->ci->sessions->set_error("Unable to add this blog");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Category successfully added" : $this->ci->sessions->get_error()
            );
        }

        public function delete() {
            $success = false;
            $post = array(
                "id" => $this->ci->input->input_stream('id', TRUE)
            );
            if ($this->ci->collection->exist("category", array("user_id", "id"), ["id" => $post["id"]])) {
                $success = ($this->ci->mod_cat->delete($post)) ? TRUE : FALSE;
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Deleted Successfully" : "Unable to delete"
            );
        }

    }

}
