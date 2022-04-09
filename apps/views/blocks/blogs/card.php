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
<div class="col col-12 col-md-4 col-lg-3 p-2 d-flex flex-row">
    <div class="card blog-card border-0 card-shadow-2 p-0">
        <div class="card border-0">
            <img class="card-img-top blog-card-img" src="https://xitelive.com/blog/wp-content/uploads/2017/12/banner.jpg"/>
            <div class="card-img-overlay"></div>
        </div>
        <div class="card-body d-flex flex-row">
            <img src="{blog_logo}" class="rounded-circle mr-3" height="50px" width="50px" alt="{blog_name}">
            <div>
                <h4 class="card-title font-20 font-weight-bold mb-2 blog-login">{blog_name}</h4>
                <a class="card-text btn btn-link blog-login p-0 font-14" target="_blank" href="{blog_url}">https://www.{blog_url}.com</a> <span class="fa fa-external-link" aria-hidden="true"></span>
            </div>
        </div>
        <div class="card-body pt-1">
            <p class="card-text desc">{blog_desc}</p>
            <div class="mt-4 d-flex justify-content-between">
                <p class="text mb-4">Posts <span class="number">{total_posts}</span></p>
                <p class="text mb-4">Today <span class="number">{today_posts}</span></p>
            </div>
            <div class="mt-2">
                <div class="card-title font-16 hidden">Posts</div>
                <div class="d-flex justify-content-between">
                    <p class="card-text"></p>
                    <a class="btn btn-outline-primary blog-login pl-3 pr-5 font-14" href="<?php url("account/setblog/{this_id}") ?>"> <span class="fa fa-sign-in pr-2" aria-hidden="true"></span> Log In as {blog_name}</a>
                </div>
            </div>
        </div>
    </div>
</div>