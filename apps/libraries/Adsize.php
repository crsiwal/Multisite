<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Adsize.php
 *  Path: application/libraries/Adsize.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         05/04/2020              Created
 *
 */
if (!class_exists('Adsize')) {

    class Adsize {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('AdsizeModel', 'mod_adsize');
        }

        public function get($offset = 0, $id = 0) {
            return $this->ci->mod_adsize->get($offset, $id);
        }

        public function save() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]|xss_clean');
            $this->ci->form->set_rules('sitekey', 'Site Key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[adsize.sitekey]', array(
                'is_unique' => 'This Site Key already exists.'
            ));
            $this->ci->form->set_rules('width', 'Ads Width', 'trim|xss_clean|required|min_length[1]');
            $this->ci->form->set_rules('height', 'Ads Height', 'trim|xss_clean|required|min_length[1]');
            if ($this->ci->form->run() != FALSE) {
                $name = $this->ci->input->post('name', true);
                $sitekey = $this->ci->input->post('sitekey', true);
                $width = $this->ci->input->post('width', true);
                $height = $this->ci->input->post('height', true);
                $adsize = ["name" => $name, "sitekey" => $sitekey, "width" => $width, "height" => $height];
                $ads_id = $this->ci->mod_adsize->insert($adsize);
                if ($ads_id) {
                    $success = true;
                } else {
                    $this->ci->sessions->set_error("Unable to add this adsize");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "AdSize successfully added" : $this->ci->sessions->get_error()
            );
        }

        public function update() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('id', 'AdSize', 'trim|xss_clean|required|min_length[1]');
            $this->ci->form->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]|xss_clean');
            $this->ci->form->set_rules('sitekey', 'Site Key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[adsize.sitekey]', array(
                'is_unique' => 'This Site Key already exists.'
            ));
            $this->ci->form->set_rules('width', 'Ads Width', 'trim|xss_clean|required|min_length[1]');
            $this->ci->form->set_rules('height', 'Ads Height', 'trim|xss_clean|required|min_length[1]');
            if ($this->ci->form->run() != FALSE) {
                $id = $this->ci->input->post('id', true);
                $name = $this->ci->input->post('name', true);
                $sitekey = $this->ci->input->post('sitekey', true);
                $width = $this->ci->input->post('width', true);
                $height = $this->ci->input->post('height', true);
                $adsize = ["id" => $id, "name" => $name, "sitekey" => $sitekey, "width" => $width, "height" => $height];
                if ($this->ci->mod_adsize->update($adsize)) {
                    $success = true;
                } else {
                    $this->ci->sessions->set_error("Unable to update this AdSize");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "AdSize successfully added" : $this->ci->sessions->get_error()
            );
        }

        public function delete() {
            $success = false;
            $post = array(
                "id" => $this->ci->input->input_stream('id', TRUE)
            );
            if ($this->ci->collection->exist("adsize", array("user_id", "id"), ["id" => $post["id"]])) {
                $success = ($this->ci->mod_adsize->delete($post)) ? TRUE : FALSE;
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Deleted Successfully" : "Unable to delete"
            );
        }

    }

}
