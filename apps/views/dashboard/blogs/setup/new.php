<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: first_blog.php
 *  Path: application/views/dashboard/first_blog.php
 *  Description: Add First blog
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
    <div class="container-fluid setup-new-campaign">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Blog Setup</p>
                <?php breadcrumb(array("Setup" => "setup", "Blog" => "blog", "New" => "setup/blog")); ?>
            </div>
            <div class="button-date-container d-flex"></div>
        </div>
        <div class="tabs-container">
            <div class="content-container campaign-configuration setup-new-campaign-1 font-14">
                <div class="input-row-container">
                    <form id="frm_newblog">
                        <div class="input-row d-flex">
                            <div class="input-label-container">
                                <div class="form-label font-18">Name for your blog</div>
                                <div class="form-label font-12">This is the title that will be displayed at the top of your Blog</div>
                                <div class="input-container">
                                    <input id="blog_new_name" name="name" type="text" class="form-control form-field form-field-input adtext slugify" data-target="blog_new_url" data-format="all" data-length="30" value="" placeholder="Name" aria-label="Name" aria-describedby="basic-addon2">
                                </div>
                            </div>
                            <div class="input-label-container">
                                <div class="form-label font-18">URL for your blog</div>
                                <div class="form-label font-12">This web address is how people will find your blog online</div>
                                <div class="input-container position-relative">
                                    <input id="blog_new_url" name="url" type="text" class="form-control form-field form-field-input adtext" data-format="anudh" data-length="30" value="" placeholder="Blog Address" aria-label="Blog Address" aria-describedby="basic-addon2">
                                    <div class="vldurl"><i id="blog_valid_icon" class="fa fa-search text-muted" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="input-row d-flex">
                            <div class="input-label-container _drawer" data-key="category">
                                <div class="form-label font-16">Category for your blog</div>
                                <div class="form-label font-12">This is the category that will be assigned to your blog.</div>
                                <div class="input-container">
                                    <select name="category" id="blog_new_category" class="form-control form-field select2 appcategory">
                                        <option disabled="disabled" selected="selected" class="text-capatilize">Select Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-label-container _drawer" data-key="theme">
                                <div class="form-label font-16">Blog Theme for your blog</div>
                                <div class="form-label font-12">This is the theme that will be show to your readers.</div>
                                <div class="input-container">
                                    <select name="theme" id="blog_new_theme" class="form-control form-field select2 appcategory">
                                        <option disabled="disabled" selected="selected" class="text-capatilize">Select Theme</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="input-row d-flex">
                            <div class="input-label-container">
                                <div class="form-label font-18">Describe your Blog</div>
                                <div class="form-label font-12">A brief summary of your Blog. The limit is 255 characters.</div>
                                <div class="input-container">
                                    <textarea id="blog_new_desc" name="desc" class="form-control blgtxt font-14 adtext" rows="4" data-format="all" data-length="256" value="" placeholder="Add short description" aria-label="Add short description" aria-multiline="true" aria-describedby="basic-addon2"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="input-row d-flex">
                        <div class="button-container">
                            <button id="blog_new_btn" type="submit" class="btn primary-blue-button">Create Blog</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>