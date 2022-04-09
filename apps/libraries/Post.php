<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Posts.php
 *  Path: application/libraries/Post.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/02/2020              Created
 *
 */

class Post {

    private $ci;
    private $max_tags;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('PostModel', 'mod_post');
        $this->max_tags = 8;
    }

    public function get($page = 0, $type = "post") {
        $limit = 25;
        $offset = get_integer($page * $limit);
        return $this->ci->mod_post->get($type, $limit, $offset);
    }

    public function save() {
        $success = false;
        $this->ci->load->helper(array('form'));
        $this->ci->load->library('form_validation', NULL, 'form');
        $this->ci->form->set_rules('type', 'Unable to process your request', 'trim|required|strip_tags|min_length[4]|max_length[5]|valid_array_element[' . implode(';', ["post", "video"]) . ']');
        $this->ci->form->set_rules('title', 'Title', 'trim|required|strip_tags|min_length[30]|max_length[256]');
        $this->ci->form->set_rules('editor', 'Content', 'trim|required|min_length[12]');
        $this->ci->form->set_rules('desc', 'Short Description', 'trim|required|strip_tags|min_length[30]|max_length[256]');
        $this->ci->form->set_rules('category', 'Category', 'trim|required|strip_tags|min_length[1]|max_length[128]');
        $this->ci->form->set_rules('language', 'Language', 'trim|required|strip_tags|min_length[1]|max_length[128]');
        if ($this->ci->form->run() != FALSE) {
            $post = array(
                "title" => $this->ci->input->post('title', TRUE),
                "slug" => $this->ci->input->post('slug', TRUE),
                "content" => $this->ci->input->post('editor'),
                "desc" => $this->ci->input->post('desc', TRUE),
                "category" => $this->ci->input->post('category', TRUE),
                "language" => $this->ci->input->post('language', TRUE),
                "reference" => $this->ci->input->post('reference', TRUE),
                "thumbnail" => $this->ci->input->post('thumbnail', TRUE),
                "type" => $this->ci->input->post('type', TRUE),
                "tags" => (!empty($this->ci->input->post('tags', TRUE)) && is_array($this->ci->input->post('tags', TRUE))) ? array_unique(array_slice($this->ci->input->post('tags', TRUE), 0, $this->max_tags)) : [],
                "status" => (get_boolean_input('publish')) ? "publish" : "draft"
            );
            if ($post["type"] == "video") {
                $info = $this->ci->input->post('info', TRUE);
                $this->ci->logger->info(json_encode($info));
                $post["info"] = array(
                    "platform" => (isset($info["platform"])) ? $info["platform"] : "",
                    "videoId" => (isset($info["videoId"])) ? $info["videoId"] : "",
                    "channelId" => (isset($info["channelId"])) ? $info["channelId"] : "",
                );
            }
            $post["id"] = $this->ci->mod_post->insert($post);
            if ($post["id"]) {
                $success = true;
                $this->_add_tag_or_hashtag($post);
                $type = ucfirst($post["type"]);
                $action = (get_boolean_input('publish')) ? "published" : "saved";
                set_msg("$type $action successfully");
            } else {
                set_error("We are not able to handle your request right now.");
            }
        } else {
            set_input_error();
        }
        return array(
            "error" => !$success,
            "saved" => $success,
            "data" => ($success) ? get_msg() : get_error()
        );
    }

    public function update() {
        $success = false;
        $this->ci->load->helper(array('form'));
        $this->ci->load->library('form_validation', NULL, 'form');
        $this->ci->form->set_rules('type', 'Unable to process your request', 'trim|required|strip_tags|min_length[4]|max_length[5]|valid_array_element[' . implode(';', ["post", "video"]) . ']');
        $this->ci->form->set_rules('id', 'Post Id', 'trim|required|min_length[1]|max_length[10]');
        $this->ci->form->set_rules('title', 'Post title', 'trim|required|min_length[30]|max_length[256]');
        $this->ci->form->set_rules('editor', 'Post Content', 'trim|required|min_length[12]');
        $this->ci->form->set_rules('desc', 'Post Description', 'trim|required|min_length[30]|max_length[256]');
        $this->ci->form->set_rules('category', 'Post Category', 'trim|required|min_length[1]|max_length[128]');
        $this->ci->form->set_rules('language', 'Post Language', 'trim|required|min_length[1]|max_length[128]');
        if ($this->ci->form->run() != FALSE) {
            $post = array(
                "id" => $this->ci->input->post('id', TRUE),
                "title" => $this->ci->input->post('title', TRUE),
                "slug" => $this->ci->input->post('slug', TRUE),
                "content" => $this->ci->input->post('editor'),
                "desc" => $this->ci->input->post('desc', TRUE),
                "category" => $this->ci->input->post('category', TRUE),
                "language" => $this->ci->input->post('language', TRUE),
                "reference" => $this->ci->input->post('reference', TRUE),
                "thumbnail" => $this->ci->input->post('thumbnail', TRUE),
                "type" => $this->ci->input->post('type', TRUE),
                "tags" => (!empty($this->ci->input->post('tags', TRUE)) && is_array($this->ci->input->post('tags', TRUE))) ? array_unique(array_slice($this->ci->input->post('tags', TRUE), 0, $this->max_tags)) : [],
                "status" => (get_boolean_input('publish')) ? "publish" : "draft"
            );
            if ($post["type"] == "video") {
                $info = $this->ci->input->post('info', TRUE);
                $post["info"] = array(
                    "platform" => (isset($info["platform"])) ? $info["platform"] : "",
                    "videoId" => (isset($info["videoId"])) ? $info["videoId"] : "",
                    "channelId" => (isset($info["channelId"])) ? $info["channelId"] : "",
                );
            }
            $post["id"] = $this->ci->mod_post->update($post);
            if ($post["id"]) {
                $success = true;
                $this->_add_tag_or_hashtag($post);
                $type = ucfirst($post["type"]);
                $type = ucfirst($post["type"]);
                $action = (get_boolean_input('publish')) ? "published" : "updated";
                set_msg("$type $action successfully");
            } else {
                set_error("We are not able to handle your request right now.");
            }
        } else {
            set_input_error();
        }
        return array(
            "error" => !$success,
            "saved" => $success,
            "data" => ($success) ? get_msg() : get_error()
        );
    }

    public function delete() {
        $post = array(
            "id" => $this->ci->input->input_stream('id', TRUE)
        );
        $success = ($this->ci->mod_post->delete($post)) ? TRUE : FALSE;
        set_msg($success ? "Deleted Successfully" : "We are not able to handle your request right now.");
        return array(
            "error" => !$success,
            "data" => ($success) ? get_msg() : get_error()
        );
    }

    public function get_video_data($platform, $video_id) {
        $service = array_search($platform, array("YouTube" => "yt"));
        switch ($service) {
            case "YouTube":
                $this->ci->load->library("YouTube", NULL, "yt");
                $response = $this->ci->yt->video($video_id);
                break;
            default:
                $response = [];
                break;
        }
        return $response;
    }

    /**
     * Get Data from Youtube Video
     * @param type $video
     * @param type $explode
     * @return type
     */
    public function retrive_post_data($video, $explode) {
        return array(
            "title" => (isset($video["title"])) ? $video["title"] : "",
            "content" => (isset($video["description"])) ? nl2br($video["description"]) : "",
            "thumbnail" => (isset($video["thumbnails"]["high"]["url"])) ? $video["thumbnails"]["high"]["url"] : ((isset($video["thumbnails"]["default"]["url"])) ? $video["thumbnails"]["default"]["url"] : ""),
            "metadesc" => (isset($video["title"])) ? $video["title"] : "",
            "tags" => (isset($video["tags"]) && is_array($video["tags"])) ? implode(",", array_slice($video["tags"], 0, 8)) : "",
            "type" => "video",
            "info" => json_encode(array(
                "platform" => $explode[0],
                "videoId" => $explode[1],
                "channelId" => (isset($video["channelId"])) ? $video["channelId"] : "",
            )),
        );
    }

    public function get_post($post_id) {
        $where = where(["user_id", "blog_id", "post_id"], ["post_id" => $post_id]);
        return $this->ci->mod_post->get_post($where);
    }

    public function get_tags($post_id, $field = "name") {
        $where = where(["user_id", "blog_id", "post_id"], ["post_id" => $post_id]);
        $tags = $this->ci->mod_post->get_tags($where);
        return (!$field) ? $tags : array_column($tags, $field);
    }

    private function _add_tag_or_hashtag($post) {
        /** Create Post Tags * */
        $this->ci->mod_post->insert_tag_or_hashtag($post, "post_tags", "tags");

        /** Retrieve Hashtags from post content and add with post * */
        $post["hashtag"] = get_hashtag($post["content"]);
        $this->ci->mod_post->insert_tag_or_hashtag($post, "post_hashtag", "hashtag");
    }

}
