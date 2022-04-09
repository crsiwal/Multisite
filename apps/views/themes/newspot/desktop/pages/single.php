<b:includable id='desktop-single'>
    <b:include name='desktop-header'/>
    <div class="_ltrup container">
        <!-- Row One with multiple widgets -->
        <div class="row">
            <div class="col-xs-9">
                <b:loop values='data:posts' var='post'>
                    <b:include data='post' name='desktop-single-content'/>
                </b:loop>
                <!-- View the related category post -->
                <div class="row _ltb">
                    <div class="col-xs-12">
                        <b:include name="desktop-single-related-category"/>
                    </div>
                </div>    
            </div>
            <div class="col-xs-3">
                <b:include name="desktop-plug-trending"/>
                <b:include name="desktop-plug-toppicks"/>
            </div>
        </div>  
        
    </div>
    <b:include name='desktop-footer'/>
</b:includable>
<?php
include_once 'widget/singlepage/single-content.php';
include_once 'widget/singlepage/related-category.php';