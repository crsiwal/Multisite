<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: accesslist.php
 *  Path: application/views/dashboard/access/accesslist.php
 *  Description: It's a User Access List page.
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/09/2020              Created
 *  
 */
?>
<main class="main">
    <div class="container-fluid setup-events">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Access</p>
                <?php breadcrumb(array("Admin" => "admin", "Access" => "admin/access")); ?>
            </div>
            <div class="button-date-container d-flex">
                <div class="create-button-container">
                    <button id="access_crtbtn" class="create-button btn">Add Access</button>
                </div>
            </div>
        </div>
        <div class="row row-1 data-table-paginated">
            <div class="col col-12 card-shadow-1-data-table-paginated">
                <div class="table-container _drawer" data-key="accesstable">
                    <table id="accesstable" class="table access">
                        <thead>
                            <tr class="bg-lightgray">
                                <th scope="col" class="font-13 text-darkgray-5">Name</th>
                                <th scope="col" class="font-13 text-darkgray-5">Key</th>
                                <th scope="col" class="font-13 text-darkgray-5">Group</th>
                                <th scope="col" class="font-13 text-darkgray-5">Description</th>
                                <th scope="col" class="font-13 text-darkgray-5">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>                    
                </div>
            </div>
        </div>
    </div>
</main>