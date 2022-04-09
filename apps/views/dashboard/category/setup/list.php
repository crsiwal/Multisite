<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: list.php
 *  Path: application/views/dashboard/category/setup/list.php
 *  Description: It's a category page.
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         02/04/2020              Created
 *
 */
?>
<main class="main">
    <div class="container-fluid setup-events">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Categories</p>
                <?php breadcrumb(array("Setup" => "setup", "Categories" => "setup/category")); ?>
            </div>
            <div class="button-date-container d-flex">
                <div id="catr_crtbtn" class="create-button-container">
                    <button class="create-button btn">Add Category</button>
                </div>
            </div>
        </div>
        <div class="row row-1 data-table-paginated">
            <div class="col col-12 card-shadow-1-data-table-paginated">
                <div class="table-container">
                    <table id="catrtable" class="table _drawer" data-key="catrtable">
                        <thead>
                            <tr class="bg-lightgray">
                                <th scope="col" class="font-13 text-darkgray-5">Id</th>
                                <th scope="col" class="font-13 text-darkgray-5">Name</th>
                                <th scope="col" class="font-13 text-darkgray-5">Slug</th>
                                <th scope="col" class="font-13 text-darkgray-5">Parent Category</th>
                                <th scope="col" class="font-13 text-darkgray-5">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="data-table-actions d-flex justify-content-end">
                        <div class="data-table-actions-pagination">
                            <nav aria-label="Page navigation">
                                <ul id="catrtablenav" class="pagination">
                                    <li class="page-item"><a data-status="last" class="page-link no-border-pagination" href="#" aria-label="Previous"><img src="<?php icon_url('arrow-left.svg') ?>" alt=""></a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a data-status="next" class="page-link no-border-pagination" href="#" aria-label="Next"><img src="<?php icon_url('arrow-right.svg') ?>" alt=""></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Button -->
    <div class="mobile-add-button">+</div>
</main>