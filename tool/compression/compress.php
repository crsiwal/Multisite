<?php

$assetPath = "C:/computer/workspace/kyowal/assets";
if (!function_exists("runMinified")) {
    include 'function.php';
}
if (function_exists("joinRawData")) {
    $css_minify = array(
        "vendor/daterangepicker.min.css",
        "vendor/tooltipster.bundle.min.css",
        "vendor/codemirror.min.css",
        "vendor/select2.min.css",
        "vendor/kweditor.css",
        "main.css",
        "style.css"
    );

    $js_merge = array(
        'vendor/jquery-3.4.1.min.js',
        'vendor/jquery.cookie.js',
        'vendor/bootstrap.min.js',
        'vendor/tooltipster.bundle.min.js',
        'vendor/moment.min.js',
        'vendor/popper.min.js',
        'vendor/codemirror.min.js',
        'vendor/daterangepicker.min.js',
        'vendor/rangeslider.min.js',
        'vendor/select2.min.js',
        'vendor/xml.min.js'
    );

    $js_editor = array(
        'vendor/editor/align.js',
        'vendor/editor/code_beautifier.js',
        'vendor/editor/code_view.js',
        'vendor/editor/emoticons.js',
        'vendor/editor/font_size.js',
        'vendor/editor/image.js',
        'vendor/editor/image_manager.js',
        'vendor/editor/line_breaker.js',
        'vendor/editor/link.js',
        'vendor/editor/lists.js',
        'vendor/editor/paragraph_format.js',
        'vendor/editor/quote.js',
        'vendor/editor/save.js',
        'vendor/editor/table.js',
        'vendor/editor/url.js',
        'vendor/editor/editor.js',
    );

    $js_minify = array(
        'vendor/jquery.crypt.js',
        'database_handler.js',
        'cache_handler.js',
        'graphs.js',
        'app.js',
        'page_script.js',
        'events.js',
        'js_main.js'
    );

    /**
     * Minify CSS
     */
    runMinified($css_minify, "https://cssminifier.com/raw", "$assetPath/css/", "$assetPath/css/cache/", "css", "cache_css");

    /**
     * Only Merge JS Files
     */
    runMinified($js_editor, "https://javascript-minifier.com/raw", "$assetPath/js/", "$assetPath/js/cache/", "js", "frmwrk_js", TRUE);

    /**
     * Minify Editor JS Files
     */
    runMinified($js_editor, "https://javascript-minifier.com/raw", "$assetPath/js/", "$assetPath/js/cache/", "js", "editor_js");

    /**
     * Minify JS Files
     */
    runMinified($js_minify, "https://javascript-minifier.com/raw", "$assetPath/js/", "$assetPath/js/cache/", "js", "cache_js");
} else {
    die("Unable to work");
}