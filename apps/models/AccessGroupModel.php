<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: AccessGroupModel.php
 *  Path: application/models/AccessGroupModel.php
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

class AccessGroupModel extends CI_Model {

    Public function __construct() {
        parent::__construct();
    }

    public function get($offset, $id) {
        try {
            $this->db->select("id, name, keyname, description as summery");
            $this->db->from('access_groups');
            if (!empty($id)) {
                $this->db->where("id", get_integer($id));
            } else {
                $this->db->order_by('id', 'desc');
                $this->db->limit(100, get_integer($offset));
            }
            $get = $this->db->get();
            return (!empty($id)) ? $get->row_array() : $get->result_array();
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function insert($group) {
        try {
            $data = array(
                "name" => isset($group["name"]) ? $group["name"] : "",
                "keyname" => isset($group["keyname"]) ? $group["keyname"] : "",
                "description" => isset($group["summery"]) ? $group["summery"] : "",
            );
            $this->db->insert('access_groups', $data);
            return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function update($group) {
        try {
            if (isset($group["id"])) {
                $data = array(
                    "name" => isset($group["name"]) ? $group["name"] : "",
                    "keyname" => isset($group["keyname"]) ? $group["keyname"] : "",
                    "description" => isset($group["summery"]) ? $group["summery"] : "",
                );
                $this->db->where('id', $group["id"]);
                $this->db->update('access_groups', $data);
                return ($this->db->affected_rows() <= 1) ? $group["id"] : FALSE;
            }
            return FALSE;
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function delete($group) {
        try {
            if (isset($group["id"])) {
                $this->db->where('id', $group["id"]);
                $this->db->delete('access_groups');
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
