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
if (!class_exists('Adgroup')) {

    class Adgroup {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('AdgroupModel', 'mod_adg');
        }

        public function get($offset = 0, $id = 0) {
            return $this->ci->mod_adg->get($offset, $id);
        }

        public function save() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]|xss_clean');
            $this->ci->form->set_rules('desc', 'Description', 'trim|required|min_length[3]|max_length[64]|xss_clean');
            $this->ci->form->set_rules('platform', 'Ad Platform', 'trim|xss_clean|required|min_length[1]|max_length[1]');
            $this->ci->form->set_rules('adsize', 'Ad Size', 'trim|xss_clean|required|min_length[1]');
            if ($this->ci->form->run() != FALSE) {
                $name = $this->ci->input->post('name', true);
                $desc = $this->ci->input->post('desc', true);
                $platform = $this->ci->input->post('platform', true);
                $adsize = $this->ci->input->post('adsize', true);
                $adgroup = ["name" => $name, "desc" => $desc, "platform" => $platform, "adsize_id" => $adsize];
                $adg_id = $this->ci->mod_adg->insert($adgroup);
                if ($adg_id) {
                    $success = true;
                } else {
                    $this->ci->sessions->set_error("Unable to add this adgroup");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Added Successfully" : $this->ci->sessions->get_error()
            );
        }

        public function update() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('id', 'AdSize', 'trim|xss_clean|required|min_length[1]');
            $this->ci->form->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]|xss_clean');
            $this->ci->form->set_rules('desc', 'Description', 'trim|required|min_length[3]|max_length[64]|xss_clean');
            $this->ci->form->set_rules('platform', 'Ad Platform', 'trim|xss_clean|required|min_length[1]|max_length[1]');
            $this->ci->form->set_rules('adsize', 'Ad Size', 'trim|xss_clean|required|min_length[1]');
            if ($this->ci->form->run() != FALSE) {
                $id = $this->ci->input->post('id', true);
                $name = $this->ci->input->post('name', true);
                $desc = $this->ci->input->post('desc', true);
                $platform = $this->ci->input->post('platform', true);
                $adsize = $this->ci->input->post('adsize', true);
                $adgroup = ["id" => $id, "name" => $name, "desc" => $desc, "platform" => $platform, "adsize_id" => $adsize];
                if ($this->ci->mod_adg->update($adgroup)) {
                    $success = true;
                } else {
                    $this->ci->sessions->set_error("Unable to update this AdGroup");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Updated Successfully" : $this->ci->sessions->get_error()
            );
        }

        public function delete() {
            $success = false;
            $data = array(
                "id" => $this->ci->input->input_stream('id', TRUE)
            );
            if ($this->ci->collection->exist("adgroup", array("user_id", "id"), ["id" => $data["id"]])) {
                $success = ($this->ci->mod_adg->delete($data)) ? TRUE : FALSE;
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Deleted Successfully" : "Unable to delete"
            );
        }

    }

}
