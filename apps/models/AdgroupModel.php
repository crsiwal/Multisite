<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: AdsizeModel.php
 *  Path: application/models/AdsizeModel.php
 *  Description: 
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         05/04/2020              Created

 *
 */
if (!class_exists('AdgroupModel')) {

    class AdgroupModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function get($offset, $id) {
            try {
                $this->db->select("a.id, a.name, a.metadesc as meta, case a.platform when 'a' then 'Anyone' when 'd' then 'Desktop' when 't' then 'Tablet' when 'm' then 'Mobile' end as device, a.platform, b.id as adsid, b.name as adsize, CONCAT(b.width, ' x ', b.height) as size, b.sitekey, a.ads_count as count", FALSE);
                $this->db->from('adgroup as a');
                $this->db->join('adsize as b', 'a.adsize_id = b.id', 'LEFT OUTER');
                if (!empty($id)) {
                    $this->db->where("a.id", get_integer($id));
                } else {
                    $this->db->order_by('a.name');
                    $this->db->limit(100, get_integer($offset));
                }
                return (!empty($id)) ? $this->db->get()->row_array() : $this->db->get()->result_array();
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function insert($adgroup) {
            try {
                $data = array(
                    "blog_id" => isset($adgroup["blog_id"]) ? $adgroup["blog_id"] : get_active_blog_id(),
                    "user_id" => isset($adgroup["user_id"]) ? $adgroup["user_id"] : get_logged_in_user_id(),
                    "name" => isset($adgroup["name"]) ? $adgroup["name"] : "",
                    "platform" => isset($adgroup["platform"]) ? $adgroup["platform"] : "d",
                    "metadesc" => isset($adgroup["desc"]) ? $adgroup["desc"] : "0",
                    "adsize_id" => isset($adgroup["adsize_id"]) ? $adgroup["adsize_id"] : 0,
                );
                $this->db->insert('adgroup', $data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update($adgroup) {
            try {
                if (isset($adgroup["id"])) {
                    $data = array(
                        "name" => isset($adgroup["name"]) ? $adgroup["name"] : "",
                        "metadesc" => isset($adgroup["desc"]) ? $adgroup["desc"] : "0",
                        "platform" => isset($adgroup["platform"]) ? $adgroup["platform"] : "d",
                        "adsize_id" => isset($adgroup["adsize_id"]) ? $adgroup["adsize_id"] : 0,
                    );
                    $this->db->where(array(
                        'id' => $adgroup["id"],
                        "user_id" => isset($adgroup["user_id"]) ? $adgroup["user_id"] : get_logged_in_user_id()
                    ));
                    $this->db->update('adgroup', $data);
                    return ($this->db->affected_rows() <= 1) ? $adgroup["id"] : FALSE;
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete($adgroup) {
            try {
                $this->db->where('id', isset($adgroup["id"]) ? $adgroup["id"] : "-1");
                $this->db->where('user_id', isset($adgroup["user_id"]) ? $adgroup["user_id"] : get_logged_in_user_id());
                $this->db->delete('adgroup');
                return ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

    }

}