<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Userrole.php
 *  Path: application/libraries/Userrole.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         10/09/2020              Created
 *  
 */
if (!class_exists('Userrole')) {

    class Userrole {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('UserroleModel', 'mod_userrole');
        }

        public function get($offset, $id) {
            return $this->ci->mod_userrole->get($offset, $id);
        }

        public function save() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('name', 'Role Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[user_role.name]', array(
                'is_unique' => 'This Role already exists.'
            ));
            $this->ci->form->set_rules('slug', 'Role key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[user_role.keyname]', array(
                'is_unique' => 'This Role key already exists.'
            ));
            if ($this->ci->form->run() != FALSE) {
                $userrole = array(
                    "name" => $this->ci->input->post('name', true),
                    "keyname" => $this->ci->input->post('slug', true),
                    "summery" => $this->ci->input->post('desc', true)
                );
                $userrole_id = $this->ci->mod_userrole->insert($userrole);
                if ($userrole_id) {
                    $success = true;
                } else {
                    set_error("Unable to add this role");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Role successfully added" : get_error()
            );
        }

        public function update() {
            $success = false;
            $this->ci->load->helper(array('form', 'security'));
            $this->ci->load->library('form_validation', NULL, 'form');
            $this->ci->form->set_rules('id', 'Role', 'trim|xss_clean|required|min_length[1]');
            $id = $this->ci->input->post('id', true);
            $name = $this->ci->input->post('name', true);
            $slug = $this->ci->input->post('slug', true);
            $userrole = $this->get(0, $id);
            if (isset($userrole["role"]) && $userrole["role"] != $name) {
                $this->ci->form->set_rules('name', 'Role Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[user_role.name]', array(
                    'is_unique' => 'This Role already exists.'
                ));
            }
            if (isset($userrole["rolekey"]) && $userrole["rolekey"] != $slug) {
                $this->ci->form->set_rules('slug', 'Role key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[user_role.keyname]', array(
                    'is_unique' => 'This Role key already exists.'
                ));
            }
            if ($this->ci->form->run() != FALSE) {
                $userrole = [
                    "id" => $id,
                    "name" => $name,
                    "keyname" => $slug,
                    "summery" => $this->ci->input->post('desc', true)
                ];
                if ($this->ci->mod_userrole->update($userrole)) {
                    $success = true;
                } else {
                    set_error("Unable to update this role");
                }
            } else {
                set_input_error();
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Role successfully updated" : get_error()
            );
        }

        public function delete() {
            $success = false;
            $userrole = array(
                "id" => $this->ci->input->input_stream('id', TRUE)
            );
            if ($this->ci->collection->exist("user_role", array("id"), ["id" => $userrole["id"]])) {
                $success = ($this->ci->mod_userrole->delete($userrole)) ? TRUE : FALSE;
            }
            return array(
                "error" => !$success,
                "data" => ($success) ? "Deleted Successfully" : "Unable to delete"
            );
        }

    }

}
