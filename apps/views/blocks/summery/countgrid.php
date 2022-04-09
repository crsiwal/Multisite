<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * *****************************************************************
 *  File: aunucounts.php
 *  Path: application/views/blocks/overview/aunucounts.php
 *  Description: This is post, Videos, Pages Summery of blog
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/09/2020              Created
 */
?>
<div class="row information-cards _drawer" data-key="counts">
    <!-- Posts block -->
    <div class="col col-12 col-md-4 gutter-right">
        <div class="card-shadow-1">
            <h2 class="card-title"><span class="font-16">Posts</span></h2>
            <div class="card-row-2">
                <span class="light-text">Total</span>
                <span class="number" id="smrctl_post">---</span>
            </div>
            <div class="card-row-3">
                <div class="numbers">
                    <p class="text">Draft</p>
                    <p class="number" id="smrdrf_post">---</p>
                </div>
                <div class="numbers">
                    <p class="text">Publish</p>
                    <p class="number" id="smrpub_post">---</p>
                </div>
                <div class="numbers _drawer" data-key="dgraph">
                    <div id="smrg_post" class="extsmalg bar-chart-container echarts-chart" style="height:4rem; min-width: 150px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col col-12 col-md-4 gutter-left gutter-right">
        <div class="card-shadow-1">
            <h2 class="card-title"><span class="font-16">Videos</span></h2>
            <div class="card-row-2">
                <span class="light-text">Total</span>
                <span class="number" id="smrctl_vdo">---</span>
            </div>
            <div class="card-row-3">
                <div class="numbers">
                    <p class="text">Draft</p>
                    <p class="number" id="smrdrf_vdo">---</p></div>
                <div class="numbers">
                    <p class="text">Publish</p>
                    <p class="number" id="smrpub_vdo">---</p>
                </div>
                <div class="numbers">
                    <div id="smrg_vdo" class="extsmalg bar-chart-container echarts-chart" style="height:4rem; min-width: 150px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Duration -->
    <div class="col col-12 col-md-4 gutter-left">
        <div class="card-shadow-1">
            <h2 class="card-title"><span class="font-16">Pages</span></h2>
            <div class="card-row-2">
                <span class="light-text">Total</span>
                <span class="number" id="smrctl_page">---</span>
            </div>
            <div class="card-row-3">
                <div class="numbers">
                    <p class="text">Draft</p>
                    <p class="number" id="smrdrf_page">---</p>
                </div>
                <div class="numbers">
                    <p class="text">Publish</p>
                    <p class="number" id="smrpub_page">---</p>
                </div>
                <div class="numbers">
                    <div id="smrg_page" class="extsmalg bar-chart-container echarts-chart" style="height:4rem; min-width: 150px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>