<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * *****************************************************************
 *  File: grid.php
 *  Path: application/views/blocks/blogs/grid.php
 *  Description: This is a grid view of blogs
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         15/09/2020              Created
 */
?>
<div class="col col-12 col-lg-4 {layout_class}">
    <div class="setup-application-button-card card-shadow-2 d-flex">
        <div class="image-container application-logo-container">
            <img src="{blog_logo}" alt="">
        </div>
        <div class="title-content-container">
            <div class="setup-application-button-card-title d-flex justify-content-between">
                <div class="titlehead">{blog_name}</div>
            </div>
            <div class="setup-application-button-card-content">
                <p class="titlehead"><a class="font-14 btn btn-sm btn-link" target="_blank" href="{blog_url}">{blog_url}</a></p>
                <div class="card-row-3">
                    <div class="numbers">
                        <p class="text">Total</p>
                        <p class="number">{total_posts}</p>
                    </div>
                    <div class="numbers">
                        <p class="text">Today</p>
                        <p class="number">{today_posts}</p>
                    </div>
                    <div class="numbers text-right">
                        <div class="fixctd">
                            <a class="font-14 btn btn-sm btn-link" href="<?php url("account/setblog/{this_id}") ?>"><span class="fa fa-forward" aria-hidden="true"></span> Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>