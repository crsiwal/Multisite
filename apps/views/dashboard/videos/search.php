<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: search.php
 *  Path: apps/views/dashboard/videos/search.php
 *  Description: It's a video search page in diffrent platforms
 * 
 * Function Added:
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         06/06/2019              Created
 *
 */
?>
<main class="main">
    <div class="container-fluid overview">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Create Video Post</p>
                <?php breadcrumb(array("Videos" => "blog/videos", "Search Video" => "videos/search")); ?>
            </div>
        </div>
    </div>
    <div class="row row-1 card-shadow-1">
        <div class="col col-2"></div>
        <div class="col col-8 video-box overlay-modal">
            <div class="form-group">
                <input id="vdo_search" name="title" type="text" class="form-control form-field font-16 vdiseacrh adtext" data-format="all" data-length="64" value="" placeholder="Search Video" aria-label="Search Video" aria-describedby="basic-addon2">                
                <ul id="vdo_list" class="vdlist hidden list-group pointer"></ul>
                <div class="vdplatform text-center mtp-15">
                    <?php
                    video_platform("Youtube", "yt", "SEARCH_YOUTUBE_VIDEO", TRUE);
                    video_platform("Facebook", "fb", "SEARCH_FACEBOOK_VIDEO");
                    video_platform("Vimeo", "vm", "SEARCH_VIMEO_VIDEO");
                    ?>
                </div>
            </div>
        </div>
        <div class="col col-2"></div>
    </div>
</main>