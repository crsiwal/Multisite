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
if (!class_exists('AdsizeModel')) {

    class AdsizeModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function get($offset, $id) {
            try {
                $this->db->select('id, name, width, height, CONCAT(width, " x ", height) as size, sitekey');
                $this->db->from('adsize');
                if (!empty($id)) {
                    $this->db->where("id", get_integer($id));
                } else {
                    $this->db->order_by('name');
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

        public function insert($adsize) {
            try {
                $data = array(
                    "name" => isset($adsize["name"]) ? $adsize["name"] : "",
                    "user_id" => isset($adsize["user_id"]) ? $adsize["user_id"] : get_logged_in_user_id(),
                    "width" => isset($adsize["width"]) ? $adsize["width"] : 0,
                    "height" => isset($adsize["height"]) ? $adsize["height"] : 0,
                    "sitekey" => isset($adsize["sitekey"]) ? $adsize["sitekey"] : "",
                );
                $this->db->insert('adsize', $data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update($adsize) {
            try {
                if (isset($adsize["id"])) {
                    $data = array(
                        "name" => isset($adsize["name"]) ? $adsize["name"] : "",
                        "width" => isset($adsize["width"]) ? $adsize["width"] : 0,
                        "height" => isset($adsize["height"]) ? $adsize["height"] : 0,
                        "sitekey" => isset($adsize["sitekey"]) ? $adsize["sitekey"] : "",
                    );
                    $this->db->where(array(
                        'id' => $adsize["id"],
                        "user_id" => isset($adsize["user_id"]) ? $adsize["user_id"] : get_logged_in_user_id()
                    ));
                    $this->db->update('adsize', $data);
                    return ($this->db->affected_rows() <= 1) ? $adsize["id"] : FALSE;
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete($post) {
            try {
                $this->db->where('id', isset($post["id"]) ? $post["id"] : "-1");
                $this->db->where('user_id', isset($post["user_id"]) ? $post["user_id"] : get_logged_in_user_id());
                $this->db->delete('adsize');
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