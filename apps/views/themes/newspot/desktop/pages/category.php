<b:includable id='desktop-category'>
    <b:include name='desktop-header'/>
    <div class="_ltrup container">
        <!-- Row One with multiple widgets -->
        <div class="row">
            <div class="col-xs-9">
                <b:include name="desktop-label-grid"/>    
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
include_once 'widget/labelpage/label.php';