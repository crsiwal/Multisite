<b:includable id='mobile-footer'>
    <b:switch var='data:blog.pageType'>
        <b:case value="index" />
            <b:if cond='data:blog.searchLabel'>
                <b:include name="mobile-footer-home"/>               
            <b:elseif cond='data:blog.searchQuery'/>
                <b:include name="mobile-footer-home"/>
            <b:else/>
                <b:include name="mobile-footer-home"/>
            </b:if>
        <b:case value="static_page" />
            <b:include name="mobile-footer-static"/>
        <b:case value="item" />
            <b:include name="mobile-footer-home"/>
        <b:case value="error_page" />
            <b:include name="mobile-footer-home"/>
        <b:default />
            <b:include name="mobile-footer-home"/>
    </b:switch>
    <div class='modal-list'>
        <b:include name="mobile-feed-viewer"/>
        <b:include name="mobile-modal-share"/>
    </div>
</b:includable>
<?php
include_once 'footer/homepage.php';
include_once 'footer/staticpage.php';
include_once 'footer/allother.php';
include_once 'footer/modal/modal.php';
?>