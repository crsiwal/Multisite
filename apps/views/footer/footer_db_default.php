<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: footer_db_default.php
 *  Path: application/views/footer/footer_db_default.php
 *  Description: Default html footer page of dashboard.
 * 
 * Function Added:
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         17/04/2019              Created

 *
 *  Copyright (c) 2018 - AdGyde Solutions Private Limited
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of AdGyde Solutions Private Limited.
 *  The intellectual and technical concepts contained herein
 *  are proprietary to AdGyde Solutions Private Limited and
 *  are considered trade secrets and/or confidential under Law
 *  Dissemination of this information or reproduction of this material,
 *  in whole or in part, is strictly forbidden unless prior written
 *  permission is obtained from AdGyde Solutions Private Limited.
 *
 */
?>
<footer class="dffooter">
    <div id="notice" class="topnotice font-14"></div>
    <div id="overlay" class="overlay hidden"></div>
    <div  id="confirm" class="zpopover modal overlay-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content cuscnf">
                <div class="modal-header">
                    <h2 id="confirm_msg" class="modal-title">Are you sure?</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-buttons-container d-flex justify-content-center">
                        <div class="modal-buttons d-flex">
                            <button class="btn modal-btn modal-btn-2" id="confirm_yes" data-dismiss="modal">Yes</button>
                            <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  id="prompt" class="zpopover modal overlay-modal fade" role="dialog">
        <div class="modal-dialog no modal-dialog-centered">
            <div class="modal-content cuscnf">
                <div class="modal-header">
                    <h2 id="prompt_msg" class="modal-title">Are you sure?</h2>
                </div>
                <div class="modal-body">
                    <div class="">
                        <input id="prompt_field" type="text" class="form-control form-field form-field-input" placeholder="Enter Text" aria-label="Enter Text" aria-describedby="basic-addon2">
                    </div>
                    <div class="modal-buttons-container d-flex justify-content-center">
                        <div class="modal-buttons d-flex">
                            <button class="btn modal-btn modal-btn-2" id="prompt_submit" data-dismiss="modal">Submit</button>
                            <button class="btn modal-btn modal-btn-1" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>