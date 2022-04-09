<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: adgroup.php
 *  Path: application/views/popup/adgroup.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         08/04/2020              Created
 *  
 */
?>
<div class="modal overlay-modal" id="popup_adg" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-uppercase">Ad Group</h2>
                <button type="button" class="close" data-dismiss="modal"><img src="<?php icon_url('close.svg'); ?>" alt=""></button>
            </div>
            <div class="modal-body">
                <form id="adg_addform" method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 col gutter-right">
                            <input id="adg_name" type="text" name="name" class="form-control form-field form-field-input adtext" data-format="anspc" data-length="30" placeholder="Name" aria-label="Name" aria-describedby="basic-addon2">
                        </div>
                        <div class="col-6 col gutter-right">
                            <input id="adg_desc" type="text" name="desc" class="form-control form-field form-field-input adtext" data-format="all" data-length="64" placeholder="Description" aria-label="Description" aria-describedby="basic-addon2">
                        </div>
                        <div class="col-6 col gutter-right">
                            <select id="adg_platform" name="platform" class="form-control form-field select2">
                                <option value="" disabled="disabled" selected="selected">Select Platform</option>
                                <option value="a">Anyone</option>
                                <option value="d">Desktop</option>
                                <option value="t">Tablet</option>
                                <option value="m">Mobile</option>
                            </select>
                        </div>
                        <div class="col-6 col gutter-right">
                            <select id="adg_adsize" name="adsize" class="form-control form-field select2">
                                <option value="0" disabled="disabled" selected="selected">Select Ad Size</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="modal-buttons-container d-flex justify-content-center">
                    <div class="modal-buttons d-flex">
                        <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        <button id="adg_add" class="btn modal-btn modal-btn-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>