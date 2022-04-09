<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ************************************************************
 *  File: summery.php
 *  Path: application/views/dashboard/home/summery.php
 *  Description: It's a user blog summery page.
 * 
 * Function Added:
 * 
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         22/02/2020              Created
 *
 */
?>
<main class="main">
    <div class="container-fluid overview">
        <div class="main-title d-flex justify-content-between">
            <div class="main-title-name">
                <p class="font-16 text-uppercase mb-2 text-darkgray">Dashboard</p>
                <?php breadcrumb(array("Summery" => "blog/summery")); ?>
            </div>
        </div>

        <!-- Block: Posts -->
        <?php add_block("summery/countgrid"); ?>

    </div>
</main>