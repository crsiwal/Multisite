<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: uploads.php
 *  Path: application/views/popup/uploads.php
 *  Description: 
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         08/04/2020              Created
 *  
 */
?>
<div class="modal overlay-modal" id="popup_cln" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="clnupl modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-uppercase">Upload</h2>
                <button type="button" class="close" data-dismiss="modal"><img src="<?php icon_url('close.svg'); ?>" alt=""></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col col-6 gutter-right">
                        <div class="dropzone">
                            <div class="position-relative pointer">
                                <form id="upd_addform" method="post" action="#" enctype="multipart/form-data">
                                    <input id="upd_file" name="clnfile" class="pointer clnfile" type="file" />
                                </form>
                                <div id="upd_preview" class="pointer clnprev hidden"></div>
                                <div id="upd_uploadview" class="drmsg">
                                    <p><i class="fa font-25 fa-folder-open" aria-hidden="true"></i></p>
                                    <p class="pt-4 font-18">Click to upload.</p>
                                    <p class="pt-3 font-12">Upload your files to your collection.</p>
                                </div>
                            </div>
                        </div>
                        <div id="upd_crpprev" class="row crprws mtp-15">   
                            <div class="col col-12">
                                <div class="btn-group mb-3">
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="setDragMode" data-option="move" title="Move">
                                        <span class="fa fa-arrows-alt"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="setDragMode" data-option="crop" title="Crop">
                                        <span class="fa fa-crop"></span>
                                    </button>
                                </div>
                                <div class="btn-group  mb-3">
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="scaleX" title="Flip Horizontal">
                                        <span class="fa fa-arrows-h"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="scaleY" title="Flip Vertical">
                                        <span class="fa fa-arrows-v"></span>
                                    </button>
                                </div>
                                <div class="btn-group mb-3">
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="rotate" data-option="-45" title="Rotate Left">
                                        <span class="fa fa-undo"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="rotate" data-option="45" title="Rotate Right">
                                        <span class="fa fa-repeat"></span>
                                    </button>
                                </div>
                                <div class="btn-group mb-3">
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="zoom" data-option="0.1" title="Zoom In">
                                        <span class="fa fa-search-plus"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                        <span class="fa fa-search-minus"></span>
                                    </button>
                                </div>
                                <div class="btn-group mb-3">
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="enable" title="Enable">
                                        <span class="fa fa-unlock"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-18" data-method="disable" title="Disable">
                                        <span class="fa fa-lock"></span>
                                    </button>
                                </div>
                                <div class="btn-group mb-3">
                                    <button type="button" class="sncbtn btn btn-primary font-ceq" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                        <span class="fa fa-arrow-left"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-ceq" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                        <span class="fa fa-arrow-right"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-ceq" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                        <span class="fa fa-arrow-up"></span>
                                    </button>
                                    <button type="button" class="sncbtn btn btn-primary font-ceq" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                        <span class="fa fa-arrow-down"></span>
                                    </button>
                                </div>
                                <div class="btn-group mb-3" data-toggle="buttons">
                                    <label id="clnrt1" class="sncbtn btn btn-outline-primary font-ceq" data-option="1.7777777777777777" data-method="setAspectRatio">
                                        <input id="clniratio1" type="radio" class="sr-only" name="aspectRatio" value="1.7777777777777777" checked="checked">
                                        <span>16:9</span>
                                    </label>
                                    <label id="clnrt2" class="sncbtn btn btn-outline-primary font-ceq" data-option="1.3333333333333333" data-method="setAspectRatio">
                                        <input id="clniratio2" type="radio" class="sr-only" name="aspectRatio" value="1.3333333333333333">
                                        <span>4:3</span>
                                    </label>
                                    <label id="clnrt3" class="sncbtn btn btn-outline-primary font-ceq" data-option="1" data-method="setAspectRatio">
                                        <input id="clniratio3" type="radio" class="sr-only" name="aspectRatio" value="1">
                                        <span>1:1</span>
                                    </label>
                                    <label id="clnrt4" class="sncbtn btn btn-outline-primary font-ceq" data-option="0.6666666666666666"" data-method="setAspectRatio">
                                        <input id="clniratio4" type="radio" class="sr-only" name="aspectRatio" value="0.6666666666666666">
                                        <span>2:3</span>
                                    </label>
                                    <label id="clnrt5" class="sncbtn btn btn-outline-primary font-ceq" data-option="NaN" data-method="setAspectRatio">
                                        <input id="clniratio5" type="radio" class="sr-only" name="aspectRatio" value="NaN">
                                        <span>Free</span>
                                    </label>
                                </div>
                                <div class="modal-buttons-container mt-1 d-flex justify-content-start">
                                    <div class="modal-buttons d-flex">
                                        <button type="button" class="sncbtn btn modal-btn modal-btn-1 ml-0" data-method="clear" title="Clear">Clear</button>
                                        <button type="button" class="sncbtn btn modal-btn modal-btn-2" data-method="reset" title="Reset">Reset</button>
                                        <button type="button" class="sncbtn btn modal-btn btn-success" data-method="crop" title="Crop">Crop</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-6 gutter-left">
                        <div id="colmodaltabs" class="pane">
                            <ul class="row list-group list-group-horizontal">
                                <li id="upd_cpopt" class="col-6 edtctab font-14 list-group-item active" data-toggle="collapse" data-target="#coloptions" aria-expanded="true" aria-controls="coloptions">Options</li>
                                <li id="upd_cpedt" class="col-6 edtctab font-14 list-group-item hidden" data-toggle="collapse" data-target="#colimgcrop" aria-expanded="false" aria-controls="colimgcrop">Edit Image</li>
                            </ul>
                            <div class="mb-3 divider"></div>
                            <div id="coloptions" class="row collapse show" data-parent="#colmodaltabs">
                                <div class="col col-12">
                                    <input id="upd_name" type="text" name="name" class="form-control form-field form-field-input adtext" data-format="all" data-length="127" placeholder="About this file" aria-label="About this file" aria-describedby="basic-addon2">
                                </div>
                                <div class="col col-12">
                                    <select id="upd_privacy" name="privacy" class="form-control form-field select2">
                                        <option value="" disabled="disabled">Who can use?</option>
                                        <?php
                                        if (access("page_upload_public")) {
                                            ?>
                                            <option value="a">Anyone</option>
                                            <?php
                                        }
                                        ?>
                                        <option value="o" selected="selected">Only me</option>
                                    </select>
                                </div>
                                <div class="col col-12">
                                    <select id="upd_tags" name="tags[]" class="form-control form-field form-field-input adtext tags select2" data-format="anundh" data-placeholder="Select Tags" multiple>
                                        <option disabled="disabled" class="text-capatilize">Select Tags</option>
                                    </select>
                                </div>
                                <div class="col col-12 mt-0 modal-buttons-container">
                                    <div class="modal-buttons d-flex">
                                        <button id="upd_submit" class="btn modal-btn btn-success">Upload</button>                                        
                                    </div>
                                </div>
                            </div>
                            <div id="colimgcrop" class="row collapse" data-parent="#colmodaltabs">
                                <div class="col col-12">
                                    <div class="h2 font-16">Recommended</div>
                                    <div class="btn-group mb-3">
                                        <button type="button" class="sncbtn btn btn-primary font-12" data-method="getCroppedCanvas" data-option="<?= canvas(160, 90); ?>"><span>160×90</span></button>
                                        <button type="button" class="sncbtn btn btn-secondary font-12" data-method="getCroppedCanvas" data-option="<?= canvas(320, 180); ?>"><span>320×180</span></button>
                                    </div>
                                    <div class="btn-group mb-3">
                                        <button type="button" class="sncbtn btn btn-success font-12" data-method="getCroppedCanvas" data-option="<?= canvas(720, 90); ?>"><span>728×90</span></button>
                                        <button type="button" class="sncbtn btn btn-danger font-12" data-method="getCroppedCanvas" data-option="<?= canvas(468, 60); ?>"><span>468×60</span></button>
                                        <button type="button" class="sncbtn btn btn-dark font-12" data-method="getCroppedCanvas" data-option="<?= canvas(320, 50); ?>"><span>320×50</span></button>
                                    </div>
                                    <div class="row">
                                        <div class="img-preview preview-lg"></div>
                                        <div class="img-preview preview-md"></div>
                                        <div class="img-preview preview-sm"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-buttons-container mt-4 d-flex justify-content-center">
                    <div class="modal-buttons d-flex">
                        <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Close</button>
                        <button id="upd_upload" class="btn modal-btn btn-danger">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>