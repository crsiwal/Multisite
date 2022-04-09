<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: roleaccess.php
 *  Path: application/views/dashboard/access/roleaccess.php
 *  Description: It's a update User role access page.
 *  
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         15/09/2020              Created
 *  
 */
?>
<main class="main">
    <div class="container-fluid setup-events">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Role Access</p>
                <?php breadcrumb(array("Admin" => "admin", "User Role" => "admin/userrole", "Role Access" => "admin/roleaccess")); ?>
            </div>
        </div>
        <div class="row row-1 data-table-paginated">
            <div class="col col-12 card-shadow-1-data-table-paginated">
                <div class="table-container">
                    <div class="d-flex flex-row-reverse justify-content-between">
                        <img src="<?= icon_url("scrum.svg"); ?>" class="page-corner mr-5" alt="User Role">
                        <div>
                            <h4 id="roleaccess_role" class="font-18 font-weight-bold">User Role</h4>
                            <p id="roleaccess_desc" class="font-16 lh-2 mt-3"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-12">
                <form id="roleaccess_form" method="post" action="#" enctype="multipart/form-data">
                    <input type="hidden" id="roleaccess_rid" name="role_id" value="<?= isset($role_id) ? $role_id : ''; ?>">
                    <div id="roleaccess" class="_drawer" data-key="roleaccess"></div>
                </form>
            </div>
            <div id="roleaccess_action" class="col col-12 mt-5 hidden">
                <div class="input-row d-flex flex-row-reverse">
                    <div class="button-container">
                        <button id="roleaccess_update_btn" class="btn primary-blue-button mr-4">Save Changes</button>
                        <button id="roleaccess_cancel_btn" class="btn secondary-blue-button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>