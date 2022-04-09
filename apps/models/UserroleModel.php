<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: UserroleModel.php
 *  Path: application/models/UserroleModel.php
 *  Description: 
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         10/09/2020              Created
 *
 */
if (!class_exists('UserroleModel')) {

    class UserroleModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function get($offset, $id) {
            try {
                $this->db->select("id, name as role, keyname as rolekey, description as summery");
                $this->db->from('user_role');
                if (!empty($id)) {
                    $this->db->where("id", get_integer($id));
                }
                $this->db->order_by('id', 'desc');
                $this->db->limit(100, get_integer($offset));
                return (!empty($id)) ? $this->db->get()->row_array() : $this->db->get()->result_array();
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function insert($role) {
            try {
                $data = array(
                    "name" => isset($role["name"]) ? $role["name"] : "",
                    "keyname" => isset($role["keyname"]) ? $role["keyname"] : "",
                    "description" => isset($role["summery"]) ? $role["summery"] : "",
                );
                $this->db->insert('user_role', $data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update($role) {
            try {
                if (isset($role["id"])) {
                    $data = array(
                        "name" => isset($role["name"]) ? $role["name"] : "",
                        "keyname" => isset($role["keyname"]) ? $role["keyname"] : "",
                        "description" => isset($role["summery"]) ? $role["summery"] : "",
                    );
                    $this->db->where('id', $role["id"]);
                    $this->db->update('user_role', $data);
                    return ($this->db->affected_rows() <= 1) ? $role["id"] : FALSE;
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete($role) {
            try {
                if (isset($role["id"])) {
                    $this->db->where('id', $role["id"]);
                    $this->db->delete('user_role');
                    return ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

    }

}