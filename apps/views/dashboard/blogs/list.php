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
?>
<main class="main">
    <div class="container-fluid setup-applications">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Blogs</p>
                <?php breadcrumb(array("Blogs" => "blog")); ?>
            </div>
            <div class="button-date-container d-flex">
                <div class="create-button-container">
                    <a href="<?php url("setup/blog") ?>" class="btn btn-success primary-blue-button pl-5 pr-5">
                        <span class="fa fa-plus-square font-18 pr-3 align-middle" aria-hidden="true"></span>
                        <span class="font-14">Start New Blog</span>
                    </a>
                </div>
            </div>
        </div>
        <div id="blogs" class="row setup-application-grid-1 _drawer" data-key="blogs_grid"></div>
        <div class="hidden" id="blogshtml">
            <?php //add_block("blogs/grid"); ?>
            <?php add_block("blogs/card"); ?>
        </div>
    </div>
</main>