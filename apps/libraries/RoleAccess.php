<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: RoleAccess.php
 *  Path: application/libraries/RoleAccess.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         15/09/2020              Created
 *
 */

class RoleAccess {

    private $ci;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('RoleAccessModel', 'mod_roleaccess');
    }

    public function get($role_id) {
        return $this->ci->mod_roleaccess->get($role_id);
    }

    public function save() {
        $success = false;
        $this->ci->load->helper(array('form', 'security'));
        $this->ci->load->library('form_validation', NULL, 'form');
        $this->ci->form->set_rules('role_id', 'User Role', 'trim|required|min_length[1]|max_length[30]|xss_clean|is_exist[user_role.id]', array(
            'is_exist' => 'You have selected invalid user role.'
        ));
        if ($this->ci->form->run() != FALSE) {
            $role_access = array(
                "role_id" => $this->ci->input->post('role_id', true),
                "access_ids" => $this->ci->input->post('access', true)
            );
            $role_access["access_ids"] = $this->ci->mod_roleaccess->delete($role_access);
            $roleaccess_ids = $this->ci->mod_roleaccess->insert($role_access);
            if ($roleaccess_ids) {
                $success = true;
            } else {
                set_error("Unable to change access");
            }
        } else {
            set_input_error();
        }
        return array(
            "error" => !$success,
            "data" => ($success) ? "Access successfully changed" : get_error()
        );
    }

}
