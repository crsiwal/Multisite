<b:includable id='desktop-error'>
    <b:include name='desktop-header'/>
    <div class="_ltrup container">
        <!-- Row One with multiple widgets -->
        <div class="row">
            <div class="col-xs-12">
                <!-- Show Not found message -->
                <div class="row _ltb">
                    <div class="col-xs-12">
                        <b:include name="desktop-page-not-found"/>
                    </div>
                </div>
                <!-- View the related category post -->
                <div class="row _ltb">
                    <div class="col-xs-12">
                        <b:include name="desktop-errorpage-latest"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <b:include name='desktop-footer'/>
</b:includable>
<?php
include_once 'widget/errorpage/pagenotfound.php';
include_once 'widget/errorpage/latestonerrorpage.php';