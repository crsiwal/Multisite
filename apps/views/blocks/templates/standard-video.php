<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * *****************************************************************
 *  File: standard-video.php
 *  Path: application/views/blocks/template/standard-video.php
 *  Description: This is standatd template for video post.
 *  
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         13/06/2020              Created
 */
$tags = implode(",", ((isset($tag) && is_array($tag)) ? $tag : []));
$info = (isset($info) && is_array($info)) ? $info : [];
$platform = isset($info["platform"]) ? $info["platform"] : "";
?>
<div class="_contpost _player plt-<?= $platform; ?>" data-platform="<?= $platform; ?>">
    <div class="_content"><?= isset($content) ? $content : ""; ?></div>
    <div class="_thisinfo hidden"
         data-type="video"
         data-platform="<?= $platform; ?>"
         data-videoid="<?= isset($info["videoId"]) ? $info["videoId"] : ""; ?>"
         data-channel="<?= isset($info["channelId"]) ? $info["channelId"] : ""; ?>"
         data-summery="<?= isset($desc) ? $desc : ""; ?>"
         data-category="<?= isset($category) ? $category : ""; ?>"
         data-language="<?= isset($language) ? $language : ""; ?>"
         data-reference="<?= isset($reference) ? $reference : ""; ?>"
         data-thumbnail="<?= isset($thumbnail) ? $thumbnail : ""; ?>"
         data-tags="<?= $tags; ?>"></div>
</div>