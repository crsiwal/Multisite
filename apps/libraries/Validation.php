<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Validation.php
 *  Path: application/libraries/Validation.php
 *  Description: This class is usefull for validate input fields based on validation type
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         16/04/2019              Created
 *
 */
if (!class_exists('Validation')) {

    class Validation {

        private $ci;

        public function __construct() {
            $this->ci = & get_instance();
        }

        public function isValid($input, $tests = array(), $values = array()) {
            $isvalid = TRUE;
            foreach ($tests as $test) {
                switch ($test) {
                    case 'required':
                        if ($input === NULL) {
                            $isvalid = FALSE;
                        }
                        break;
                    case 'blank':
                        if ($input == "") {
                            $isvalid = FALSE;
                        }
                        break;
                    case 'minlength':
                        $validLength = isset($values[$test]) ? $values[$test] : 10;
                        if (strlen($input) < $validLength) {
                            $isvalid = FALSE;
                        }
                        break;
                    case 'maxlength':
                        $validLength = isset($values[$test]) ? $values[$test] : 10;
                        if (strlen($input) > $validLength) {
                            $isvalid = FALSE;
                        }
                        break;
                    case 'inlist':
                        $inListArray = isset($values[$test]) ? $values[$test] : [];
                        if (!(is_array($inListArray) && in_array($input, $inListArray))) {
                            $isvalid = FALSE;
                        }
                        break;
                    case 'unique':
                        $arrayList = [];
                        if (is_array($input)) {
                            foreach ($input as $value) {
                                if ($value != "") {
                                    if (in_array($value, $arrayList)) {
                                        $isvalid = FALSE;
                                        break;
                                    } else {
                                        array_push($arrayList, $value);
                                    }
                                }
                            }
                        }
                        break;
                    case 'isarray':
                        if (!is_array($input)) {
                            $isvalid = FALSE;
                        }
                        break;
                    case 'minarraylength':
                        $minLength = isset($values[$test]) ? $values[$test] : 1;
                        if (is_array($input) && count($input) < $minLength) {
                            $isvalid = FALSE;
                        }
                        break;
                }
                if ($isvalid == FALSE) {
                    return FALSE;
                }
            }
            return TRUE;
        }

    }

}