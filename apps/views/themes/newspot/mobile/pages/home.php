<b:includable id='mobile-homepage'>
    <b:include name='mobile-header'/>
    <div class="container-fluid">
        <b:include name='promoslider'/>
        <b:include name='recentlist'/>
        <b:include name='categories-iconic'/>
        <b:include name='current-city-news'/>
        <b:include name='category-entertainment'/>
        <b:include name='category-sport'/>
        <b:include name='category-politics'/>
        <b:include name='category-lifestyle'/>
        <b:include name='category-education'/>
        <b:include name='category-business'/>
        <b:include name='category-technology'/>
        <b:include name='category-health'/>
        <b:include name='category-history'/>
        <b:include name='category-adventure'/>
        <b:include name='category-science'/>
        <b:include name='category-environment'/>
        <b:include name='category-cricket'/>        
    </div>
    <b:include name='mobile-footer'/>
</b:includable>
<?php 
include_once 'header.php';
include_once 'widget/homepage/promoslider.php';
include_once 'widget/homepage/recentlist.php';
include_once 'widget/homepage/categories-iconic.php';
include_once 'widget/homepage/current-city-news.php';
include_once 'widget/category/category-entertainment.php';
include_once 'widget/category/category-adventure.php';
include_once 'widget/category/category-business.php';
include_once 'widget/category/category-cricket.php';
include_once 'widget/category/category-education.php';
include_once 'widget/category/category-environment.php';
include_once 'widget/category/category-health.php';
include_once 'widget/category/category-history.php';
include_once 'widget/category/category-lifestyle.php';
include_once 'widget/category/category-politics.php';
include_once 'widget/category/category-science.php';
include_once 'widget/category/category-sport.php';
include_once 'widget/category/category-technology.php';
include_once 'widget/helper/animated-bg.php';
include_once 'widget/helper/animated-banner.php';
include_once 'footer.php';
?>