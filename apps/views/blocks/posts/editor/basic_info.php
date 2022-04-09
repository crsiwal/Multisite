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
            <textarea id="edt_desc" name="desc" class="form-control form-textarea font-15 adtext" data-format="all" data-length="256" value="" placeholder="Post breif description" aria-label="Post breif description" aria-describedby="basic-addon2"><?= isset($post["metadesc"]) ? $post["metadesc"] : ""; ?></textarea>
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Post Thumbnail <span id="edt_custhumnail" class="font-14 btn cusbtn btn-outline-secondary">Set Custom</span></div>
            <figure class="">
                <input id="edt_vcusthumnail" type="hidden" name="thumbnail" value="<?= isset($post["thumbnail"]) ? $post["thumbnail"] : ""; ?>"/>
                <img id="edt_icusthumnail" class="img-fluid psthumb" src="<?= isset($post["thumbnail"]) ? $post["thumbnail"] : icon_url("thumb.jpg"); ?>">
            </figure>
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Category</div>
            <select id="edt_category" name="category" class="form-control select2 basic form-field">
                <option disabled="disabled" selected="selected" class="text-capatilize">Post Category</option>
                <?php
                if (isset($category) && is_array($category)) {
                    foreach ($category as $catobj) {
                        $name = $catobj["name"];
                        $id = $catobj["id"];
                        echo '<option value="' . $id . '"' . ((isset($post["cat_id"]) && $post["cat_id"] == $id) ? 'selected = "selected"' : "") . '>' . $name . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Language</div>
            <select id="edt_language" name="language" class="form-control select2 basic form-field">
                <option disabled="disabled" selected="selected" class="text-capatilize">Post Language</option>
                <option value="English" <?= (isset($post["lang"]) && $post["lang"] == "English") ? 'selected="selected"' : ""; ?>>English</option>
                <option value="Hindi" <?= (isset($post["lang"]) && $post["lang"] == "Hindi") ? 'selected="selected"' : ""; ?>>Hindi</option>
            </select>
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <input type="hidden" name="type" value="<?= isset($post["type"]) ? $post["type"] : "post"; ?>" />
            <?php
            if (isset($post["type"]) && $post["type"] == "video") {
                $info = isset($post["info"]) ? json_decode($post["info"], TRUE) : [];
                ?>
                <input type="hidden" name="info[videoId]" value="<?= isset($info["videoId"]) ? $info["videoId"] : ""; ?>" />
                <input type="hidden" name="info[platform]" value="<?= isset($info["platform"]) ? $info["platform"] : ""; ?>" />
                <input type="hidden" name="info[channelId]" value="<?= isset($info["channelId"]) ? $info["channelId"] : ""; ?>" />
                <?php
            }
            ?>
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Post Slug</div>
            <div class="form-label mb-3 font-12 lh-def">Post slug is the user friendly URL of a post and this is a permalink of this post.</div>
            <input type="text" id="edt_slug" name="slug" class="form-control form-field font-14 slugify <?= (isset($post["status"]) && $post["status"] == "publish") ? "readonly" : ""; ?>" data-target="edt_slug" data-format="all" data-onchange="false" data-length="256" value="<?= isset($post["slug"]) ? $post["slug"] : ""; ?>" placeholder="Post url slug" aria-label="Post url slug" aria-describedby="basic-addon2" <?= (isset($post["status"]) && $post["status"] == "publish") ? 'readonly="readonly"' : ""; ?>/>
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Post Reference URL</div>
            <div class="form-label mb-3 font-12 lh-def">URL of the website content page from which you have taken helped to write this post.</div>
            <input type="text" id="edt_reference" name="reference" class="form-control form-field font-14 adtext" data-format="all" data-length="512" value="<?= isset($post["reference"]) ? $post["reference"] : ""; ?>" placeholder="Post reference url" aria-label="Post reference url" aria-describedby="basic-addon2"/>
        </div>

        <div class="col-xs-12 col-sm-8 mtp-15">
            <div class="edt form-label">Tags</div>
            <div class="form-label mb-3 font-12 lh-def">The purpose of tags is to help link related posts together and these are more helpful to users for searching your post.</div>
            <select id="edt_tags" name="tags[]" class="form-control select2 tags form-field adtext" data-format="anundh" data-placeholder="Add tag" multiple>
                <?php
                if (isset($post["tags"])) {
                    $tags = $post["tags"];
                    foreach ($tags as $tag) {
                        echo '<option value="' . $tag . '" selected="selected">' . $tag . '</option>';
                    }
                }
                ?>
            </select>
            <div class="mt-2"><span class="float-left">Enter comma-separated values</span><span id="etag_count" class="float-right"></span></div>
        </div>

    </div>
</div>