<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

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

    public function smry_count() {
        $response = array(
            "totalpost" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type"), ["type" => "post"])),
            "draftpost" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type", "status"), ["type" => "post", "status" => "draft"])),
            "publishpost" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type", "status"), ["type" => "post", "status" => "publish"])),
            "totalvideo" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type"), ["type" => "video"])),
            "draftvideo" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type", "status"), ["type" => "video", "status" => "draft"])),
            "publishvideo" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type", "status"), ["type" => "video", "status" => "publish"])),
            "totalpage" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type"), ["type" => "page"])),
            "draftpage" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type", "status"), ["type" => "page", "status" => "draft"])),
            "publishpage" => array("count" => $this->collection->count("posts", array("user_id", "blog_id", "type", "status"), ["type" => "page", "status" => "publish"])),
        );
        $this->restapi->response($response);
    }

}
