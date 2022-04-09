<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: AccessGroup.php
 *  Path: application/libraries/AccessGroup.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         10/09/2020              Created
 *
 */

class AccessGroup {

    private $ci;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('AccessGroupModel', 'mod_agroup');
    }

    public function get($offset, $id) {
        return $this->ci->mod_agroup->get($offset, $id);
    }

    public function save() {
        $success = false;
        $this->ci->load->helper(array('form', 'security'));
        $this->ci->load->library('form_validation', NULL, 'form');
        $this->ci->form->set_rules('name', 'Group Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access_groups.name]', array(
            'is_unique' => 'This Group already exists.'
        ));
        $this->ci->form->set_rules('slug', 'Group key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access_groups.keyname]', array(
            'is_unique' => 'This Group key already exists.'
        ));
        if ($this->ci->form->run() != FALSE) {
            $agroup = array(
                "name" => $this->ci->input->post('name', true),
                "keyname" => $this->ci->input->post('slug', true),
                "summery" => $this->ci->input->post('desc', true)
            );
            $agroup_id = $this->ci->mod_agroup->insert($agroup);
            if ($agroup_id) {
                $success = true;
            } else {
                set_error("Unable to add this group");
            }
        } else {
            set_input_error();
        }
        return array(
            "error" => !$success,
            "data" => ($success) ? "Group successfully added" : get_error()
        );
    }

    public function update() {
        $success = false;
        $this->ci->load->helper(array('form', 'security'));
        $this->ci->load->library('form_validation', NULL, 'form');
        $this->ci->form->set_rules('id', 'Group', 'trim|xss_clean|required|min_length[1]');
        $id = $this->ci->input->post('id', true);
        $name = $this->ci->input->post('name', true);
        $slug = $this->ci->input->post('slug', true);
        $agroup = $this->get(0, $id);
        if (isset($agroup["name"]) && $agroup["name"] != $name) {
            $this->ci->form->set_rules('name', 'Role Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access_groups.name]', array(
                'is_unique' => 'This Group already exists.'
            ));
        }
        if (isset($agroup["keyname"]) && $agroup["keyname"] != $slug) {
            $this->ci->form->set_rules('slug', 'Role key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access_groups.keyname]', array(
                'is_unique' => 'This Group key already exists.'
            ));
        }
        if ($this->ci->form->run() != FALSE) {
            $agroup = [
                "id" => $id,
                "name" => $name,
                "keyname" => $slug,
                "summery" => $this->ci->input->post('desc', true)
            ];
            if ($this->ci->mod_agroup->update($agroup)) {
                $success = true;
            } else {
                set_error("Unable to add this role");
            }
        } else {
            set_input_error();
        }
        return array(
            "error" => !$success,
            "data" => ($success) ? "Group successfully updated" : get_error()
        );
    }

    public function delete() {
        $success = false;
        $agroup = array(
            "id" => $this->ci->input->input_stream('id', TRUE)
        );
        if ($this->ci->collection->exist("access_groups", array("id"), ["id" => $agroup["id"]])) {
            $success = ($this->ci->mod_agroup->delete($agroup)) ? TRUE : FALSE;
        }
        return array(
            "error" => !$success,
            "data" => ($success) ? "Deleted Successfully" : "Unable to delete"
        );
    }

}
