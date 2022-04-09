<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: UserModel.php
 *  Path: application/models/UserModel.php
 *  Description: This is a user model this will used for comunicate with database for user action and requirements
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         16/04/2019              Created

 *
 */
if (!class_exists('UserModel')) {

    class UserModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function add_user($userData) {
            try {
                $this->db->insert('users', $userData);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update_user($userData) {
            try {
                if (isset($userData["id"])) {
                    $user_id = $userData["id"];
                    $this->db->where('id', $user_id);
                    $this->db->update('users', $userData);
                    return ($this->db->affected_rows() <= 1) ? $user_id : FALSE;
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function change_password($dbPassword, $user_id) {
            try {
                $this->db->where('id', $user_id);
                $this->db->set('reset', 'reset+1', FALSE);
                $this->db->update('users', array("password" => $dbPassword));
                return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function add_user_access_token($access_data) {
            try {
                $this->db->insert('access_token', $access_data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function count_user_blogs($user_id) {
            try {
                $this->db->where('user_id', $user_id);
                return $this->db->count_all_results('blogs');
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function get_user_by_namekey($user_namekey = FALSE) {
            return $this->get_user("username", $user_namekey);
        }

        public function get_user_by_id($user_id = FALSE) {
            return $this->get_user("id", $user_id);
        }

        public function get_user_by_email($user_email = FALSE) {
            return $this->get_user("email", $user_email);
        }

        public function get_access_token($user_id) {
            try {
                $this->db->select('id, access_token, refresh_token, today_posts');
                $this->db->from('access_token');
                $this->db->where("user_id", $user_id);
                $query = $this->db->get();
                return $query->row();
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update_user_access_token($user_id, $access_token, $refresh_token = NULL) {
            try {
                $data = array(
                    "access_token" => $access_token
                );
                if (!empty($refresh_token)) {
                    $data["refresh_token"] = $refresh_token;
                }
                $this->db->where('user_id', $user_id);
                $this->db->update('access_token', $data);
                return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function get_user_permissions($user_role) {
            try {
                $this->db->select('b.keyname');
                $this->db->from('access_role as a');
                $this->db->join('access as b', 'a.access_id = b.id');
                $where = array(
                    "a.role_id" => $user_role,
                    "a.enabled" => true,
                );
                $this->db->where($where);
                $query = $this->db->get();
                $permissions = $query->result_array();
                return (is_array($permissions) && count($permissions) > 0) ? array_column($permissions, "keyname") : [];
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return [];
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        private function get_user($key, $value) {
            try {
                $this->db->select("id, gid, first_name as fname, middle_name as mname, last_name as sirname, display_name as name, username, email, password, pic_url as picture, reg_date, last_active, user_role");
                $this->db->from('users');
                $this->db->where($key, $this->db->escape_like_str($value));
                $query = $this->db->get();
                return $query->row();
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

    }

}