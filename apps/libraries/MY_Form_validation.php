<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    function __construct($rules = array()) {
        parent::__construct($rules);
    }

    function valid_array_element($str, $allowed_string) {
        $allowed = explode(';', $allowed_string);
        if (in_array($str, $allowed)) {
            return TRUE;
        } else {
            $this->set_message('valid_array_element', '%s');
            return FALSE;
        }
    }

    function is_exist($str, $field) {
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() !== 0) : FALSE;
    }

    function not_exist($str, $field) {
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0) : FALSE;
    }

}
