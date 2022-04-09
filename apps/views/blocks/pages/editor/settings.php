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
$postBtnDraft = (isset($post["status"]) && $post["status"] == "publish" ) ? "Revert to draft" : ((isset($post["status"]) && $post["status"] == "draft" ) ? "Update" : "Save" );
$postBtnPublish = (isset($post["status"]) && $post["status"] == "publish" ) ? "Update" : "Publish";
?>
<div id="edpublish" class="collapse" data-parent="#edtabs">
    <div class="row">
        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Content Declaration</div>
            This post not contain any violation content.
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Content Copyright</div>
            I have a original content.
        </div>

        <div class="col-xs-12 col-sm-4 mtp-15">
            <div class="edt form-label">Post Statistics</div>
            Make statistics publicly visible.
        </div>

        <div class="col-12 mtp-15">
            <div class="input-row d-flex">
                <div class="button-container">
                    <button id="edt_btn_psad" data-postid="<?= isset($post["id"]) ? $post["id"] : ""; ?>" type="submit" class="btn edtbtn primary-blue-button btn-info"><?= $postBtnDraft; ?></button>
                    <button id="edt_btn_pdsd" type="submit" class="btn edtbtn primary-blue-button btn-danger">Discard</button>
                    <button id="edt_btn_pplh" data-postid="<?= isset($post["id"]) ? $post["id"] : ""; ?>" type="submit" class="btn edtbtn btn-success primary-blue-button"><?= $postBtnPublish; ?></button>
                </div>
            </div>
        </div>
    </div>
</div>