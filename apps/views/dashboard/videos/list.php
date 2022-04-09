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
?>
<main class="main">
    <div class="container-fluid overview">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Blog Videos</p>
                <?php breadcrumb(array("Videos" => "blog/videos")); ?>
            </div>
            <div class="button-date-container d-flex">
                <div class="create-button-container">
                    <a href="<?php url("videos/search"); ?>" class="create-button btn">New Video</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-1 data-table-paginated">
        <div class="col col-12 card-shadow-1-data-table-paginated">
            <div class="table-container">
                <ul id="videos" class="posts list-group list-group-flush pointer _drawer" data-key="videostable"></ul>
                <div class="data-table-actions d-flex justify-content-end">
                    <div class="data-table-actions-pagination">
                        <nav aria-label="Page navigation">
                            <ul id="testphonetablenav" class="pagination">
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
    <div id="videolisthtml" class="hidden">
        <li class="list-group-item pt-3 text-darkgray-5">
            <div class="media">
                <img class="mr-3" src="{thumbnail}" alt="{title}">
                <div class="media-body">
                    <h2 class="font-18 font-18 act-view btn-link text-darkgray-5" data-id="{this_id}"><a target="_blank" href="<?= rtrim(get_active_blog_url(), "/"); ?>{url}">{title}</a></h2>
                    <div class="font-12 pt-3 pslst">{description}</div>
                    <div class="font-13 pt-3">
                        <span class="float-left">
                            <span><span class="bold">Category:</span> <span class="text-capitalize">{category}</span></span>
                        </span>
                        <span class="float-right">
                            <span class="pstact">{update_time}</span>
                            <span class="pstact"><span class="bold">Status:</span> {status}</span>
                            <span class="pstact act-edit pointer font-13 btn btn-link" data-object="{tableid}" data-id="{this_id}">Edit</span>
                            <span class="pstactn act-delete pointer font-13 btn btn-link" data-object="{tableid}" data-id="{this_id}">Delete</span>
                        </span>
                    </div>
                </div>
            </div>
        </li>
    </div>    
</main>