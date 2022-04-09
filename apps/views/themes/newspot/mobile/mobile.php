<!--Start mobile layout content-->
<b:includable id='mobile'>
 <div class='container'>    
    <div class='row'>
            <b:switch var='data:blog.pageType'>
                <b:case value="index" />
                    <b:if cond='data:blog.searchLabel'>
                        <div class="plabel">
                            <b:include name="mobile-category"/> 
                        </div>
                    <b:elseif cond='data:blog.searchQuery'/>
                        <div class="psearch">
                             <b:include name="mobile-search"/>
                        </div>
                    <b:else/>
                        <div class="phome">
                            <b:include name="mobile-homepage"/>                                                
                        </div>                    
                    </b:if>
                <b:case value="static_page" />
                    <div class="pstatic">
                        <b:include name="mobile-static"/>
                    </div>
                <b:case value="item" />
                    <div class="psingle">
                        <b:include name="mobile-single"/>                     
                    </div>                
                <b:case value="error_page" />
                    <div class="perror">
                        <b:include name="mobile-error"/> 
                    </div>
                <b:case value="archive" />
                    <div class="parchive">
                        <h1>archive  Page</h1>                    
                    </div>
                <b:default />
                    <div class="pextra">
                        <h2>Extra Page</h2>                    
                    </div>
            </b:switch>
    </div>
 </div>
</b:includable>
<?php
include_once 'page/home.php';
include_once 'page/single.php';
include_once 'page/category.php';
include_once 'page/search.php';
include_once 'page/static.php';
include_once 'page/error.php';
?>