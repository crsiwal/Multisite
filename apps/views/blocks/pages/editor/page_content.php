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
<div id="edtabdesc" class="collapse show _drawer" data-parent="#edtabs" data-key="editor">
    <div class="form-group">
        <label class="sr-only" for="pEctst">Page Title</label>
        <input id="psttitle" name="title" type="text" class="form-control slugify form-field font-16 adtext" data-target="edt_slug" data-format="all" data-length="256" value="<?= isset($post["title"]) ? $post["title"] : ""; ?>" placeholder="Page title" aria-label="Page title" aria-describedby="basic-addon2">
    </div>
    <div class="form-group">
        <label class="sr-only" for="editor">Content</label>
        <textarea id="editor" name="editor" class="form-control form-textarea font-14 kwedit"><?= isset($post["content"]) ? $post["content"] : ""; ?></textarea>
    </div>
</div>