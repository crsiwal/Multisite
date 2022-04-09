<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: header_db_default.php
 *  Path: application/views/header/header_db_default.php
 *  Description: This is default Header of dashboard.
 * 
 * Function Added:
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         17/04/2019              Created

 *
 *  Copyright (c) 2018 - AdGyde Solutions Private Limited
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of AdGyde Solutions Private Limited.
 *  The intellectual and technical concepts contained herein
 *  are proprietary to AdGyde Solutions Private Limited and
 *  are considered trade secrets and/or confidential under Law
 *  Dissemination of this information or reproduction of this material,
 *  in whole or in part, is strictly forbidden unless prior written
 *  permission is obtained from AdGyde Solutions Private Limited.
 *
 */
?>
<header class="header d-flex flex-wrap">
    <div class="header-logo d-flex justify-content-center align-items-center">
        <div class="image-container d-flex justify-content-around align-items-center">
            <a href="<?php url("/"); ?>">
                <img class="mobile-navbar-button" src="<?php icon_url('menu.png') ?>" alt="">
                <img class="blog_hlogo" src="<?= $global["blog_logo"]; ?>">
            </a>
        </div>
    </div>
    <div class="header-input-desktop d-flex align-items-center">
        <div class="h2"><?= $global["blog_name"]; ?></div>
    </div>
    <div class="header-action d-flex align-items-center ml-auto">
        <div class="header-action-download header-action-item d-flex justify-content-center">
            <img id="waiting" class="hidden" src="<?php icon_url('wait.gif') ?>" alt="">
        </div>
    </div>

    <!-- Header - Actions -->
    <div class="header-action d-flex align-items-center ml-auto">
        <div class="header-action-filter header-action-item" data-toggle="modal" data-target="#create-filter">
            <img src="<?php icon_url('filtericon.svg') ?>">
        </div>
        <div class="header-action-notification header-action-item">
            <img src="<?php icon_url('notifications 2.svg') ?>">
        </div>
        <div class="header-action-profile px-4 d-flex align-items-center px-5">
            <div>
                <img class="rounded-circle header-action-profile-photo" src="<?= $global["picture"]; ?>" title="<?= $global['name']; ?>">
            </div>
            <div class="header-action-profile-button">
                <button class="btn btn-link" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="profile-button-name"><?php echo ellipse($global['name']); ?></span>
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?php url('settings'); ?>">Settings</a>
                    <a class="dropdown-item" href="<?php url('blog'); ?>">Change Blog</a>
                    <a class="dropdown-item" href="<?php url('account/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>