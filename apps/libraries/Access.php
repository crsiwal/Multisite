<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Access.php
 *  Path: application/libraries/Access.php
 *  Description: 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/09/2020              Created
 *
 */

class Access {

    private $ci;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('AccessModel', 'mod_access');
    }

    public function get($offset, $id) {
        return $this->ci->mod_access->get($offset, $id);
    }

    public function save() {
        $success = false;
        $this->ci->load->helper(array('form', 'security'));
        $this->ci->load->library('form_validation', NULL, 'form');
        $this->ci->form->set_rules('name', 'Group Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access.name]', array(
            'is_unique' => 'This Access already exists.'
        ));
        $this->ci->form->set_rules('slug', 'Group key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access.keyname]', array(
            'is_unique' => 'This Access key already exists.'
        ));
        if ($this->ci->form->run() != FALSE) {
            $access = array(
                "name" => $this->ci->input->post('name', true),
                "keyname" => $this->ci->input->post('slug', true),
                "group" => $this->ci->input->post('group', true),
                "desc" => $this->ci->input->post('desc', true)
            );
            $access_id = $this->ci->mod_access->insert($access);
            if ($access_id) {
                $success = true;
            } else {
                set_error("Unable to add this access");
            }
        } else {
            set_input_error();
        }
        return array(
            "error" => !$success,
            "data" => ($success) ? "Access successfully added" : get_error()
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
        $access = $this->get(0, $id);
        if (isset($access["name"]) && $access["name"] != $name) {
            $this->ci->form->set_rules('name', 'Group Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access.name]', array(
                'is_unique' => 'This Access already exists.'
            ));
        }
        if (isset($access["keyname"]) && $access["keyname"] != $slug) {
            $this->ci->form->set_rules('slug', 'Group key', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[access.keyname]', array(
                'is_unique' => 'This Access key already exists.'
            ));
        }
        if ($this->ci->form->run() != FALSE) {
            $access = array(
                "id" => $this->ci->input->post('id', true),
                "name" => $this->ci->input->post('name', true),
                "keyname" => $this->ci->input->post('slug', true),
                "group" => $this->ci->input->post('group', true),
                "desc" => $this->ci->input->post('desc', true)
            );
            if ($this->ci->mod_access->update($access)) {
                $success = true;
            } else {
                set_error("Unable to update this access");
            }
        } else {
            set_input_error();
        }
        return array(
            "error" => !$success,
            "data" => ($success) ? "Access successfully updated" : get_error()
        );
    }

    public function delete() {
        $success = false;
        $access = array(
            "id" => $this->ci->input->input_stream('id', TRUE)
        );
        if ($this->ci->collection->exist("access", array("id"), ["id" => $access["id"]])) {
            $success = ($this->ci->mod_access->delete($access)) ? TRUE : FALSE;
        }
        return array(
            "error" => !$success,
            "data" => ($success) ? "Deleted Successfully" : "Unable to delete"
        );
    }

}
