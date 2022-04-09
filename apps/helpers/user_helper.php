<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: user_helper.php
 *  Path: application/helpers/user_helper.php
 *  Description: This helper add multiple common functions for user.
 * 
 * Function Added:
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              --------------
 *  Rahul Siwal         09/02/2020              Created
 *
 */

function email_exists($email) {
    $ci = & get_instance();
    $user = $ci->user->get_user_by("email", $email);
    if ($user) {
        return $user;
    }
    return FALSE;
}

function checkLogin() {
    if (!is_login()) {
        next_page("login");
    }
}

function get_logged_in_user_id() {
    $ci = & get_instance();
    return $ci->user->get_logged_in_user_id();
}

function is_login() {
    $ci = & get_instance();
    return $ci->user->user_logged_in();
}

function get_active_blog_id() {
    $ci = & get_instance();
    $blog_id = $ci->sessions->get_active_blog();
    return (!empty($blog_id)) ? $blog_id : "";
}

function get_active_blog_url() {
    $ci = & get_instance();
    return $ci->collection->select_value("blogs", "username as url", array("user_id", "id"), array("id" => get_active_blog_id()));
}

function user_checks($checks, $false_redirect, $true_redirect = FALSE) {
    $ci = & get_instance();
    $flag = TRUE;
    foreach ($checks as $check) {
        switch ($check) {
            case "activeblog":
                $flag = empty(get_active_blog_id()) ? FALSE : TRUE;
                break;
            case "removeblog":
                $ci->sessions->set_active_blog(NULL);
                break;
            case "noblog":
                $flag = (get_user_meta("blog_count") > 0) ? TRUE : FALSE;
                break;
        }
    }
    (!$flag) ? next_page($false_redirect) : (($true_redirect) ? next_page($true_redirect) : FALSE );
}

function get_user_meta($meta) {
    $ci = & get_instance();
    return $ci->user->get_user_meta($meta);
}
