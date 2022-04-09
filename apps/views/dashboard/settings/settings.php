<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: setting.php
 *  Path: apps/views/dashboard/settings/settings.php
 *  Description: It's a setting page.
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/08/2020              Created
 *
 */
?>
<main class="main">
    <div class="container-fluid setup">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">SETUP</p>
                <p class="font-12 text-capitalize text-darkgray-2">Setup
                </p>
            </div>
        </div>
        <div class="grid-title">
            <p class="grid-title-heading">Blog Settings</p>
            <p class="grid-title-subheading"></p>
        </div>
        <div class="row setup-grid-1 _drawlist" data-key="setupcount">
            <?php
            $blocks = array(
                "admin_users" => array(
                    "access" => "VIEW_USER_LIST",
                    "name" => "Users",
                    "id" => "setup_users",
                    "url" => "setup/users",
                    "link" => "Manage Users",
                ),
                "admin_themes" => array(
                    "access" => "THEME_FEATURE",
                    "name" => "Themes",
                    "id" => "setup_themes",
                    "url" => "setup/themes",
                    "link" => "Manage Themes",
                ),
                "category" => array(
                    "access" => "VIEW_CATEGORY_LIST",
                    "name" => "Category",
                    "id" => "setup_category",
                    "url" => "setup/category",
                    "link" => "Manage Category",
                ),
                "theme" => array(
                    "access" => "page_blog_theme",
                    "name" => "Blog Theme",
                    "id" => "setup_theme",
                    "url" => "setup/theme",
                    "link" => "Manage Theme",
                ),
                "adsizes" => array(
                    "access" => "VIEW_ADSIZE_LIST",
                    "name" => "Ad Sizes",
                    "id" => "setup_adsize",
                    "url" => "setup/adsize",
                    "link" => "Manage Ad Sizes",
                ),
            );
            add_setup_blocks($blocks);
            ?>
        </div>
        <div class="grid-title d-flex justify-content-between">
            <div>
                <p class="grid-title-heading">Browser Cache Service</p>
                <p class="grid-title-subheading">To provide you a better experience, we use the cache service. In case you are facing any issue regarding data load. Click Reset Cache Service Button.</p>
            </div>
            <div class="create-button-container">
                <button id="resetcache" class="font-14 btn btn-danger">Reset Cache Service</button>
            </div>
        </div>
    </div>
</main>