<b:includable id='desktop-header'>
    <b:switch var='data:blog.pageType'>
        <b:case value="index" />
            <b:if cond='data:blog.searchLabel'>
                <b:include name="desktop-header-home"/>                
            <b:elseif cond='data:blog.searchQuery'/>
                <b:include name="desktop-header-home"/>
            <b:else/>
                <b:include name="desktop-header-home"/>
            </b:if>
        <b:case value="static_page" />
                <b:include name="desktop-header-home"/>
        <b:case value="item" />
                <b:include name="desktop-header-home"/>
        <b:case value="error_page" />
                <b:include name="desktop-header-home"/>
        <b:default />
                <b:include name="desktop-header-home"/>
    </b:switch>
</b:includable>
<?php
include_once 'header/homepage.php';
