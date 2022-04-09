<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: userrole.php
 *  Path: application/views/dashboard/access/userrole.php
 *  Description: It's a User role page.
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         10/09/2020              Created
 *
 */
?>
<main class="main">
    <div class="container-fluid setup-events">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">User Role</p>
                <?php breadcrumb(array("Admin" => "admin", "User Role" => "admin/userrole")); ?>
            </div>
            <div class="button-date-container d-flex">
                <div class="create-button-container">
                    <button id="urole_crtbtn" class="create-button btn">Add User Role</button>
                </div>
            </div>
        </div>
        <div class="row row-1 data-table-paginated">
            <div class="col col-12 card-shadow-1-data-table-paginated">
                <div class="table-container">
                    <table id="uroletable" class="table _drawer" data-key="uroletable">
                        <thead>
                            <tr class="bg-lightgray">
                                <th scope="col" class="font-13 text-darkgray-5">Role</th>
                                <th scope="col" class="font-13 text-darkgray-5">Key</th>
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