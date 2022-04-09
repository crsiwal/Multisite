<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: access.php
 *  Path: application/views/popup/access.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/09/2020              Created
 *  
 */
?>
<div class="modal overlay-modal" id="popup_access" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-uppercase">Access</h2>
                <button type="button" class="close" data-dismiss="modal"><img src="<?php icon_url('close.svg'); ?>" alt=""></button>
            </div>
            <div class="modal-body">
                <form id="access_addform" method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">Name</div>
                            <div class="form-label font-12">Name of Access like Add User, Edit User.</div>
                            <div class="input-container">
                                <input id="access_name" type="text" name="name" class="form-control form-field form-field-input slugify adtext" data-target="access_slug" data-format="anspc" data-length="30" placeholder="Access Name" aria-label="Access Name" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">Key</div>
                            <div class="form-label font-12">Access key which can be used in programming.</div>
                            <div class="input-container">
                                <input id="access_slug" type="text" name="slug" class="form-control form-field form-field-input adtext" data-onchange="false" data-format="anundh" data-length="30" placeholder="Access Key" aria-label="Access Key" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">Group</div>
                            <div class="form-label font-12">A Group which belongs to this access.</div>
                            <select id="access_group" name="group" class="form-control form-field select2">
                                <option value="0" selected="selected">Select Group</option>
                            </select>
                        </div>
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">Purpose</div>
                            <div class="form-label font-12">Define purpose of this access in system.</div>
                            <div class="input-container">
                                <input id="access_desc" type="text" name="desc" class="form-control form-field form-field-input adtext" data-format="anspc" data-length="252" placeholder="Define access purpose" aria-label="Define access purpose" aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-buttons-container mt-4 d-flex justify-content-center">
                    <div class="modal-buttons d-flex">
                        <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        <button id="access_add" class="btn modal-btn modal-btn-2">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>