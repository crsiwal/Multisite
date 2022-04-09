<b:includable id='mobile-error'>
    <b:include name='mobile-header'/>
    <div class="container-fluid">
        <b:include name='mobile-page-not-found'/>
        <b:include name='mobile-errorpage-latest'/>
    </div>
     <b:include name='mobile-footer'/>
</b:includable>
<?php
include_once 'widget/errorpage/pagenotfound.php';
include_once 'widget/errorpage/latestonerrorpage.php';