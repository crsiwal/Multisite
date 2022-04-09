<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: blogs.php
 *  Path: application/views/dashboard/blogs.php
 *  Description: It's a blog list
 * 
 * Function Added:
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/02/2020              Created
 *
 */
$blogs = isset($blogs) ? $blogs : array();
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
            <p class="grid-title-heading">Common Settings</p>
            <p class="grid-title-subheading"></p>
        </div>
        <div class="row setup-grid-1">
            <?php
            foreach ($blogs as $blog) {
                ?>
                <div class="col col-6 col-lg-3 gutter-right gutter-tablet-right">
                    <div class="common-settings-grid-card card-shadow-2">
                        <p class=""><?= $blog->name;?></p>
                        <p class=""><?= $blog->today;?></p>
                        <p class=""><?= $blog->total;?></p>
                        <p class=""><a href="<?= url("account/useb/" . $blog->id);?>">Manage this</a></p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</main>