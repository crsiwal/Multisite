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
$default = (isset($default)) ? $default : "images";
?>
<main class="main">
    <div class="container-fluid colbox overview card-shadow-1">
        <div class="row d-flex justify-content-between">
            <div class="col-10 main-title-name overlay-modal">
                <div class="row">
                    <div class="col col-9">
                        <input id="colsearch" type="text" class="form-control form-field form-field-input font-18 adtext" data-format="anspc" data-length="30" placeholder="What are you searching..." aria-label="What are you searching..." aria-describedby="basic-addon2">
                        <div class="pt-3 font-12">
                            <span class="mr-20">
                                <label class="pointer">
                                    <input id="coluser" class="ichkb" type="checkbox" checked="checked"> <span>Uploaded by me</span>
                                </label>
                            </span>
                            <span class="">
                                <label class="pointer">
                                    <input id="colblog" class="ichkb" type="checkbox" checked="checked"> <span>Only this blog files</span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="button-date-container d-flex">
                            <div id="upd_search" class="create-button-container">
                                <button class="btn primary-blue-button btn-info font-16"><i class="font-20 pr-2 fa fa-search" aria-hidden="true"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php
            if (access("UPLOAD_NEW_IMAGE")) {
                ?>
                <div class="button-date-container d-flex">
                    <div id="upd_upload" class="create-button-container">
                        <button class="btn btn-success primary-blue-button font-16"><i class="font-20 pr-2 fa fa-cloud-upload" aria-hidden="true"></i> Upload</button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="row row-1">
        <div class="col col-12 card-shadow-1">
            <div class="overlay-modal" id="coltabs">
                <div class="pane _drawer" data-key="uploads">
                    <ul class="list-group list-unstyled list-group-horizontal">
                        <li class="col-3"></li>
                        <li id="upldimg" class="col-3 edtctab font-25 cln list-group-item <?= ($default == "images") ? "active" : ""; ?>" data-toggle="collapse" data-target="#colimg" aria-expanded="true" aria-controls="colimg" data-type="i"><i class="fa fa-picture-o" aria-hidden="true"></i> Images</li>
                        <li id="uplddoc" class="col-3 edtctab font-25 cln list-group-item <?= ($default == "documents") ? "active" : ""; ?>" data-toggle="collapse" data-target="#coldocs" aria-expanded="false" aria-controls="coldocs" data-type="d"><i class="fa fa-file-text-o" aria-hidden="true"></i> Documents</li>
                        <li class="col-3"></li>
                    </ul>
                    <div class="mb-3 divider"></div>
                    <div id="colimg" class="collapse <?= ($default == "images") ? "show _drawer" : ""; ?>" data-parent="#coltabs">
                        <div class="row"></div>
                    </div>
                    <div id="coldocs" class="collapse <?= ($default == "documents") ? "show _drawer" : ""; ?>" data-parent="#coltabs">
                        <div class="row"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>