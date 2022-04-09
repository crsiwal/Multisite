<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: overview.php
 *  Path: application/views/dashboard/overview.php
 *  Description: It's a overview page of dashboard.
 * 
 * Function Added:
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/06/2019              Created
 *
 */
?>
<div id="edbasic" class="collapse" data-parent="#edtabs">
    <div class="row">
        <div class="col-xs-12 col-sm-8 mtp-15">
            <div class="edt form-label">Short Description</div>
            <textarea id="edt_desc" name="desc" class="form-control form-textarea font-15 adtext" data-format="all" data-length="256" value="" placeholder="Page breif description" aria-label="Page breif description" aria-describedby="basic-addon2"><?= isset($post["metadesc"]) ? $post["metadesc"] : ""; ?></textarea>
        </div>
        <div class="col-xs-12 col-sm-4"></div>
        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Page Slug</div>
            <div class="form-label mb-3 font-12 lh-def">Page slug is the user friendly URL of a post and this is a permalink of this post.</div>
            <input type="text" id="edt_slug" name="slug" class="form-control form-field font-14 slugify <?= (isset($post["status"]) && $post["status"] == "publish") ? "readonly" : ""; ?>" data-target="edt_slug" data-format="all" data-onchange="false" data-length="256" value="<?= isset($post["slug"]) ? $post["slug"] : ""; ?>" placeholder="Page url" aria-label="Page url" aria-describedby="basic-addon2" <?= (isset($post["status"]) && $post["status"] == "publish") ? 'readonly="readonly"' : ""; ?>/>
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Page Reference URL</div>
            <div class="form-label mb-3 font-12 lh-def">URL of the website content page from which you have taken helped to write this page content.</div>
            <input type="text" id="edt_reference" name="reference" class="form-control form-field font-14 adtext" data-format="all" data-length="512" value="<?= isset($post["reference"]) ? $post["reference"] : ""; ?>" placeholder="Post reference url" aria-label="Post reference url" aria-describedby="basic-addon2"/>
        </div>
    </div>
</div>