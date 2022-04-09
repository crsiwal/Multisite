<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: RoleAccessModel.php
 *  Path: application/models/RoleAccessModel.php
 *  Description: 
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         16/09/2020              Created

 *
 */

class RoleAccessModel extends CI_Model {

    Public function __construct() {
        parent::__construct();
    }

    public function get($role_id) {
        try {
            if (!empty($role_id)) {
                $role = $this->db->escape_like_str(get_integer($role_id));
                $this->db->select("a.id, a.name, a.keyname, ifnull(b.id,'') as gid, ifnull(b.name,'Extra') as gname, ifnull(b.description,'') as summery, case c.enabled when true then '1' else '0' end as active");
                $this->db->from("access as a");
                $this->db->join('access_groups as b', 'a.group_id = b.id', 'LEFT');
                $this->db->join('access_role as c', "c.role_id = $role AND c.access_id = a.id", 'LEFT');
                $this->db->order_by('a.group_id, a.id');
                $query = $this->db->get();
                return ($query->num_rows() > 0) ? $query->result_array() : [];
            }
            return [];
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function delete($role_access) {
        try {
            $this->db->where('role_id', $role_access["role_id"]);
            if (count($role_access["access_ids"]) > 0) {
                $this->db->where_not_in('access_id', $role_access["access_ids"]);
            }
            $this->db->delete("access_role");
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
            $query = $this->db->select('access_id')->from('access_role')->where('role_id', $role_access["role_id"])->get();
            $existing = $query->result_array();
            $this->logger->debug(__METHOD__, json_encode($role_access["access_ids"]));
            $this->logger->debug(__METHOD__, json_encode($existing));
            return array_diff($role_access["access_ids"], (is_array($existing)) ? array_column($existing, "access_id") : []);
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return [];
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

    public function insert($role_access) {
        try {
            if (is_array($role_access["access_ids"]) && count($role_access["access_ids"]) > 0) {
                $batch_data = [];
                $user_id = get_logged_in_user_id();
                $role_id = isset($role_access["role_id"]) ? $role_access["role_id"] : 0;
                foreach ($role_access["access_ids"] as $access) {
                    array_push($batch_data, array(
                        "role_id" => $role_id,
                        "access_id" => $access,
                        "enabled" => TRUE,
                        "user_id" => $user_id,
                        "create_time" => get_time(),
                        "update_time" => get_time()
                    ));
                }
                $this->db->insert_batch('access_role', $batch_data);
                return ($this->db->affected_rows() >= 0) ? $this->db->insert_id() : FALSE;
            }
            return TRUE;
        } catch (Exception $e) {
            $this->logger->error(__METHOD__, $e->getMessage());
            return FALSE;
        } finally {
            $this->logger->queryLog(__METHOD__, $this->db->last_query());
        }
    }

}
