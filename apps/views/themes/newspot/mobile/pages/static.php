<b:includable id='mobile-static'>
    <b:include name='mobile-header'/>
    <b:loop values='data:posts' var='post'>
        <div class="_stcont"><data:post.body/></div>
    </b:loop>
    <b:include name='mobile-footer'/>
</b:includable>