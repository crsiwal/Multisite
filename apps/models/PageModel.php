<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: PageModel.php
 *  Path: application/models/PageModel.php
 *  Description: 
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         09/03/2020              Created

 *
 */
if (!class_exists('PageModel')) {

    class PageModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function insert($page) {
            try {
                $data = array(
                    "blog_id" => isset($page["blog_id"]) ? $page["blog_id"] : get_active_blog_id(),
                    "user_id" => isset($page["user_id"]) ? $page["user_id"] : get_logged_in_user_id(),
                    "post_key" => isset($page["post_key"]) ? $page["post_key"] : unique_key(8, "microtime"),
                    "title" => isset($page["title"]) ? $page["title"] : "",
                    "slug" => isset($page["slug"]) ? $page["slug"] : "",
                    "reference" => isset($page["reference"]) ? $page["reference"] : "",
                    "content" => isset($page["content"]) ? $page["content"] : "",
                    "metadesc" => isset($page["desc"]) ? $page["desc"] : "",
                    "type" => isset($page["type"]) ? $page["type"] : "page",
                    "info" => isset($page["info"]) ? ((is_array($page["info"])) ? json_encode($page["info"]) : $page["info"]) : "",
                    "status" => isset($page["status"]) ? $page["status"] : "",
                    "create_time" => get_time(),
                    "update_time" => get_time(),
                );
                $this->db->insert('posts', $data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update($page) {
            try {
                $page_id = isset($page["id"]) ? $page["id"] : "-1";
                $user_id = isset($page["user_id"]) ? $page["user_id"] : get_logged_in_user_id();
                $data = array(
                    "title" => isset($page["title"]) ? $page["title"] : "",
                    "content" => isset($page["content"]) ? $page["content"] : "",
                    "metadesc" => isset($page["desc"]) ? $page["desc"] : "",
                    "reference" => isset($page["reference"]) ? $page["reference"] : "",
                    "status" => isset($page["status"]) ? $page["status"] : "",
                    "update_time" => get_time(),
                );
                $this->db->where(array(
                    'id' => $page_id,
                    "type" => "page",
                    'user_id' => $user_id
                ));
                $this->db->update('posts', $data);
                return ($this->db->affected_rows() == 1) ? $page_id : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function change($page_id, $page) {
            try {
                $user_id = isset($page["user_id"]) ? $page["user_id"] : get_logged_in_user_id();
                $this->db->where(array(
                    'id' => $page_id,
                    'user_id' => $user_id
                ));
                $this->db->update('posts', $page);
                return ($this->db->affected_rows() <= 1) ? $page_id : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete($page) {
            try {
                $this->db->delete('posts', array(
                    "id" => isset($page["id"]) ? $page["id"] : "-1",
                    "type" => "page",
                    "user_id" => isset($page["user_id"]) ? $page["user_id"] : get_logged_in_user_id(),
                ));
                return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function get_status($page) {
            try {
                $user_id = isset($page["user_id"]) ? $page["user_id"] : get_logged_in_user_id();
                $page_id = isset($page["id"]) ? $page["id"] : "-1";
                $this->db->where(array(
                    'id' => $page_id,
                    "type" => "page",
                    'user_id' => $user_id
                ));
                return $this->db->select('status')->get('posts')->row()->status;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

    }

}