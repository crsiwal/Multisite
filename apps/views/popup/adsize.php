<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: adsize.php
 *  Path: application/views/popup/adsize.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         05/04/2020              Created
 *  
 */
?>
<div class="modal overlay-modal" id="popup_ads" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-uppercase">Ad Sizes</h2>
                <button type="button" class="close" data-dismiss="modal"><img src="<?php icon_url('close.svg'); ?>" alt=""></button>
            </div>
            <div class="modal-body">
                <form id="ads_addform" method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 col gutter-right">
                            <input id="ads_name" type="text" name="name" class="form-control form-field form-field-input slugify adtext" data-target="ads_sitekey" data-format="anspc" data-length="30" placeholder="AdSize Name" aria-label="AdSize Name" aria-describedby="basic-addon2">
                        </div>
                        <div class="col-6 col gutter-right">
                            <input id="ads_sitekey" type="text" name="sitekey" class="form-control form-field form-field-input slugify adtext" data-target="ads_sitekey" data-format="anundh" data-onchange="false" data-length="30" placeholder="AdSize Site Key" aria-label="AdSize Site Key" aria-describedby="basic-addon2">
                        </div>
                        <div class="col-6 col gutter-right">
                            <?= form_dropdown('width', get_number_select(50, 1200, 5, "Select Ads Width"), null, 'id="ads_width" class="form-control form-field select2"'); ?>
                        </div>
                        <div class="col-6 col gutter-right">
                            <?= form_dropdown('height', get_number_select(50, 1200, 5, "Select Ads Height"), null, 'id="ads_height" class="form-control form-field select2"'); ?>
                        </div>
                    </div>
                </form>
                <div class="modal-buttons-container d-flex justify-content-center">
                    <div class="modal-buttons d-flex">
                        <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        <button id="ads_add" class="btn modal-btn modal-btn-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>