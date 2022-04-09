<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: accessgroup.php
 *  Path: application/views/popup/accessgroup.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         12/09/2020              Created
 *  
 */
?>
<div class="modal overlay-modal" id="popup_agroup" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-uppercase">Access Group</h2>
                <button type="button" class="close" data-dismiss="modal"><img src="<?php icon_url('close.svg'); ?>" alt=""></button>
            </div>
            <div class="modal-body">
                <form id="agroup_addform" method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">Access Group Name</div>
                            <div class="form-label font-12">Name of Access Group like Users.</div>
                            <div class="input-container">
                                <input id="agroup_name" type="text" name="name" class="form-control form-field form-field-input slugify adtext" data-target="agroup_slug" data-format="anspc" data-length="30" placeholder="Access Group" aria-label="Access Group" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">Group Key</div>
                            <div class="form-label font-12">Group key which can be used in programming.</div>
                            <div class="input-container">
                                <input id="agroup_slug" type="text" name="slug" class="form-control form-field form-field-input adtext" data-onchange="false" data-format="anundh" data-length="30" placeholder="Access Group Key" aria-label="Access Group Key" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-12 col gutter-right">
                            <div class="form-label font-18">Describe this access group</div>
                            <div class="form-label font-12">A brief summary of this access group. The limit is 256 characters.</div>
                            <div class="input-container">
                                <textarea id="agroup_desc" name="desc" class="form-control blgtxt font-14 adtext" rows="4" data-format="all" data-length="256" value="" placeholder="Add short description" aria-label="Add short description" aria-multiline="true" aria-describedby="basic-addon2"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-buttons-container mt-4 d-flex justify-content-center">
                    <div class="modal-buttons d-flex">
                        <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        <button id="agroup_add" class="btn modal-btn modal-btn-2">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>