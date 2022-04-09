<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: AdminTools.php
 *  Path: application/controllers/AdminTools.php
 *  Description: 
 *
 */
if (!class_exists('Tools')) {

    class Tools extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->library('CliTools', NULL, 'cli');
            $this->cli->is_accessible();
            //$this->load->model('ToolsModel', 'cli_model');
        }

        public function index() {
            $this->cli->processFromCommandLine();
            // Silent is golden
        }

    }

}