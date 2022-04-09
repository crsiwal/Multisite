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
$tags = implode(",", ((isset($tag) && is_array($tag)) ? $tag : []));
$postType = isset($type) ? $type : "post";
?>
<div class="_contpost plt-<?= $postType; ?>" data-platform="<?= $postType; ?>">
    <div class="_content"><?= isset($content) ? $content : ""; ?></div>
    <div class="_thisinfo hidden"
         data-type="<?= $postType; ?>"
         data-summery="<?= isset($desc) ? htmlentities($desc) : ""; ?>"
         data-category="<?= isset($category) ? $category : ""; ?>"
         data-language="<?= isset($language) ? $language : ""; ?>"
         data-reference="<?= isset($reference) ? $reference : ""; ?>"
         data-thumbnail="<?= isset($thumbnail) ? $thumbnail : ""; ?>"
         data-tags="<?= $tags; ?>"></div>
</div>