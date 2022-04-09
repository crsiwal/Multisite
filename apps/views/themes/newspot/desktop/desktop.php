<!--Start desktop layout content-->
<b:includable id='desktop'>
    <b:switch var='data:blog.pageType'>
        <b:case value="index" />
            <b:if cond='data:blog.searchLabel'>
                <div class="plabel"><b:include name="desktop-category"/></div>
            <b:elseif cond='data:blog.searchQuery'/>
                <div class="psearch"><h1>Search  Page</h1></div>
            <b:else/>
                <div class="phome"><b:include name="desktop-homepage"/></div>
            </b:if>
        <b:case value="static_page" />
            <div class="pstatic"><h1>Static Page</h1></div>
        <b:case value="item" />
            <div class="psingle"><b:include name="desktop-single"/></div>
        <b:case value="error_page" />
            <div class="perror"><b:include name="desktop-error"/></div>
        <b:case value="archive" />
            <div class="parchive">
                <h1>archive  Page</h1>
            </div>
        <b:default />
            <div class="pextra">
                <h2>Extra Page</h2>
            </div>
    </b:switch>
</b:includable>
<?php
include_once 'page/home.php';
include_once 'page/single.php';
include_once 'page/category.php';
include_once 'page/error.php';