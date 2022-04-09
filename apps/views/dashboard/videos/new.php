<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: overview.php
 *  Path: apps/views/dashboard/videos/new.php
 *  Description: It's a new video post page.
 * 
 * Function Added:
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         07/06/2020              Created
 *
 */
?>
<main class="main">
    <div class="container-fluid overview">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">New Video</p>
                <?php breadcrumb(array("Posts" => "blog/videos", "New Video" => "videos/new")); ?>
            </div>
        </div>
    </div>
    <div class="row row-1">
        <div class="col col-12 card-shadow-1">
            <div class="overlay-modal" id="edtabs">
                <form id="frm_edtr">
                    <div class="pane">
                        <ul class="list-group list-unstyled list-group-horizontal">
                            <li class="col-3 edtctab list-group-item active" data-toggle="collapse" data-target="#edtabdesc" aria-expanded="true" aria-controls="edtabdesc">Description</li>
                            <li class="col-3 edtctab list-group-item" data-toggle="collapse" data-target="#edbasic" aria-expanded="false" aria-controls="edbasic">Basic Info</li>
                            <li class="col-3 edtctab list-group-item" data-toggle="collapse" data-target="#edpreview" aria-expanded="false" aria-controls="edpreview">Preview</li>
                            <li class="col-3 edtctab list-group-item" data-toggle="collapse" data-target="#edpublish" aria-expanded="false" aria-controls="edpublish">Publish</li>
                        </ul>
                        <div class="mb-3 divider"></div>
                        <?php add_block("posts/editor/post_content"); ?>
                        <?php add_block("posts/editor/basic_info"); ?>
                    </div>
                    <div id="edpreview" class="collapse" data-parent="#edtabs">
                        <div id="preview" class="font-14 kprbox fr-element fr-view">No Preview</div>
                    </div>
                </form>
                <?php add_block("posts/editor/settings"); ?>
            </div>
        </div>
    </div>
</main>