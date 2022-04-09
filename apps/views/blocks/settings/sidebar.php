<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: sidebar.php
 *  Path: application/views/dashboard/blocks/settings/sidebar.php
 *  Description: It's settings sidebar page.
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         21/02/2020              Created
 *
 */
$active = isset($active) ? $active : "";
?>
<ul class="list-group">
    <li class="list-group-item <?= ($active == "account") ? "active" : ""; ?>">
        <a href="<?= url("settings/account"); ?>" class="sdbtn font-14 d-flex justify-content-between align-items-center">
            <span>Account</span>
            <span class="badge badge-pill light-text font-18">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </span>
        </a>
    </li>
    <li class="list-group-item <?= ($active == "password") ? "active" : ""; ?>">
        <a href="<?= url("settings/password"); ?>" class="sdbtn font-14 d-flex justify-content-between align-items-center">
            <span>Password</span>
            <span class="badge badge-pill light-text font-18">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </span>
        </a>
    </li>
</ul>