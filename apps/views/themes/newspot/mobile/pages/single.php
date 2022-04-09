<b:includable id='mobile-single'>
    <b:include name='mobile-header'/>
    <div class="container-fluid">
        <div class="row">
            <div class="_shrclic">
                <b:loop values='data:posts' var='post'>
                    <b:include data='post' name='mob-single-content'/>
                </b:loop>
                <b:include name='mobile-follow-social'/>
            </div>
            <b:include name='mobile-trending-list'/>
            <b:include name='mobile-recommended-list'/>
            <b:include name='mobile-recent-popular'/>
        </div>
    </div>
    <b:include name='mobile-footer'/>
</b:includable>
<?php 
include_once 'header.php';
include_once 'widget/singlepage/single-content.php';
include_once 'widget/singlepage/follow-social.php';
include_once 'widget/singlepage/trending-list.php';
include_once 'widget/singlepage/recommended-list.php';
include_once 'widget/singlepage/recent-popular.php';
include_once 'footer.php';
?>