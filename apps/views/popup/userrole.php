<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: userrole.php
 *  Path: application/views/popup/userrole.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         10/09/2020              Created
 *  
 */
?>
<div class="modal overlay-modal" id="popup_urole" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-uppercase">User Role</h2>
                <button type="button" class="close" data-dismiss="modal"><img src="<?php icon_url('close.svg'); ?>" alt=""></button>
            </div>
            <div class="modal-body">
                <form id="urole_addform" method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">User Role Name</div>
                            <div class="form-label font-12">Name of role like Super Admin, Administrator, Author.</div>
                            <div class="input-container">
                                <input id="urole_name" type="text" name="name" class="form-control form-field form-field-input slugify adtext" data-target="urole_slug" data-format="anspc" data-length="30" placeholder="User Role" aria-label="User Role" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-6 col gutter-right">
                            <div class="form-label font-18">Role Key</div>
                            <div class="form-label font-12">Role key which can be used in programming.</div>
                            <div class="input-container">
                                <input id="urole_slug" type="text" name="slug" class="form-control form-field form-field-input adtext" data-onchange="false" data-format="anundh" data-length="30" placeholder="User Role Key" aria-label="User Role Key" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-12 col gutter-right">
                            <div class="form-label font-18">Describe this Role</div>
                            <div class="form-label font-12">A brief summary of this Role. The limit is 256 characters.</div>
                            <div class="input-container">
                                <textarea id="urole_desc" name="desc" class="form-control blgtxt font-14 adtext" rows="4" data-format="all" data-length="256" value="" placeholder="Add short description" aria-label="Add short description" aria-multiline="true" aria-describedby="basic-addon2"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-buttons-container mt-4 d-flex justify-content-center">
                    <div class="modal-buttons d-flex">
                        <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        <button id="urole_add" class="btn modal-btn modal-btn-2">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>