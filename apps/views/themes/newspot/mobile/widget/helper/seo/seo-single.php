<title><data:blog.pageName/> - <data:blog.title/></title>
<!-- Seo Site Name -->
<meta expr:content="data:blog.title" property="og:site_name" />
<meta expr:content="data:blog.title" name='Author' />
<meta expr:content="data:blog.title" itemprop="publisher" />

<!-- Seo Page Title -->
<meta expr:content='data:blog.pageName' id="ibn:title" />
<meta expr:content='data:blog.pageName' property="og:title" />
<meta expr:content='data:blog.pageName' itemprop="name" />
<meta expr:content='data:blog.pageName' itemprop="headline" />
<meta expr:content='data:blog.pageName' name="tweetmeme-title" />
<meta expr:content='data:blog.pageName' name="twitter:title" />

<!-- Seo Keywords -->
<!-- <meta content="" name="keywords" />
<meta content="" name="news_keywords" /> -->

<!-- Seo Post url -->
<meta expr:content='data:blog.canonicalUrl' name="msapplication-starturl" />
<meta expr:content='data:blog.canonicalUrl' property="og:url" />
<meta expr:content='data:blog.canonicalUrl' id="ibn:link" />
<meta expr:content='data:blog.canonicalUrl' itemprop="url" />
<link expr:href='data:blog.canonicalUrl' rel="canonical" />
<link expr:href='data:blog.canonicalUrl' rel="amphtml" />

<!-- Seo Post Image -->
<b:if cond='data:blog.postImageUrl'>
    <link expr:href='data:blog.postImageUrl' rel='image_src'/>
	<meta expr:content='data:blog.postImageUrl' name="twitter:image" />
	<meta expr:content='data:blog.postImageUrl' property="og:image" />
	<meta expr:content='data:blog.postImageUrl' itemprop="image" />
	<meta expr:content='data:blog.postImageUrl' id="ibn:image" />
	<meta expr:content='data:blog.postImageUrl' id="twitter:card" />
</b:if>


<!-- Seo Static Content -->
<meta content="articlepage" name="atdlayout" />
<meta content="article" property="og:type" />

<!-- Facebook Static Content -->
<meta content="267021713952434" property="fb:app_id" />
<meta content="1380540152080962" property="fb:admins" />
<meta content="1380540152080962" property="fb:pages" />
<meta content="1380540152080962" property="fb:page_id" />
<meta content='https://www.facebook.com/sabnews.in' property='article:author' />
<meta content='https://www.facebook.com/sabnews.in' property='article:publisher' />

<meta content="1902679" id="ibn:cid" />
<meta content="Politics News" name="subsection" />
<meta content="English" itemprop="inLanguage" />
<meta content="Politics" itemprop="articleSection" />
<meta content="@sabnewsin" name="twitter:site" />
<meta content='India' name='geo.placename'/>
<meta content='general' name='rating'/>
<meta content='in' name='geo.country'/>

<!-- Post Update Time -->
<!-- <meta content="2018-10-08T18:21:45+05:30" property="article:modified_time" />
<meta content="2018-10-08T18:21:45+05:30" property="og:updated_time" />
<meta content="2018-10-08T18:21:45+05:30" http-equiv="Last-Modified" /> -->

<b:if cond='data:blog.isMobile'>
    <meta content='noindex,nofollow' name='robots'/>
</b:if>

<!-- Site Verification in search engine webmaster -->
<meta content='' name='p:domain_verify'/>
<meta content='' name='wot-verification'/>
<meta content='' name='google-site-verification'/>

<!-- Contact Us details -->
<meta content='help@sabnews.in' property='og:email'/>

<!-- Seo Domain Name  -->
<meta expr:href='data:blog.canonicalHomepageUrl' name='twitter:domain'/>