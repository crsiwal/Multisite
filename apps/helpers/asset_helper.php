<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: asset.php
 *  Path: application/helpers/asset.php
 *  Description: This helper add the assets related functions.
 * 
 * Function Added:
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              --------------
 *  Rahul Siwal         26/01/2020              Created
 *
 */

function path($path) {
    return FCPATH . $path;
}

function filePath($filepath) {
    return path("public/" . $filepath);
}

function icon_url($filename = "", $return = FALSE) {
    return asset_url("icons/" . $filename, $return);
}

function font_awesome($filename = "", $return = FALSE) {
    return asset_url("icons/" . $filename, $return);
}

function asset_url($filename = "", $return = FALSE) {
    return url("assets/$filename", $return);
}

function asset_path($filepath) {
    return path("assets/" . $filepath);
}

function user_asset_path($filepath, $user_id = 0) {
    $user_id = ($user_id === 0) ? get_logged_in_user_id() : $user_id;
    return path("cdn/usr/udt_$user_id/" . $filepath);
}

function user_asset_url($filepath, $return = FALSE, $user_id = 0) {
    $user_id = ($user_id === 0) ? get_logged_in_user_id() : $user_id;
    return url("cdn/usr/udt_$user_id/$filename", $return);
}

function url($url = "", $return = FALSE) {
    if ($return === FALSE) {
        echo base_url($url);
    } else {
        return base_url($url);
    }
}

function cdn_url($url = "") {
    $ci = & get_instance();
    return $ci->config->item('cdn_url') . "/" . ltrim($url, "/");
}

function next_page($url = "", $in_house = TRUE) {
    redirect(($in_house) ? url($url, TRUE) : $url);
    die();
}

function upload_file($filename, $config) {
    if ($filename != "") {
        $ci = & get_instance();
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $ci->load->library('upload', $config);
        $uploadedFile = $ci->upload->do_upload($filename);
        if ($uploadedFile === TRUE) {
            return $ci->upload->data();
        }
    }
    return FALSE;
}

function minify($assets) {
    $ci = & get_instance();
    return ($ci->config->item(($assets === 'css') ? 'minify_css' : 'minify_js') === TRUE) ? TRUE : FALSE;
}

function get_url_path($url) {
    return parse_url($url, PHP_URL_PATH);
}

function get_blogger_slug($url) {
    $path = parse_url($url, PHP_URL_PATH);
    $slug = explode("/", trim($path, "/"));
    return basename(end($slug), '.html');
}

function canvas($width = 250, $height = 250, $return = true) {
    $json = htmlspecialchars(json_encode(array(
        "width" => $width,
        "height" => $height
    )));
    if (!$return) {
        echo $json;
    } else {
        return $json;
    }
}
