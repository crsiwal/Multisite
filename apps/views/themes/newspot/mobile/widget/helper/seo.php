<b:switch var='data:blog.pageType'>
    <b:case value="index" />
        <b:if cond='data:blog.searchLabel'>
            <?php include_once 'seo/seo-category.php'; ?>
        <b:elseif cond='data:blog.searchQuery'/>
            <?php include_once 'seo/seo-search.php'; ?>
        <b:else/> 
            <?php include_once 'seo/seo-home.php'; ?>
        </b:if>
    <b:case value="static_page" />
            <?php include_once 'seo/seo-static.php'; ?>
    <b:case value="item" />
            <?php include_once 'seo/seo-single.php'; ?>
    <b:case value="error_page" />
            <?php include_once 'seo/seo-error.php'; ?>
    <b:case value="archive" />
            <?php include_once 'seo/seo-archive.php'; ?>
    <b:default />
        <meta name="description" content="This page is not available at www.sabnews.in" />      
</b:switch>