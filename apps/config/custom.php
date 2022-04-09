<?php

defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: custom.php
 *  Path: app/config/custom.php
 *  Description: These are configurations which used in project for diffrent purposes.
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         18/01/2020              Created
 *
 */

$config['version'] = '2.0.0';

/* Browser Local Cache configs */
$config['js_config']['table_max_row'] = 150; // This is a number of rows show to user in table (integer value)
$config['js_config']['cache_clear_minutes'] = 60; // Number of minutes in which local cache data will be expire (integer value)

/* Minified assests configs */
$config['minify_css_files']["cache_css"] = "cache/eZLzN0vm6k.min";
$config['minify_js_files']["frmwrk_js"] = "cache/7KN5k940kO.min";
$config['minify_js_files']["editor_js"] = "cache/EGaLOs3pdz.min";
$config['minify_js_files']["cache_js"] = "cache/c0Z4sRDaGg.min";

/* Image Host Service credentials */
$config['imgur_clientid'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$config['imgur_secret'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$config['imgur-endpoint'] = "https://api.imgur.com/3/";

/* Short Url Service Credentials */
$config['bitly-login'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$config['bitly-apikey'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$config['bitly-apiurl'] = "http://api.bitly.com/v3/shorten?callback=?";

/* Google Console Credentils */
$config['g-project'] = "Sab News 2";
$config['g-apikey'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$config['g-client'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com";
$config['g-secret'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$config['g-oauth'] = "https://www.googleapis.com/oauth2/v4/token";
$config['g-authaccess'] = "https://accounts.google.com/o/oauth2/auth";
$config['g-authtoken'] = "https://accounts.google.com/o/oauth2/token";
$config['g-infotoken'] = "https://www.googleapis.com/oauth2/v1/tokeninfo";
$config['g-infouser'] = "https://www.googleapis.com/oauth2/v1/userinfo";
$config['g-apiaccess'] = array(
	"profile" => "https://www.googleapis.com/auth/userinfo.profile",
	//"blogger" => "https://www.googleapis.com/auth/blogger",
	"useremail" => "https://www.googleapis.com/auth/userinfo.email",
	"googleplus" => "https://www.googleapis.com/auth/plus.me",
	//"googlephoto" => "https://www.googleapis.com/auth/photoslibrary",
);
$config['g-grantaccess'] = implode(' ', $config['g-apiaccess']);
$config['gb-endpoint'] = "https://www.googleapis.com/blogger/v3/";
$config['gp-endpoint'] = "https://photoslibrary.googleapis.com/v1/";
$config['yt-endpoint'] = "https://www.googleapis.com/youtube/v3/";

switch (ENVIRONMENT) {
	case 'production':
		$config['base_url'] = 'http://www.example.com';
		$config['cdn_url'] = 'http://cdn.example.com';
		$config['google_UA'] = 'UA-xxxxx-1';
		$config['minify_css'] = $config['minify_js'] = true;
		$config['js_config']['debuging'] = false;
		$config['js_config']['jstrace'] = false;
		$config['js_config']['cache_enable'] = true; // This enable local storage of data in user system (TRUE / FALSE)
		break;
	case 'testing':
		$config['base_url'] = 'http://test.example.com';
		$config['cdn_url'] = 'http://tcdn.example.com';
		$config['google_UA'] = 'UA-xxxxxx-1';
		$config['minify_css'] = $config['minify_js'] = true;
		$config['js_config']['debuging'] = false;
		$config['js_config']['jstrace'] = false;
		$config['js_config']['cache_enable'] = true; // This enable local storage of data in user system (TRUE / FALSE)
		break;
	case 'development':
		$config['base_url'] = 'http://localhost.example.net';
		$config['cdn_url'] = 'http://localhost.cdn.net';
		$config['google_UA'] = 'UA-xxxxx-1';
		$config['minify_css'] = $config['minify_js'] = false;
		$config['js_config']['debuging'] = false;
		$config['js_config']['jstrace'] = false;
		$config['js_config']['cache_enable'] = true; // This enable local storage of data in user system (TRUE / FALSE)
		break;
}
