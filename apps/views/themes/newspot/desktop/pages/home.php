<b:includable id='desktop-homepage'>
    <b:include name='desktop-header'/>
    <div class="_ltrup container">
        <!-- Row One with multiple widgets -->
        <div class="row">
            <div class="col-xs-3">
                <b:include name="desktop-plug-bigstory"/>
                <b:include name="desktop-plug-topstories"/>
            </div>
            <div class="col-xs-6">
                <b:include name="desktop-promoslider"/>
                <b:include name="desktop-plug-recommended"/>
                <b:include name="desktop-block-a"/>
                <b:include name="desktop-plug-dashline"/>
                <b:include name="desktop-block-b"/>
            </div>
            <div class="col-xs-3">
                <b:include name="desktop-plug-trending"/>
                <b:include name="desktop-plug-toppicks"/>
            </div>
        </div>
        
        <!-- First row with three category list -->
        <div class="row _ltb">
            <div class="col-xs-12">
                <b:include name="desktop-category-entertainment"/>
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-lifestyle"/>                
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-cricket"/>                
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <b:include name="desktop-block-dashline-one"/>
                <b:include name="desktop-block-dashline-two"/>
            </div>
        </div>     
        
        <!-- Second row with three category list -->
        <div class="row _ltb">
            <div class="col-xs-12">
                <b:include name="desktop-category-science"/>
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-technology"/>
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-environment"/>                
            </div>
        </div>        
        
        <!-- Third row with three category list -->
        <div class="row _ltb">
            <div class="col-xs-12">
                <b:include name="desktop-category-education"/>
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-health"/>
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-history"/>
            </div>
        </div>
        
        <!-- Fourth row with three category list -->
        <div class="row _ltb">
            <div class="col-xs-12">
                <b:include name="desktop-category-politics"/>
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-sport"/>
            </div>
            <div class="col-xs-12">
                <b:include name="desktop-category-business"/>
            </div>
        </div>        
        
        <!-- Fourth row with three category list -->
        <div class="row _ltb">
            <div class="col-xs-12">
                <b:include name="desktop-category-adventure"/>
            </div>
        </div>
        
    </div>
    <b:include name='desktop-footer'/>
</b:includable>
<?php
include_once 'header.php';
include_once 'widget/homepage/plug/big-story.php';
include_once 'widget/homepage/plug/top-stories.php';

include_once 'widget/homepage/promo-slider.php';
include_once 'widget/homepage/plug/recommended.php';
include_once 'widget/homepage/blocks/block-a.php';
include_once 'widget/homepage/blocks/block-b.php';
include_once 'widget/homepage/plug/dashline.php';

include_once 'widget/homepage/plug/trending.php';
include_once 'widget/homepage/plug/toppicks.php';

include_once 'widget/category/category-entertainment.php';
include_once 'widget/category/category-lifestyle.php';
include_once 'widget/category/category-cricket.php';

include_once 'widget/homepage/blocks/dashline-one.php';
include_once 'widget/homepage/blocks/dashline-two.php';

include_once 'widget/category/category-science.php';
include_once 'widget/category/category-technology.php';
include_once 'widget/category/category-environment.php';


include_once 'widget/category/category-education.php';
include_once 'widget/category/category-health.php';
include_once 'widget/category/category-history.php';


include_once 'widget/category/category-sport.php';
include_once 'widget/category/category-politics.php';
include_once 'widget/category/category-adventure.php';

include_once 'widget/category/category-business.php';

include_once 'widget/homepage/popular-on-home.php';
include_once 'footer.php';