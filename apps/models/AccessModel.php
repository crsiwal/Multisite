<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: AccessModel.php
 *  Path: application/models/AccessModel.php
 *  Description: 
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/09/2020              Created

 *
 */

class AccessModel extends CI_Model {

    Public function __construct() {
        parent::__construct();
    }

    public function get($offset, $id) {
        try {
            $this->db->select("a.id, a.name, a.keyname, a.description as summery, ifnull(b.id,0) as gid, ifnull(b.name,'') as gname");
            $this->db->from('access as a');
            $this->db->join('access_groups as b', 'a.group_id = b.id', 'LEFT OUTER');
            if (!empty($id)) {
                $this->db->where("a.id", $this->db->escape_like_str(get_integer($id)));
            } else {
                $this->db->order_by('a.id', 'desc');
                $this->db->limit(100, $this->db->escape_like_str(get_integer($offset)));
            }
            $get = $this->db->get();
            $data = (!empty($id)) ? $get->row_array() : $get->result_array();
            return is_array($data) ? $data : [];
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function insert($access) {
        try {
            $data = array(
                "group_id" => isset($access["group"]) ? $access["group"] : 0,
                "name" => isset($access["name"]) ? $access["name"] : "",
                "keyname" => isset($access["keyname"]) ? $access["keyname"] : "",
                "description" => isset($access["desc"]) ? $access["desc"] : ""
            );
            $this->db->insert('access', $data);
            return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function update($access) {
        try {
            if (isset($access["id"])) {
                $data = array(
                    "group_id" => isset($access["group"]) ? $access["group"] : 0,
                    "name" => isset($access["name"]) ? $access["name"] : "",
                    "keyname" => isset($access["keyname"]) ? $access["keyname"] : "",
                    "description" => isset($access["desc"]) ? $access["desc"] : ""
                );
                $this->db->where('id', $access["id"]);
                $this->db->update('access', $data);
                return ($this->db->affected_rows() <= 1) ? $access["id"] : FALSE;
            }
            return FALSE;
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function delete($access) {
        try {
            if (isset($access["id"])) {
                $this->db->where('id', $access["id"]);
                $this->db->delete('access');
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
