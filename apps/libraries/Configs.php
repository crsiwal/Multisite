<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Configs.php
 *  Path: application/libraries/Configs.php
 *  Description: This is config data management library
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         26/06/2020              Created
 *
 */

if (!class_exists('Configs')) {

    class Configs {

        private $ci;
        private $dbKey;

        public function __construct() {
            $this->ci = & get_instance();
            $this->ci->load->model('ConfigsModel', 'mod_config');
            $this->dbKey = array(
                'default_user_role' => '_db_config_default_user_role',
            );
        }

        /*
         * Getter and Setter For Default User Role
         */

        public function get_default_user_role() {
            return $this->get("default_user_role", 0, 0);
        }

        public function set_default_user_role($default_role) {
            return $this->set("default_user_role", $default_role, 0, 0);
        }

        /**
         * 
         * @param type $key
         * @param type $blog_id
         * @param type $user_id
         * @return type
         */
        private function get($key, $blog_id = FALSE, $user_id = FALSE) {
            if (isset($this->dbKey[$key])) {
                $blog_id = (!$blog_id) ? get_active_blog_id() : $blog_id;
                $user_id = (!$user_id) ? get_logged_in_user_id() : $user_id;
                return $this->ci->collection->select_value("system_config", array("value"), array("user_id", "blog_id", "setting"), ["setting" => $this->dbKey[$key], "blog_id" => $blog_id, "user_id" => $user_id]);
            } else {
                $this->ci->logger->error(__METHOD__, "$key is not allowed");
                return NULL;
            }
        }

        /**
         * 
         * @param type $key
         * @param type $value
         * @param type $user
         * @param type $blog
         * @return type
         */
        private function set($key, $value, $blog_id = FALSE, $user_id = FALSE) {
            if (isset($this->dbKey[$key])) {
                $config = array(
                    "user_id" => (!$user_id) ? get_logged_in_user_id() : $user_id,
                    "blog_id" => (!$blog_id) ? get_active_blog_id() : $blog_id,
                    "setting" => $this->dbKey[$key],
                    "value" => $value
                );
                $config_id = $this->ci->collection->select_value("system_config", array("id"), array("user_id", "blog_id", "setting"), ["setting" => $this->dbKey[$key], "blog_id" => $config["blog_id"], "user_id" => $config["user_id"]]);
                if (empty($config_id)) {
                    return $this->ci->mod_config->insert($config);
                } else {
                    return $this->ci->mod_config->update($config_id, $value);
                }
            } else {
                $this->ci->logger->error(__METHOD__, "$key is not allowed");
                return FALSE;
            }
        }

        private function update($key, $value, $blog_id = FALSE, $user_id = FALSE) {
            if (isset($this->dbKey[$key])) {
                $blog_id = (!$blog_id) ? get_active_blog_id() : $blog_id;
                $user_id = (!$user_id) ? get_logged_in_user_id() : $user_id;
                $config_id = $this->ci->collection->select_value("system_config", array("id"), array("user_id", "blog_id", "setting"), ["setting" => $this->dbKey[$key], "blog_id" => $blog_id, "user_id" => $user_id]);
                if (empty($config_id)) {
                    return FALSE;
                } else {
                    return $this->ci->mod_config->update($config_id, $value);
                }
            } else {
                $this->ci->logger->error(__METHOD__, "$key is not allowed");
                return FALSE;
            }
        }

        private function increase($key, $value, $increase = 1, $blog_id = FALSE, $user_id = FALSE) {
            if (isset($this->dbKey[$key])) {
                $blog_id = (!$blog_id) ? get_active_blog_id() : $blog_id;
                $user_id = (!$user_id) ? get_logged_in_user_id() : $user_id;
                $config_id = $this->ci->collection->select_value("system_config", array("id"), array("user_id", "blog_id", "setting"), ["setting" => $this->dbKey[$key], "blog_id" => $blog_id, "user_id" => $user_id]);
                if (empty($config_id)) {
                    return FALSE;
                } else {
                    return $this->ci->mod_config->countChange($config_id, $increase);
                }
            } else {
                $this->ci->logger->error(__METHOD__, "$key is not allowed");
                return FALSE;
            }
        }

        private function decrease($key, $value, $decrease = 1, $blog_id = FALSE, $user_id = FALSE) {
            if (isset($this->dbKey[$key])) {
                $blog_id = (!$blog_id) ? get_active_blog_id() : $blog_id;
                $user_id = (!$user_id) ? get_logged_in_user_id() : $user_id;
                $config_id = $this->ci->collection->select_value("system_config", array("id"), array("user_id", "blog_id", "setting"), ["setting" => $this->dbKey[$key], "blog_id" => $blog_id, "user_id" => $user_id]);
                if (empty($config_id)) {
                    return FALSE;
                } else {
                    return $this->ci->mod_config->countChange($config_id, $decrease, FALSE);
                }
            } else {
                $this->ci->logger->error(__METHOD__, "$key is not allowed");
                return FALSE;
            }
        }

    }

}