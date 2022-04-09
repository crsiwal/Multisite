<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * *****************************************************************
 *  File: standard-post.php
 *  Path: application/views/blocks/template/standard-post.php
 *  Description: This is standard template for post.
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         09/03/2020              Created
 */
?>
<div class="_contpost plt-page" data-platform="page">
    <div class="_content"><?= isset($content) ? $content : ""; ?></div>
    <div class="_thisinfo hidden" data-type="page" data-summery="<?= isset($desc) ? htmlentities($desc) : ""; ?>" data-reference="<?= isset($reference) ? $reference : ""; ?>"></div>
</div>