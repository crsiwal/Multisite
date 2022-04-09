<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: PostModel.php
 *  Path: application/models/PostModel.php
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
if (!class_exists('PostModel')) {

    class PostModel extends CI_Model {

        Public function __construct() {
            parent::__construct();
        }

        public function get($type, $limit, $offset) {
            try {
                $this->db->select("a.id, a.title, a.thumbnail, a.metadesc as summery, ifnull(b.name,'') as category, a.status, a.create_time, a.update_time, a.slug as url");
                $this->db->from('posts as a');
                $this->db->join('category as b', 'b.id=a.cat_id', 'LEFT');
                $this->db->where([
                    "a.user_id" => get_logged_in_user_id(),
                    "a.blog_id" => get_active_blog_id(),
                    "a.type" => $type
                ]);
                $this->db->order_by('a.id desc', 'a.update_time desc');
                $this->db->limit($limit, $offset);
                $query = $this->db->get();
                return ($query->num_rows() > 0) ? $query->result_array() : [];
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function get_post($where) {
            try {
                $this->db->select("a.*, ifnull(b.name,'') as category");
                $this->db->from('posts as a');
                $this->db->join('category as b', 'b.id=a.cat_id', 'LEFT');
                $this->db->where([
                    "a.id" => isset($where["post_id"]) ? $where["post_id"] : 0,
                    "a.user_id" => isset($where["user_id"]) ? $where["user_id"] : get_logged_in_user_id(),
                    "a.blog_id" => isset($where["blog_id"]) ? $where["blog_id"] : get_active_blog_id(),
                ]);
                $query = $this->db->get();
                return ($query->num_rows() > 0) ? $query->row_array() : [];
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function get_tags($where) {
            try {
                $this->db->select("b.id, b.name");
                $this->db->from('post_tags as a');
                $this->db->join('tags as b', 'b.id=a.tag_id', 'LEFT');
                $this->db->where([
                    "a.post_id" => isset($where["post_id"]) ? $where["post_id"] : 0,
                    "a.blog_id" => isset($where["blog_id"]) ? $where["blog_id"] : get_active_blog_id(),
                    "a.user_id" => isset($where["user_id"]) ? $where["user_id"] : get_logged_in_user_id(),
                ]);
                $this->db->order_by('b.id desc');
                $query = $this->db->get();
                return ($query->num_rows() > 0) ? $query->result_array() : [];
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function insert($post) {
            try {
                $data = array(
                    "blog_id" => isset($post["blog_id"]) ? $post["blog_id"] : get_active_blog_id(),
                    "user_id" => isset($post["user_id"]) ? $post["user_id"] : get_logged_in_user_id(),
                    "post_key" => isset($post["post_key"]) ? $post["post_key"] : unique_key(8, "microtime"),
                    "title" => isset($post["title"]) ? $post["title"] : "",
                    "slug" => isset($post["slug"]) ? $post["slug"] : "",
                    "content" => isset($post["content"]) ? $post["content"] : "",
                    "metadesc" => isset($post["desc"]) ? $post["desc"] : "",
                    "thumbnail" => isset($post["thumbnail"]) ? $post["thumbnail"] : "",
                    "cat_id" => isset($post["category"]) ? $post["category"] : "",
                    "lang" => isset($post["language"]) ? $post["language"] : "",
                    "type" => isset($post["type"]) ? $post["type"] : "post",
                    "reference" => isset($post["reference"]) ? $post["reference"] : "",
                    "info" => isset($post["info"]) ? ((is_array($post["info"])) ? json_encode($post["info"]) : $post["info"]) : "",
                    "status" => isset($post["status"]) ? $post["status"] : "",
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

        public function update($post) {
            try {
                $post_id = isset($post["id"]) ? $post["id"] : "0";
                $user_id = isset($post["user_id"]) ? $post["user_id"] : get_logged_in_user_id();
                $data = array(
                    "title" => isset($post["title"]) ? $post["title"] : "",
                    "content" => isset($post["content"]) ? $post["content"] : "",
                    "metadesc" => isset($post["desc"]) ? $post["desc"] : "",
                    "slug" => isset($post["slug"]) ? $post["slug"] : "",
                    "reference" => isset($post["reference"]) ? $post["reference"] : "",
                    "thumbnail" => isset($post["thumbnail"]) ? $post["thumbnail"] : "",
                    "cat_id" => isset($post["category"]) ? $post["category"] : "",
                    "lang" => isset($post["language"]) ? $post["language"] : "",
                    "info" => isset($post["info"]) ? ((is_array($post["info"])) ? json_encode($post["info"]) : $post["info"]) : "",
                    "status" => isset($post["status"]) ? $post["status"] : "",
                    "update_time" => get_time(),
                );
                $this->db->where(array(
                    'id' => $post_id,
                    'user_id' => $user_id
                ));
                $this->db->update('posts', $data);
                return ($this->db->affected_rows() == 1) ? $post_id : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function change($post_id, $post) {
            try {
                $user_id = isset($post["user_id"]) ? $post["user_id"] : get_logged_in_user_id();
                $this->db->where(array(
                    'id' => $post_id,
                    'user_id' => $user_id
                ));
                $this->db->update('posts', $post);
                return ($this->db->affected_rows() <= 1) ? $post_id : FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete($post) {
            try {
                if (isset($post["id"])) {
                    $this->db->delete('posts', array(
                        "id" => $post["id"],
                        "user_id" => isset($post["user_id"]) ? $post["user_id"] : get_logged_in_user_id(),
                    ));
                    if ($this->db->affected_rows() == 1) {
                        $this->db->delete('post_tags', ["post_id" => $post["id"]]);
                        $this->db->delete('post_hashtag', ["post_id" => $post["id"]]);
                        return TRUE;
                    }
                }
                return FALSE;
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function get_status($post) {
            try {
                $user_id = isset($post["user_id"]) ? $post["user_id"] : get_logged_in_user_id();
                $post_id = isset($post["id"]) ? $post["id"] : "-1";
                $this->db->where(array(
                    'id' => $post_id,
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

        public function insert_tag_or_hashtag($post, $map_table, $data_key) {
            try {
                $tags = $this->search_tag_or_hashtag($post[$data_key]);
                $new_tags = array_diff($post[$data_key], $tags);
                if (is_array($new_tags) && count($new_tags) > 0) {
                    $batch_data = [];
                    foreach ($new_tags as $tag) {
                        array_push($batch_data, ["name" => $tag]);
                    }
                    $this->db->insert_batch("tags", $batch_data);
                }
                $this->delete_post_tag_or_hashtag($post, $map_table, $data_key);
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function delete_post_tag_or_hashtag($post, $map_table, $data_key) {
            try {
                $tags = $this->search_tag_or_hashtag($post[$data_key], "id");
                $where = [
                    "blog_id" => isset($post["blog_id"]) ? $post["blog_id"] : get_active_blog_id(),
                    "user_id" => isset($post["user_id"]) ? $post["user_id"] : get_logged_in_user_id(),
                    "post_id" => isset($post["id"]) ? $post["id"] : 0,
                ];
                $this->db->where($where);
                if (count($post[$data_key]) > 0) {
                    $this->db->where_not_in("tag_id", $tags);
                }
                $this->db->delete($map_table);
                $this->map_post_tag_or_hashtag($map_table, $tags, $where);
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        public function map_post_tag_or_hashtag($map_table, $tags, $where) {
            try {
                $query = $this->db->where($where)->get($map_table);
                $map_tags = ($query->num_rows() > 0) ? array_column($query->result_array(), "tag_id") : [];
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
                $new_tags = array_diff($tags, $map_tags);
                if (is_array($new_tags) && count($new_tags) > 0) {
                    $batch_data = [];
                    foreach ($new_tags as $tag) {
                        $where["tag_id"] = $tag;
                        array_push($batch_data, $where);
                    }
                    $this->db->insert_batch($map_table, $batch_data);
                }
            } catch (Exception $e) {
                $this->logger->error(__METHOD__, $e->getMessage());
                return FALSE;
            } finally {
                $this->logger->queryLog(__METHOD__, $this->db->last_query());
            }
        }

        protected function search_tag_or_hashtag($list = [], $field = "name") {
            if (is_array($list) && count($list) > 0) {
                $query = $this->db->where_in("name", $list)->get("tags");
                return ($query->num_rows() > 0) ? array_column($query->result_array(), $field) : [];
            }
            return [];
        }

    }

}