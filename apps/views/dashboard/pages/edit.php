<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: edit.php
 *  Path: application/views/dashboard/posts/edit.php
 *  Description: It's a edit post page of dashboard.
 * 
 * Function Added:
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         30/03/2020              Created
 *
 */
$post = isset($post) ? $post : [];
?>
<main class="main">
    <div class="container-fluid overview">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Edit Page</p>
                <?php breadcrumb(array("Pages" => "blog/pages", "Edit Page" => "pages/edit")); ?>
            </div>
        </div>
    </div>
    <div class="row row-1">
        <div class="col col-12 card-shadow-1">
            <div class="overlay-modal" id="edtabs">
                <form id="frm_edtr">
                    <div class="">
                        <ul class="list-group list-unstyled list-group-horizontal">
                            <li class="col-3 edtctab list-group-item active" data-toggle="collapse" data-target="#edtabdesc" aria-expanded="true" aria-controls="edtabdesc">Content</li>
                            <li class="col-3 edtctab list-group-item" data-toggle="collapse" data-target="#edbasic" aria-expanded="false" aria-controls="edbasic">Basic Info</li>
                            <li class="col-3 edtctab list-group-item" data-toggle="collapse" data-target="#edpreview" aria-expanded="false" aria-controls="edpreview">Preview</li>
                            <li class="col-3 edtctab list-group-item" data-toggle="collapse" data-target="#edpublish" aria-expanded="false" aria-controls="edpublish">Publish</li>
                        </ul>
                        <div class="mb-3 divider"></div>
                        <?php add_block("pages/editor/page_content", $post); ?>
                        <?php add_block("pages/editor/basic_info", ["post" => $post]); ?>
                    </div>
                    <div id="edpreview" class="collapse" data-parent="#edtabs">
                        <div id="preview" class="font-14 kprbox fr-element fr-view">No Preview</div>
                    </div>
                </form>
                <?php add_block("pages/editor/settings", $post); ?>
            </div>
        </div>
    </div>
</div>
</main>