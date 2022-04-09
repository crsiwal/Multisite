<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: BlogModel.php
 *  Path: application/models/BlogModel.php
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
if (!class_exists('BlogModel')) {

    class BlogModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function get_user_blogs($user_id, $blog_id = NULL) {
            try {
                $this->db->select('a.id, a.name, a.username as url, a.cat_id as category, sum( case when date(b.create_time) = "' . get_date() . '" then 1 else 0 end ) as today, count(b.id) as total, a.logo_url as logo, a.metadesc as desc, a.create_time as ctime, a.update_time as utime');
                $this->db->from('blogs as a');
                $this->db->join('posts as b', 'b.blog_id=a.id', 'LEFT');
                $where = array(
                    "a.user_id" => $this->db->escape_like_str($user_id),
                );
                if (!empty($blog_id)) {
                    $where["a.id"] = $this->db->escape_like_str($blog_id);
                    return $this->db->where($where)->group_by("a.id")->get()->row();
                } else {
                    return $this->db->where($where)->group_by("a.id")->get()->result();
                }
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function new_user_blog($blog_detail) {
            try {
                $data = array(
                    "name" => isset($blog_detail["name"]) ? $blog_detail["name"] : "",
                    "username" => isset($blog_detail["url"]) ? $blog_detail["url"] : "",
                    "user_id" => isset($blog_detail["user_id"]) ? $blog_detail["user_id"] : get_logged_in_user_id(),
                    "cat_id" => isset($blog_detail["category_id"]) ? $blog_detail["category_id"] : "",
                    "logo_url" => isset($blog_detail["logo_url"]) ? $blog_detail["logo_url"] : "",
                    "metadesc" => isset($blog_detail["desc"]) ? $blog_detail["desc"] : "",
                    "create_time" => get_time(),
                    "update_time" => get_time(),
                );
                $this->db->insert('blogs', $data);
                return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function update_user_blog($blog_details) {
            try {
                if (isset($blog_detail["id"])) {
                    $data = array(
                        "name" => isset($blog_detail["name"]) ? $blog_detail["name"] : "",
                        "update_time" => get_time(),
                    );
                    $user_id = isset($blog_detail["user_id"]) ? $blog_detail["user_id"] : get_logged_in_user_id();
                    $this->db->where('id', $blog_detail["id"]);
                    $this->db->update('blogs', $data);
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

    }

}