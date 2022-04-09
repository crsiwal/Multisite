<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: UploadModel.php
 *  Path: application/models/UploadModel.php
 *  Description: 
 * 
 * Function List
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         19/04/2020              Created

 *
 */
if (!class_exists('UploadModel')) {

    class UploadModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function get($id = NULL, $type, $onlyme, $onlyblog, $offset, $search) {
            try {
                $this->db->select("id, name, privacy, tags, width, height, url, url as thumb, public_image as public, upload_time as time");
                $this->db->from('uploads');

                if (!empty($id)) {
                    $this->db->where("id", get_integer($id));
                }

                if ($onlyme) {
                    $this->db->where("user_id", get_logged_in_user_id());
                }

                if ($onlyblog) {
                    $this->db->where("blog_id", get_active_blog_id());
                }

                $this->db->where("is_image", (($type == "i") ? TRUE : FALSE));

                if (!empty($search)) {
                    $this->db->group_start();
                    $this->db->like('name', $search);
                    $this->db->or_like('tags', $search);
                    $this->db->group_end();
                }

                $this->db->order_by("id", "desc");
                $this->db->limit(100, get_integer($offset));
                return (!empty($id)) ? $this->db->get()->row_array() : $this->db->get()->result_array();
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function insert($request) {
            try {
                $data = array(
                    "user_id" => isset($request["user_id"]) ? $request["user_id"] : get_logged_in_user_id(),
                    "blog_id" => isset($request["blog_id"]) ? $request["blog_id"] : get_active_blog_id(),
                    "name" => isset($request["name"]) ? $request["name"] : "",
                    "privacy" => isset($request["privacy"]) ? $request["privacy"] : "",
                    "tags" => isset($request["tags"]) ? $request["tags"] : "",
                    "path" => isset($request["path"]) ? $request["path"] : "",
                    "is_image" => isset($request["is_image"]) ? $request["is_image"] : FALSE,
                    "file_type" => isset($request["file_type"]) ? $request["file_type"] : "",
                    "file_size" => isset($request["file_size"]) ? $request["file_size"] : 0,
                    "width" => isset($request["image_width"]) ? $request["image_width"] : 0,
                    "height" => isset($request["image_height"]) ? $request["image_height"] : 0,
                    "url" => isset($request["url"]) ? $request["url"] : "",
                    "public_image" => (isset($request["privacy"]) && $request["privacy"] == "a") ? TRUE : FALSE,
                    "upload_time" => get_time(),
                );
                $this->db->insert('uploads', $data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update($file_id, $data) {
            try {
                if (!empty($file_id)) {
                    $this->db->where(array(
                        'id' => $file_id,
                        "user_id" => isset($request["user_id"]) ? $request["user_id"] : get_logged_in_user_id()
                    ));
                    $this->db->update('uploads', $data);
                    return ($this->db->affected_rows() <= 1) ? $file_id : FALSE;
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete($request) {
            try {
                $this->db->where('id', isset($request["id"]) ? $request["id"] : "-1");
                $this->db->where('user_id', isset($request["user_id"]) ? $request["user_id"] : get_logged_in_user_id());
                $this->db->delete('uploads');
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