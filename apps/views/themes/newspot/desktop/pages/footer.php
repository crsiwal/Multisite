<b:includable id='desktop-footer'>
    <b:switch var='data:blog.pageType'>
        <b:case value="index" />
            <b:if cond='data:blog.searchLabel'>
                <b:include name="desktop-footer-home"/>               
            <b:elseif cond='data:blog.searchQuery'/>
                <b:include name="desktop-footer-home"/>
            <b:else/>
                <b:include name="desktop-footer-home"/>
            </b:if>
        <b:case value="static_page" />
            <b:include name="desktop-footer-home"/>
        <b:case value="item" />
            <b:include name="desktop-footer-home"/>
        <b:case value="error_page" />
            <b:include name="desktop-footer-home"/>
        <b:default />
            <b:include name="desktop-footer-home"/>
    </b:switch>
    <div class='modal-list'>
        <b:include name="desktop-feed-viewer"/>
    </div>
</b:includable>
<?php
include_once 'footer/homepage.php';
include_once 'footer/modal/modal.php';