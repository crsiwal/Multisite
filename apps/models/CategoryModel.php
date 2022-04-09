<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: CategoryModel.php
 *  Path: application/models/CategoryModel.php
 *  Description: 
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/02/2020              Created

 *
 */
if (!class_exists('CategoryModel')) {

    class CategoryModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function get($offset, $parent, $id) {
            try {
                $this->db->select("a.id, a.name, a.slug, b.name as parent, a.parent_id as pid");
                $this->db->from('category as a');
                $this->db->join('category as b', 'a.parent_id = b.id', "left outer");
                $this->db->group_start();
                $this->db->where("a.user_id", get_logged_in_user_id());
                $this->db->or_where('a.ctype', "system");
                $this->db->group_end();
                if (!empty($id)) {
                    $this->db->where("a.id", get_integer($id));
                } elseif (!empty($parent)) {
                    $this->db->where("a.parent_id", get_integer($parent));
                }
                $this->db->order_by('a.name');
                $this->db->limit(100, get_integer($offset));
                return (!empty($id)) ? $this->db->get()->row_array() : $this->db->get()->result_array();
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function insert($category) {
            try {
                $data = array(
                    "name" => isset($category["name"]) ? $category["name"] : "",
                    "slug" => isset($category["slug"]) ? $category["slug"] : "",
                    "parent_id" => isset($category["parent"]) ? $category["parent"] : 0,
                    "ctype" => "user",
                    "user_id" => isset($category["user_id"]) ? $category["user_id"] : get_logged_in_user_id(),
                );
                $this->db->insert('category', $data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update($category) {
            try {
                if (isset($category["id"])) {
                    $data = array(
                        "name" => isset($category["name"]) ? $category["name"] : "",
                        "slug" => isset($category["slug"]) ? $category["slug"] : "",
                        "parent_id" => isset($category["parent"]) ? $category["parent"] : 0,
                    );
                    $this->db->where(array(
                        'id' => $category["id"],
                        "user_id" => isset($category["user_id"]) ? $category["user_id"] : get_logged_in_user_id()
                    ));
                    $this->db->update('category', $data);
                    return ($this->db->affected_rows() <= 1) ? $category["id"] : FALSE;
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete($category) {
            try {
                $this->db->group_start();
                $this->db->where('id', isset($category["id"]) ? $category["id"] : "-1");
                $this->db->or_where('parent_id', isset($category["id"]) ? $category["id"] : "-1");
                $this->db->group_end();
                $this->db->where('user_id', isset($category["user_id"]) ? $category["user_id"] : get_logged_in_user_id());
                $this->db->delete('category');
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