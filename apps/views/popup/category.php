<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: category.php
 *  Path: application/views/popup/category.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/04/2020              Created
 *  
 */
?>
<div class="modal overlay-modal" id="popup_catr" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-uppercase">Category</h2>
                <button type="button" class="close" data-dismiss="modal"><img src="<?php icon_url('close.svg'); ?>" alt=""></button>
            </div>
            <div class="modal-body">
                <form id="crt_addform" method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 col gutter-right">
                            <input id="catr_name" type="text" name="name" class="form-control form-field form-field-input slugify adtext" data-target="catr_slug" data-format="anspc" data-length="30" placeholder="Category Name" aria-label="Category Name" aria-describedby="basic-addon2">
                        </div>
                        <div class="col-6 col gutter-right">
                            <input id="catr_slug" type="text" name="slug" class="form-control form-field form-field-input adtext" data-format="anundh" data-length="30" placeholder="Category Slug" aria-label="Category Slug" aria-describedby="basic-addon2">
                        </div>
                        <div class="col-6 col gutter-right">
                            <select id="catr_parent" name="parent" class="form-control form-field select2">
                                <option value="0" selected="selected">Main Category</option>
                            </select>
                        </div>

                    </div>
                </form>
                <div class="modal-buttons-container mt-4 d-flex justify-content-center">
                    <div class="modal-buttons d-flex">
                        <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        <button id="catr_add" class="btn modal-btn modal-btn-2">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>