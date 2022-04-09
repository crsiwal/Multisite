<b:includable id='mob-single-content' var='post'>
    <div id="_contsingle" class="_sncont">
        <b:include data='post' name='mobile-sin-seo-desc'/>
        <b:include data='post' name='mobile-sin-content'/>
        <b:include data='post' name='mobile-hidden-sin-firstimage'/>
        <b:include data='post' name='mobile-sin-feedviewer'/>
    </div>
</b:includable>


<b:includable id='mobile-sin-seo-desc' var='post'>
    <!-- Seo Description -->
    <b:if cond='data:post.snippet'>
            <meta expr:content='data:post.snippet' name="description" />
            <meta expr:content='data:post.snippet' name="twitter:description" />
            <meta expr:content='data:post.snippet' property="og:description" />
            <meta expr:content='data:post.snippet' id="ibn:description" />
            <meta expr:content='data:post.snippet' itemprop="description" />
    </b:if>
</b:includable>

<b:includable id='mobile-sin-title' var='post'>
    <div class="_stitl"><data:post.title/> </div>
</b:includable>

<b:includable id='mobile-sin-image' var='post'>
    <div>
        <b:if cond='data:post.firstImageUrl'>
            <img expr:src='data:post.firstImageUrl' />
        <b:else/>
            <img src='https://goo.gl/hWnykN' />
        </b:if>
    </div>
</b:includable>
<b:includable id='mobile-hidden-sin-firstimage' var='post'>
    <b:if cond='data:post.firstImageUrl'>
        <input type="hidden" id="sfimg" expr:value='data:post.firstImageUrl' />
    </b:if>
</b:includable>

<b:includable id='mobile-sin-content' var='post'>
    <div class="_scont"> <data:post.body/> </div>
</b:includable>

<b:includable id='mobile-sin-feedviewer' var='post'>
    <div class="_fdtc"><button id="_signfdu" class="_btgd btn btn-success btn-sm">Read in detail ..</button></div>
</b:includable>