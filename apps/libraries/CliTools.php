<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: CliTools.php
 *  Path: application/libraries/CliTools.php
 *  Description: 
 * 
 *
 */
if (!class_exists('CliTools')) {

    class CliTools {

        private $ci;

        function __construct() {
            $this->ci = & get_instance();
        }

        /**
         * 
         * @return boolean
         */
        public function is_accessible() {
            return ($this->ci->input->is_cli_request()) ? TRUE : die("Service is down");
        }


        public function mergeHeader($response, $header) {
            if (is_array($response) && is_array($header) && count($response) > 0) {
                if (count($response[0]) == count($header)) {
                    array_unshift($response, $header);
                    return $response;
                } else {
                    $this->ci->logger->error("CliTools::mergeHeader Diffrent length array found for merge header in array. Skiped merge");
                }
            }
            return $response;
        }


        /**
         * 
         * @param type $scale
         * @return type
         */
        public function processFromCommandLine($scale = "day") {
            $argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : array();
            $customArg = array(
                'start_date' => $this->getDate($scale),
                'end_date' => $this->getDate($scale, 'end'),
                'start_date_day' => "",
                'end_date_day' => "",
                'debug' => FALSE,
            );


            foreach ($argv as $i => $arg) {
                switch (strtolower($arg)) {
                    case '-help':
                        die($this->setHelpDescription());
                        break;
                    case '-sd':
                        $customArg['start_date'] = strtotime($argv[($i + 1)]);
                        break;
                    case '-ed':
                        $customArg['end_date'] = strtotime($argv[($i + 1)]);
                        break;
                    case '-debug':
                        $customArg['debug'] = TRUE;
                        break;
                }
            }
            if ($customArg['debug'] == TRUE) {
                echo "Configuration found: \n";
            }
        }

        /**
         * 
         */
        public function setHelpDescription() {
            echo "\nYou can use following action via command line.\n\n";
            echo "-dev              Set development environment. eg. -dev\n"
            . "-test             Set Testing environment. eg. -test\n"
            . "-prod             Set Production environment. eg. -prod\n"
            . "-sd               Set the start date. -st 2019-05-01\n"
            . "-ed               Set the end date.  -ed 2019-05-30\n"
            . "";
        }

        /**
         * 
         * @param type $value
         * @param type $compair
         * @return integer
         */
        private function getPercentage($value, $compair) {
            return ($value == 0 && $compair == 0 ) ? "0" : ( ($value != 0 && $compair == 0) ? "100" : sprintf('%0.2f', (($value - $compair) / $compair) * 100));
        }

        /**
         * 
         * @param type $scale
         */
        private function getDate($scale, $type = 'start') {
            switch ($scale) {
                case 'today':
                    $returnDate = strtotime("now");
                    break;
                case 'yesterday':
                    $returnDate = strtotime("-1 days");
                    break;
                case 'last2day':
                    $returnDate = ($type == 'start') ? strtotime("-2 days") : strtotime("-1 days");
                    break;
                case 'lastweek':
                    $returnDate = ($type == 'start') ? strtotime('last week') : strtotime("monday this week - 1 second");
                    break;
                case 'thisweek':
                    $returnDate = ($type == 'start') ? strtotime("monday this week") : strtotime("now");
                    break;
                case 'last7day':
                    $returnDate = ($type == 'start') ? strtotime("-7 days") : strtotime("-1 days");
                    break;
                case 'lastmonth':
                    $returnDate = ($type == 'start') ? strtotime("first day of last month") : strtotime("last day of last month");
                    break;
                case 'thismonth':
                    $returnDate = ($type == 'start') ? strtotime("first day of this month") : strtotime("now");
                    break;
                default:
                    $returnDate = strtotime("now");
                    break;
            }
            return $returnDate;
        }

    }

}