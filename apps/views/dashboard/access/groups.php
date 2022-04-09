<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: access.php
 *  Path: application/views/dashboard/access/groups.php
 *  Description: It's a User Access Group page.
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         12/09/2020              Created
 *
 */
?>
<main class="main">
    <div class="container-fluid setup-events">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Access Group</p>
                <?php breadcrumb(array("Admin" => "admin", "Access Group" => "admin/accessgroup")); ?>
            </div>
            <div class="button-date-container d-flex">
                <div id="agroup_crtbtn" class="create-button-container">
                    <button class="create-button btn">Add Group</button>
                </div>
            </div>
        </div>
        <div class="row row-1 data-table-paginated">
            <div class="col col-12 card-shadow-1-data-table-paginated">
                <div class="table-container">
                    <table id="agrouptable" class="table the-table _drawer" data-key="agrouptable">
                        <thead>
                            <tr class="bg-lightgray">
                                <th scope="col" class="font-13 text-darkgray-5">Name</th>
                                <th scope="col" class="font-13 text-darkgray-5">Group Key</th>
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