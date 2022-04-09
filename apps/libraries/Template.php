<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Template.php
 *  Path: application/libraries/Template.php
 *  Description: This class is used for handle template for view page.
 * 
 *  Function Added:
 *  1. show($template, $data = array())
 *  2. addMeta($key = '', $value = '')
 *  3. 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         17/04/2019              Created

 *
 */
if (!class_exists('Template')) {

    class Template {

        private $head;
        private $js;

        /**
         * 
         */
        public function __construct() {
            $this->ci = & get_instance();
            $this->init();
        }

        /**
         * 
         * @param type $template
         * @param type $data
         */
        public function show($template, $data = array(), $page_name = 'unknown', $need_access = "") {
            if (access($need_access)) {
                $this->ci->logger->start("Template:show");
                $this->setPageName($page_name);
                if (is_array($data) && is_login()) {
                    $data['global'] = $this->ci->user->get_session_data();
                }
                $footer_end = array(
                    'js' => $this->js,
                    'popup' => $this->prepairPopupLocation((isset($data['popup']) && is_array($data['popup'])) ? $data['popup'] : array())
                );
                $sanitize = (ENVIRONMENT == 'development') ? FALSE : TRUE;
                switch ($sanitize) {
                    case TRUE:
                        $content = '';
                        $content .= $this->ci->load->view('header/header_db_head', $this->head, TRUE);
                        $content .= $this->ci->load->view('header/' . $this->head['header'], $data, TRUE);
                        $content .= ($this->head['sidebar_left'] != FALSE) ? $this->ci->load->view('sidebar/' . $this->head['sidebar_left'], $data, TRUE) : '';
                        $content .= $this->ci->load->view($template, $data, TRUE);
                        $content .= ($this->head['sidebar_right'] != FALSE) ? $this->ci->load->view('sidebar/' . $this->head['sidebar_right'], $data, TRUE) : '';
                        $content .= $this->ci->load->view('footer/' . $this->head['footer'], $data, TRUE);
                        $content .= $this->ci->load->view('footer/footer_db_end', $footer_end, TRUE);
                        $this->sanitize($content);
                        break;
                    case FALSE:
                        $this->ci->load->view('header/header_db_head', $this->head);
                        $this->ci->load->view('header/' . $this->head['header'], $data);
                        ($this->head['sidebar_left'] != FALSE) ? $this->ci->load->view('sidebar/' . $this->head['sidebar_left'], $data) : '';
                        $this->ci->load->view($template, $data);
                        ($this->head['sidebar_right'] != FALSE) ? $this->ci->load->view('sidebar/' . $this->head['sidebar_right'], $data) : '';
                        $this->ci->load->view('footer/' . $this->head['footer'], $data);
                        $this->ci->load->view('footer/footer_db_end', $footer_end);
                        break;
                }
                $this->ci->logger->end("Template:show");
            } else {
                show_404();
            }
        }

        /**
         * 
         * @param type $key
         * @param type $value
         */
        public function addMeta($key = '', $value = '') {
            if ($key != "") {
                switch ($key) {
                    case 'title':
                        $this->head['title'] = $value;
                        break;
                    case 'description':
                        $this->head['description'] = $value;
                        break;
                    default :
                        $this->head['meta'][$key] = $value;
                        break;
                }
            }
        }

        /**
         * 
         * @param type $name
         * @param type $path
         * @param type $isurl
         */
        public function addCss($name, $isurl = FALSE) {
            $path = $this->getCssFilePath($name);
            if ($path === FALSE) {
                $this->ci->logger->error("Template::addCss : Unknown file trying to add - $name");
            } else {
                if ($isurl === TRUE) {
                    $this->head['css'][$name] = $path;
                } else {
                    $css_path = 'css/' . $path . '.css';
                    $location = asset_path($css_path);
                    if (file_exists($location)) {
                        $this->head['css'][$name] = asset_url($css_path, TRUE);
                    } else {
                        $this->ci->logger->error("Template::addCss : File not found Location - $location");
                    }
                }
            }
        }

        /**
         * 
         * @param type $name
         * @param type $path
         * @param type $inHead
         * @param type $isurl
         */
        public function addJs($name, $inHead = FALSE, $isurl = FALSE) {
            $path = $this->getJsFilePath($name);
            if ($path === FALSE) {
                $this->ci->logger->error("Template::addJs : Unknown file trying to add - $name");
            } else {
                if ($isurl === TRUE) {
                    if ($inHead === TRUE) {
                        $this->head['js'][$name] = $path;
                    } else {
                        $this->js[$name] = $path;
                    }
                } else {
                    $js_path = 'js/' . $path . '.js';
                    $location = asset_path($js_path);
                    if (file_exists($location)) {
                        if ($inHead === TRUE) {
                            $this->head['js'][$name] = asset_url($js_path, TRUE);
                        } else {
                            $this->js[$name] = asset_url($js_path, TRUE);
                        }
                    } else {
                        $this->ci->logger->error("Template::addJs : File not found Location - $location");
                    }
                }
            }
        }

        /**
         * 
         * @param type $header
         */
        public function header($header = 'default') {
            switch ($header) {
                case 'blank':
                    $this->head['header'] = 'header_db_blank';
                    break;
                case 'login':
                    $this->head['header'] = 'header_db_login';
                    break;
                default :
                    $this->head['header'] = 'header_db_default';
                    break;
            }
        }

        /**
         * 
         * @param type $footer
         */
        public function footer($footer = 'default') {
            switch ($footer) {
                case 'blank':
                    $this->head['footer'] = 'footer_db_blank';
                    break;
                default :
                    $this->head['footer'] = 'footer_db_default';
                    break;
            }
        }

        /**
         * 
         * @param type $sidebar
         * @param type $template
         */
        public function sidebar($sidebar = '', $template = 'default') {
            switch ($sidebar) {
                case 'left':
                    $this->head['sidebar_left'] = $this->sidebarOption($template, $sidebar);
                    break;
                case 'right':
                    $this->head['sidebar_right'] = $this->sidebarOption($template, $sidebar);
                    break;
            }
        }

        /**
         * 
         */
        private function init() {
            $this->defaultCss();
            $this->defaultJs();
            $this->defaultMetaData();
            $this->header();
            $this->footer();
            $this->sidebar('left');
            $this->sidebar('right', FALSE);
        }

        /**
         * This will set the page name.
         * @param type $page_name
         */
        private function setPageName($page_name) {
            $this->ci->sessions->set_page($page_name);
        }

        /**
         * 
         * @param type $template
         * @param type $sidebar
         * @return string
         */
        private function sidebarOption($template = "", $sidebar = "") {
            $response = "";
            switch ($template) {
                case FALSE:
                    $response = FALSE;
                    break;
                default:
                    $response = 'sidebar_' . $sidebar . '_' . $template;
                    break;
            }
            return $response;
        }

        /**
         * 
         */
        private function defaultCss() {
            if (minify('css')) {
                $this->addCss('bootstrap-css');
                $this->addCss('fontawesome-css');
                $this->addCss('daterangepicker-css');
                $this->addCss('select-css');
                $compressedFiles = $this->ci->config->item('compress_css_files');
                if (is_array($compressedFiles) && count($compressedFiles) > 0) {
                    foreach ($compressedFiles as $filename => $path) {
                        $this->addCss($filename);
                    }
                }
            } else {
                $this->addCss('bootstrap-css');
                $this->addCss('fontawesome-link-css', true);
                //$this->addCss('fontawesome-css');
                $this->addCss('daterangepicker-css');
                $this->addCss('select2-css');
                $this->addCss('datatable-css');
                $this->addCss('cropper-css');
                $this->addCss('codemirror-css');
                $this->addCss('editor-css');
                $this->addCss('editor-style');
                $this->addCss('editor-char_counter');
                $this->addCss('editor-code_view');
                $this->addCss('editor-colors');
                $this->addCss('editor-draggable');
                $this->addCss('editor-emoticons');
                $this->addCss('editor-file');
                $this->addCss('editor-image');
                $this->addCss('editor-image_manager');
                $this->addCss('editor-line_breaker');
                $this->addCss('editor-quick_insert');
                $this->addCss('editor-special_characters');
                $this->addCss('editor-table');
                $this->addCss('editor-video');
                $this->addCss('editor-embedly');
                $this->addCss('editor-font_awesome');
                $this->addCss('editor-image_tui');
                //$this->addCss('editor-theme_dark');
                //$this->addCss('editor-theme_gray');
                //$this->addCss('editor-theme_royal');
                $this->addCss('main-css');
                $this->addCss('custom-css');
            }
        }

        private function defaultJs() {
            if (minify('js')) {
                $this->addJs('config-js', TRUE, TRUE);
                $compressedFiles = $this->ci->config->item('compress_js_files');
                if (is_array($compressedFiles) && count($compressedFiles) > 0) {
                    foreach ($compressedFiles as $filename => $path) {
                        $this->addJs($filename);
                    }
                }
            } else {
                $this->addJs('jquery');
                $this->addJs('popper');
                $this->addJs('bootstrap');
                $this->addJs('echarts');
                $this->addJs('ecrypt');
                $this->addJs('moment');
                $this->addJs('daterangepicker');
                $this->addJs('select2');
                $this->addJs('datatable');
                $this->addJs('bootstraptable');
                $this->addJs('cropper');
                $this->addJs('config', TRUE, TRUE);
                $this->addJs('database');
                $this->addJs('cache');
                $this->addJs('image');
                $this->addJs('app');
                $this->addJs('sidebar');
                $this->addJs('html');
                $this->addJs('page');
                $this->addJs('graph');
                $this->addJs('event');
                $this->addJs("codemirror");
                $this->addJs("xml");
                $this->addJs("editor");
                $this->addJs('editor-align');
                $this->addJs('editor-char_counter');
                $this->addJs('editor-code_beautifier');
                $this->addJs('editor-code_view');
                $this->addJs('editor-colors');
                $this->addJs('editor-draggable');
                $this->addJs('editor-edit_in_popup');
                $this->addJs('editor-emoticons');
                $this->addJs('editor-entities');
                $this->addJs('editor-file');
                $this->addJs('editor-font_family');
                $this->addJs('editor-font_size');
                $this->addJs('editor-forms');
                $this->addJs('editor-image');
                $this->addJs('editor-image_manager');
                $this->addJs('editor-inline_class');
                $this->addJs('editor-inline_style');
                $this->addJs('editor-line_breaker');
                $this->addJs('editor-line_height');
                $this->addJs('editor-link');
                $this->addJs('editor-lists');
                $this->addJs('editor-paragraph_format');
                $this->addJs('editor-paragraph_style');
                $this->addJs('editor-quick_insert');
                $this->addJs('editor-quote');
                $this->addJs('editor-save');
                $this->addJs('editor-special_characters');
                $this->addJs('editor-table');
                $this->addJs('editor-url');
                $this->addJs('editor-video');
                $this->addJs('editor-word_paste');
                $this->addJs('editor-embedly');
                $this->addJs('editor-font_awesome');
                $this->addJs('editor-image_tui');
            }
        }

        private function getJsFilePath($name) {
            $files = array(
                "jquery" => "vendor/jquery-3.4.1.min",
                "popper" => "vendor/popper.min",
                "bootstrap" => "vendor/bootstrap.min",
                "echarts" => "vendor/charts/echarts.min",
                "embedly" => "//cdn.embedly.com/widgets/platform.js",
                "tooltipster" => "vendor/tooltipster.bundle.min",
                "select2" => "vendor/select2.min",
                "moment" => "vendor/moment.min",
                "daterangepicker" => "vendor/daterangepicker.min",
                "rangeslider" => "vendor/rangeslider.min",
                "datatable" => "vendor/datatable.min",
                "bootstraptable" => "vendor/bootstrap-datatable.min",
                "cropper" => "vendor/cropper",
                "ecrypt" => "vendor/jquery.crypt",
                "config" => base_url("/assets/config"),
                "database" => "database",
                "cache" => "cache",
                "page" => "pages",
                "html" => "html",
                "image" => "image",
                "app" => "app",
                "sidebar" => "sidebar",
                "event" => "events",
                "graph" => "graphs",
                "codemirror" => "vendor/codemirror.min",
                "xml" => "vendor/xml.min",
                "editor" => "vendor/editor/editor",
                "editor-align" => "vendor/editor/plugins/align",
                "editor-char_counter" => "vendor/editor/plugins/char_counter",
                "editor-code_beautifier" => "vendor/editor/plugins/code_beautifier",
                "editor-code_view" => "vendor/editor/plugins/code_view",
                "editor-colors" => "vendor/editor/plugins/colors",
                "editor-draggable" => "vendor/editor/plugins/draggable",
                "editor-edit_in_popup" => "vendor/editor/plugins/edit_in_popup",
                "editor-emoticons" => "vendor/editor/plugins/emoticons",
                "editor-entities" => "vendor/editor/plugins/entities",
                "editor-file" => "vendor/editor/plugins/file",
                "editor-font_family" => "vendor/editor/plugins/font_family",
                "editor-font_size" => "vendor/editor/plugins/font_size",
                "editor-forms" => "vendor/editor/plugins/forms",
                "editor-image" => "vendor/editor/plugins/image",
                "editor-image_manager" => "vendor/editor/plugins/image_manager",
                "editor-inline_class" => "vendor/editor/plugins/inline_class",
                "editor-inline_style" => "vendor/editor/plugins/inline_style",
                "editor-line_breaker" => "vendor/editor/plugins/line_breaker",
                "editor-line_height" => "vendor/editor/plugins/line_height",
                "editor-link" => "vendor/editor/plugins/link",
                "editor-lists" => "vendor/editor/plugins/lists",
                "editor-paragraph_format" => "vendor/editor/plugins/paragraph_format",
                "editor-paragraph_style" => "vendor/editor/plugins/paragraph_style",
                "editor-quick_insert" => "vendor/editor/plugins/quick_insert",
                "editor-quote" => "vendor/editor/plugins/quote",
                "editor-save" => "vendor/editor/plugins/save",
                "editor-special_characters" => "vendor/editor/plugins/special_characters",
                "editor-table" => "vendor/editor/plugins/table",
                "editor-url" => "vendor/editor/plugins/url",
                "editor-video" => "vendor/editor/plugins/video",
                "editor-word_paste" => "vendor/editor/plugins/word_paste",
                "editor-embedly" => "vendor/editor/plugins/embedly",
                "editor-font_awesome" => "vendor/editor/plugins/font_awesome",
                "editor-image_tui" => "vendor/editor/plugins/image_tui",
            );
            if (minify('js')) {
                $minifiedFiles = $this->ci->config->item('minify_js_files');
                $files = (is_array($minifiedFiles) && count($minifiedFiles) > 0) ? array_merge($files, $minifiedFiles) : $files;
            }
            return isset($files[$name]) ? $files[$name] : FALSE;
        }

        private function getCssFilePath($name) {
            $files = array(
                'bootstrap-css' => 'vendor/bootstrap.min',
                'fontawesome-link-css' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
                'fontawesome-css' => 'vendor/font-awesome.min',
                'tooltipster-css' => 'vendor/tooltipster.bundle.min',
                'daterangepicker-css' => 'vendor/daterangepicker.min',
                'select2-css' => 'vendor/select2.min',
                'datatable-css' => 'vendor/datatable.min',
                'codemirror-css' => 'vendor/codemirror.min',
                "cropper-css" => "vendor/cropper",
                'editor-css' => 'vendor/editor/editor',
                'editor-style' => 'vendor/editor/style',
                'editor-char_counter' => 'vendor/editor/tool/char_counter',
                'editor-code_view' => 'vendor/editor/tool/code_view',
                'editor-colors' => 'vendor/editor/tool/colors',
                'editor-draggable' => 'vendor/editor/tool/draggable',
                'editor-emoticons' => 'vendor/editor/tool/emoticons',
                'editor-file' => 'vendor/editor/tool/file',
                'editor-image' => 'vendor/editor/tool/image',
                'editor-image_manager' => 'vendor/editor/tool/image_manager',
                'editor-line_breaker' => 'vendor/editor/tool/line_breaker',
                'editor-quick_insert' => 'vendor/editor/tool/quick_insert',
                'editor-special_characters' => 'vendor/editor/tool/special_characters',
                'editor-table' => 'vendor/editor/tool/table',
                'editor-video' => 'vendor/editor/tool/video',
                'editor-embedly' => 'vendor/editor/tool/embedly',
                'editor-font_awesome' => 'vendor/editor/tool/font_awesome',
                'editor-image_tui' => 'vendor/editor/tool/image_tui',
                'editor-theme_dark' => 'vendor/editor/layout/dark',
                'editor-theme_gray' => 'vendor/editor/layout/gray',
                'editor-theme_royal' => 'vendor/editor/layout/royal',
                'main-css' => 'main',
                'custom-css' => 'style',
            );
            if (minify('css')) {
                $minifiedFiles = $this->ci->config->item('minify_css_files');
                $files = (is_array($minifiedFiles) && count($minifiedFiles) > 0) ? array_merge($files, $minifiedFiles) : $files;
            }
            return isset($files[$name]) ? $files[$name] : FALSE;
        }

        /**
         * 
         */
        private function defaultMetaData() {
            $this->addMeta('title', 'Sab News');
            $this->addMeta('description', '');
        }

        /**
         * 
         * @param type $popupList
         * @return array
         */
        private function prepairPopupLocation($popupList = array()) {
            $popups = array();
            foreach ($popupList as $popupFileName) {
                $location = APPPATH . 'views/popup/' . $popupFileName . '.php';
                if (file_exists($location)) {
                    array_push($popups, $location);
                } else {
                    $this->ci->logger->error("Template::prepairPopupLocation : File not found Location - $location");
                }
            }
            return $popups;
        }

        /**
         * 
         * @param type $content
         */
        private function showPage($content) {
            switch (ENVIRONMENT) {
                case 'development':
                    echo $content;
                    break;
                default:
                    echo $this->sanitize($content);
                    break;
            }
        }

        /**
         * 
         * @param type $content
         */
        private function sanitize($content) {
            $search = array(
                '/\>[^\S ]+/s', // strip whitespaces after tags, except space
                '/[^\S ]+\</s', // strip whitespaces before tags, except space
                '/(\s)+/s', // shorten multiple whitespace sequences
                '/<!--(.|\s)*?-->/' // Remove HTML comments
            );

            $replace = array(
                '>',
                '<',
                '\\1',
                ''
            );
            echo preg_replace($search, $replace, $content);
        }

    }

}