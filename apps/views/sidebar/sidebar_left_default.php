<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: sidebar_left_default.php
 *  Path: application/views/sidebar/sidebar_left_default.php
 *  Description: It's a default left sidebar.
 * 
 * Function Added:
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         26/01/2020              Created

 *
 */
?>
<aside class="sidenav sidenav-expanded-button">
    <div class="sidenav-menu">
        <div class="image-container pointer">
            <span class="fa fa-bars font-25" aria-hidden="true"></span>
            <span class="fa fa-chevron-circle-left collapse font-25" aria-hidden="true"></span>
        </div>
    </div>
    <div class="sidenav-links-container">
        <div class="sidenav-links">
            <ul>
                <?php
                addmenu("VIEW_SUMMERY", "Summery", "blog/summery", "fa-home");
                addgroup("FEATURE_POSTS", "Posts", "fa-list-alt", array(
                    ["ADD_NEW_POST", "Add New", "posts/new"],
                    ["VIEW_POST_LIST", "Drafts", "blog/posts"],
                    ["VIEW_POST_LIST", "Published", "blog/posts"],
                ));
                addgroup("FEATURE_VIDEOS", "Videos", "fa-video-camera", array(
                    ["SEARCH_VIDEOS", "Add New", "videos/search"],
                    ["VIEW_VIDEO_LIST", "Drafts", "blog/videos"],
                    ["VIEW_VIDEO_LIST", "Published", "blog/videos"],
                ));
                addgroup("FEATURE_PAGES", "Pages", "fa-file-text-o", array(
                    ["ADD_NEW_PAGE", "Add New", "pages/new"],
                    ["VIEW_PAGE_LIST", "Drafts", "blog/pages"],
                    ["VIEW_PAGE_LIST", "Published", "blog/pages"],
                ));
                addgroup("FEATURE_COLLECTION", "Uploads", "fa-cloud-upload", array(
                    ["VIEW_IMAGE_LIST", "Images", "blog/images"],
                    ["VIEW_DOCUMENT_LIST", "Documents", "blog/documents"],
                ));
                addgroup("FEATURE_ADS", "Ads", "fa-audio-description", array(
                    ["ADD_NEW_ADS", "New", "ads/new"],
                    ["VIEW_ADS_LIST", "Manage", "ads"],
                    ["VIEW_ADS_GROUP_LIST", "Ads Group", "ads/adgroup"],
                ));
                addgroup("FEATURE_SETTINGS", "Settings", "fa-cogs", array(
                    ["ADD_NEW_BLOG", "General", "settings/general"],
                    ["VIEW_USER_ROLE_LIST", "User Role", "admin/userrole"],
                    ["VIEW_ACCESS_LIST", "Access", "admin/access"],
                    ["VIEW_ACCESS_GROUP_LIST", "Access Group", "admin/accessgroup"],
                    ["VIEW_CATEGORY_LIST", "Category", "setup/category"],
                    ["VIEW_ADS_GROUP_LIST", "AdSize", "ads/adsize"],
                    ["ADD_NEW_BLOG", "New Blog", "setup/blog"],
                    ["VIEW_THEME_LIST", "Theme", "setup/theme"],
                    ["VIEW_MENU_LIST", "Menus", "setup/menus"],
                ));
                ?>
            </ul>
        </div>
    </div>
</aside>