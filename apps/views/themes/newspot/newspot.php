<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html>
<html lang='en' xmlns='https://www.w3.org/1999/xhtml' xmlns:b='https://www.google.com/2005/gml/b' xmlns:data='https://www.google.com/2005/gml/data' xmlns:expr='https://www.google.com/2005/gml/expr'>
    <head>
        <meta content='width=device-width, initial-scale=1.0' name='viewport' />
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.transitions.min.css"/>
        <b:switch var='data:blog.isMobile'>
            <b:case value="true" />
                <?php
                foreach($assets['mobile']['css'] as $css){
                    if($config->platform == 'dev'){
                        echo '<link rel="stylesheet" href="'. $config->get('B-CDN') . $css.'"/>';
                    }else{
                        echo '<link rel="stylesheet" href="'. $config->get('B-CDN') .'css/' . $css.'"/>';
                    }
                }
                    include_once 'blocks/mobile/page/widget/helper/seo.php';
                    include_once 'blocks/mobile/page/widget/helper/favicon.php';
                ?>
            <b:default />
                <?php
                foreach($assets['desktop']['css'] as $css){
                    if($config->platform == 'dev'){
                        echo '<link rel="stylesheet" href="'. $config->get('B-CDN') . $css . '"/>';
                    }else{
                        echo '<link rel="stylesheet" href="'. $config->get('B-CDN') .'css/' .$css.'"/>';
                    }
                }?>
        </b:switch>
        <b:skin>
            <![CDATA[]]>
        </b:skin>
    </head>

    <body expr:class="data:blog.pageType" expr:data-page='data:blog.pageType'>
        <b:section class='main' id='main' showaddelement='no'>
            <b:widget id='Blog1' locked='true' title='Blog Posts' type='Blog' version='1'>
                <b:includable id='main' var='top'>
                    <b:switch var='data:blog.isMobile'>
                        <b:case value="true" />
                            <b:include name='mobile' />
                        <b:default />
                           <b:include name='desktop' />
                    </b:switch>
                    <b:include name='fing-page-type' />                    
                </b:includable>
                <?php include 'blocks/mobile/index.php'; ?>
                <?php include 'blocks/desktop/index.php'; ?>                
                <?php include 'blocks/mobile/page/widget/helper/page-type.php'; ?>
            </b:widget>
        </b:section>
        <b:section id='footer' preferred='no'></b:section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://getbootstrap.com/docs/3.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
        <script async="true" src="https://www.google-analytics.com/analytics.js"></script>
        <b:switch var='data:blog.isMobile'>
            <b:case value="true" />
                <?php
                foreach($assets['mobile']['js'] as $js){
                    if($config->platform == 'dev'){
                        echo '<script src="'. $config->get('B-CDN') . $js . '"></script>';                        
                    }else{
                        echo '<script src="'. $config->get('B-CDN') . 'js/' . $js . '"></script>';                        
                    }
                }
                ?>
            <b:default />
                <?php
                foreach($assets['desktop']['js'] as $js){
                    if($config->platform == 'dev'){
                        echo '<script src="'. $config->get('B-CDN') . $js . '"></script>';
                    }else{
                        echo '<script src="'. $config->get('B-CDN') . 'js/' . $js . '"></script>';
                    }
                }
                ?>
        </b:switch>
    </body>
</html>