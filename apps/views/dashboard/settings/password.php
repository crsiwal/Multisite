<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: password.php
 *  Path: application/views/dashboard/settings/password.php
 *  Description: It's a change user password page.
 * 
 * Function Added:
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         21/02/2020              Created
 *
 */
?>
<main class="main pdt-15">
    <div class="container overview">
        <div class="row">
            <div class="col-3">
                <nav id="sidebar">
                    <?php add_block("settings/sidebar", array("active" => "password"), "public") ?>
                </nav>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col col-12">
                        <div class="card-shadow-1">
                            <div class="chart-title">
                                <p class="font-16 text-darkgray bold">Password</p>
                                <p class="pdt-5">Change your password or recover your current one.</p>
                            </div>
                            <div class="content-container pdt-15 font-14">
                                <form id="frm_pass" class="overlay-modal">
                                    <div class="row">
                                        <div class="col">
                                            <input id="password" name="pass" type="text" class="form-control form-field form-field-input adtext" data-format="all" data-length="40" value="" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                </form>
                                <div class="input-row d-flex">
                                    <div class="button-container">
                                        <button id="psd_change" type="submit" class="btn primary-blue-button">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>