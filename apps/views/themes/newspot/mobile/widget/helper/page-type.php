<!-- Helper Widget-> Set Page Type in panel -->
<b:includable id='fing-page-type'>
    <b:switch var='data:blog.pageType'>
        <b:case value="index" />
            <b:if cond='data:blog.searchLabel'>
                <input type="hidden" id="pagetype" value="label"/>
            <b:elseif cond='data:blog.searchQuery'/>
                <input type="hidden" id="pagetype" value="search"/>
            <b:else/>
                <input type="hidden" id="pagetype" value="home"/>
            </b:if>
        <b:case value="static_page" />
            <input type="hidden" id="pagetype" value="static"/>
        <b:case value="item" />
            <input type="hidden" id="pagetype" value="single"/>
        <b:case value="error_page" />
            <input type="hidden" id="pagetype" value="error"/>
        <b:case value="archive" />
            <input type="hidden" id="pagetype" value="archive"/>
        <b:default />
            <input type="hidden" id="pagetype" value="extra"/>
    </b:switch>   
</b:includable>