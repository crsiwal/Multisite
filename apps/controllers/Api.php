<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('RestApi');
        $this->restapi->check_login();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function index() {
        $this->restapi->response("Invalid Request", TRUE);
    }

    public function themes() {
        $response = [];
        switch (get_input_method()) {
            case "GET":
                $themes_array = $this->collection->select("themes", array("id", "name", "version", "thumbnail"), array("enabled"), ["enabled" => TRUE], array(array("name" => "id", "by" => "desc"), array("name" => "update_time", "by" => "desc"),));
                $themes = is_array($themes_array) ? $themes_array : [];
                $response = array("themelist" => $themes);
                break;
            case "POST":
                $this->load->library('Themes');
                $response = ($this->input->post('update', TRUE) == "true") ? $this->themes->update() : $this->themes->save();
                break;
            case "DELETE":
                $this->load->library('Themes');
                $response = $this->themes->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function blogs() {
        $response = [];
        $this->load->library('Blogs');
        switch (get_input_method()) {
            case "GET":
                $response = array("blogs" => $this->blogs->get_user_blogs());
                break;
            case "POST":
                $response = $this->blogs->new_blog();
                break;
            case "PUT":
                $response = $this->blogs->check_url_available();
                break;
            case "DELETE":
                break;
        }
        $this->restapi->response($response);
    }

    public function posts($page = 0) {
        $this->load->library('Post');
        $response = [];
        switch (get_input_method()) {
            case "GET":
                $response = array(
                    "posts" => array(
                        "list" => $this->post->get($page, 'post'),
                        "rows" => 100
                    )
                );
                break;
            case "POST":
                $response = ($this->input->post('update', TRUE) == "true") ? $this->post->update() : $this->post->save();
                break;
            case "DELETE":
                $response = $this->post->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function videos($page = 0) {
        $this->load->library('Post');
        $response = [];
        switch (get_input_method()) {
            case "GET":
                $response = array(
                    "videos" => array(
                        "list" => $this->post->get($page, 'video'),
                        "rows" => 100
                    )
                );
                break;
            case "POST":
                $response = ($this->input->post('update', TRUE) == "true") ? $this->post->update() : $this->post->save();
                break;
            case "DELETE":
                $response = $this->post->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function pages() {
        $response = [];
        switch (get_input_method()) {
            case "GET":
                $pages_array = $this->collection->select("posts", array("id", "title", "thumbnail", "metadesc as desc", "status", "create_time", "update_time", "slug as url"), array("user_id", "blog_id", "type"), ["type" => "page"], array(array("name" => "id", "by" => "desc"), array("name" => "update_time", "by" => "desc"),));
                $pages = is_array($pages_array) ? $pages_array : [];
                $response = array("pages" => array("list" => $pages, "rows" => 100));
                break;
            case "POST":
                $this->load->library('Pages');
                $response = ($this->input->post('update', TRUE) == "true") ? $this->pages->update() : $this->pages->save();
                break;
            case "DELETE":
                $this->load->library('Pages');
                $response = $this->pages->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function category($offset = 0) {
        $response = [];
        $this->load->library('Category');
        switch (get_input_method()) {
            case "GET":
                $parent = $this->uri->segment(4, "");
                $catid = $this->uri->segment(5, 0);
                $categories = $this->category->get($offset, $parent, $catid);
                $categories = is_array($categories) ? $categories : [];
                $response = array("category" => array("list" => $categories, "rows" => 100));
                break;
            case "POST":
                $response = (!get_boolean_input("update")) ? $this->category->save() : $this->category->update();
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->category->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function adsize($offset = 0) {
        $response = [];
        $this->load->library('Adsize');
        switch (get_input_method()) {
            case "GET":
                $adsid = $this->uri->segment(4, 0);
                $data = $this->adsize->get($offset, $adsid);
                $adsizes = is_array($data) ? $data : [];
                $response = array("adsize" => array("list" => $adsizes, "rows" => 100));
                break;
            case "POST":
                $response = (!get_boolean_input("update")) ? $this->adsize->save() : $this->adsize->update();
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->adsize->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function adgroup($offset = 0) {
        $response = [];
        $this->load->library('Adgroup');
        switch (get_input_method()) {
            case "GET":
                $adgid = $this->uri->segment(4, 0);
                $data = $this->adgroup->get($offset, $adgid);
                $adgroups = is_array($data) ? $data : [];
                $response = array("adgroup" => array("list" => $adgroups, "rows" => 100));
                break;
            case "POST":
                $response = (!get_boolean_input("update")) ? $this->adgroup->save() : $this->adgroup->update();
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->adgroup->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function uploads($type = "i") {
        $response = [];
        $this->load->library("Uploads");
        switch (get_input_method()) {
            case "GET":
                $onlyme = get_boolean($this->uri->segment(4, 0));
                $onlyblog = get_boolean($this->uri->segment(5, 0));
                $offset = $this->uri->segment(6, 0);
                $search = $this->uri->segment(7, 0);
                $upd_images = $this->uploads->get($type, $onlyme, $onlyblog, $offset, $search);
                $images = is_array($upd_images) ? $upd_images : [];
                $response = array("list" => $images, "rows" => 100);
                break;
            case "POST":
                $response = $this->uploads->upload();
                $response["data"] = (!$response["error"]) ? "File uploded successfully" : $response["data"];
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->uploads->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function userrole($offset = 0) {
        $response = [];
        $this->load->library("Userrole");
        switch (get_input_method()) {
            case "GET":
                $urole_id = $this->uri->segment(4, 0);
                $userrole = $this->userrole->get($offset, $urole_id);
                $response = array("userrole" => array("list" => (is_array($userrole) ? $userrole : []), "rows" => 100));
                break;
            case "POST":
                $response = (!get_boolean_input("update")) ? $this->userrole->save() : $this->userrole->update();
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->userrole->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function accessgroup($offset = 0) {
        $response = [];
        $this->load->library("AccessGroup", NULL, "agroup");
        switch (get_input_method()) {
            case "GET":
                $agroup_id = $this->uri->segment(4, 0);
                $agroup = $this->agroup->get($offset, $agroup_id);
                $response = array("agroup" => array("list" => (is_array($agroup) ? $agroup : []), "rows" => 100));
                break;
            case "POST":
                $response = (!get_boolean_input("update")) ? $this->agroup->save() : $this->agroup->update();
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->agroup->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function access($offset = 0) {
        $response = [];
        $this->load->library("Access");
        switch (get_input_method()) {
            case "GET":
                $access_id = $this->uri->segment(4, 0);
                $access = $this->access->get($offset, $access_id);
                $response = array("access" => array("list" => $access, "rows" => 100));
                break;
            case "POST":
                $response = (!get_boolean_input("update")) ? $this->access->save() : $this->access->update();
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->access->delete();
                break;
        }
        $this->restapi->response($response);
    }

    public function roleaccess($role_id = 0) {
        $response = [];
        $this->load->library("RoleAccess");
        switch (get_input_method()) {
            case "GET":
                $role = $this->collection->select_row("user_role", array("name", "description as summery"), array("id"), ["id" => $role_id]);
                if (isset($role["name"])) {
                    $roleaccess = $this->roleaccess->get($role_id);
                    $response = array("roleaccess" => array("name" => $role["name"], "desc" => $role["summery"], "list" => $roleaccess, "rows" => 100));
                }
                break;
            case "POST":
                $response = $this->roleaccess->save();
                break;
            case "PUT":
                break;
            case "DELETE":
                break;
        }
        $this->restapi->response($response);
    }

    /**
     * 
     * @param type $type
     */
    public function editor($type = "i") {
        $response = [];
        $this->load->library("Uploads");
        switch (get_input_method()) {
            case "GET":
                $onlyme = get_boolean($this->uri->segment(4, 0));
                $onlyblog = get_boolean($this->uri->segment(5, 0));
                $offset = $this->uri->segment(6, 0);
                $search = $this->uri->segment(7, 0);
                $images = $this->uploads->get($type, $onlyme, $onlyblog, $offset, $search);
                $response = is_array($images) ? $images : [];
                break;
            case "POST":
                $upload = $this->uploads->upload();
                $response = array("link" => ($upload["error"]) ? "" : $upload["data"]);
                break;
            case "PUT":
                break;
            case "DELETE":
                $response = $this->uploads->delete();
                break;
        }
        $this->restapi->output($response);
    }

    public function youtube($search) {
        $response = [];
        $this->load->library("YouTube", NULL, "yt");
        switch (get_input_method()) {
            case "GET":
                $search_list = $this->yt->search($search);
                $response = array("list" => $search_list);
                break;
            case "POST":
                break;
            case "PUT":
                break;
            case "DELETE":
                break;
        }
        $this->restapi->response($response);
    }

    public function password() {
        $response = [];
        switch (get_input_method()) {
            case "GET":
                break;
            case "POST":
                $response = $this->user->change_password();
                break;
            case "PUT":
                break;
            case "DELETE":
                break;
        }
        $this->restapi->response($response);
    }

}
