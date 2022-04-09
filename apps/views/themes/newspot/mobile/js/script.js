$(document).ready(function(){
/** Class Db for manage the local database of website **/
function Db() {
    this.storage = ( typeof(Storage) !== "undefined" )? 'local' : 'cookie';
}
$.extend( Db.prototype, {
      setNode: function( $key, $value ) {
		$value = this.safe( $value );
        if( this.storage == 'local' ){
			localStorage.setItem( $key, $value );
		}else{
			$.cookie( $key, $value, { expires: 365 } );
		}
      },
      getNode: function( $key ) {
		if( this.storage == 'local' ){
			$value = localStorage.getItem( $key );
		}else{
			$value = $.cookie( $key );
		}
		if(typeof( $value ) == 'undefined' || $value == 'undefined' || $value == null || $value == 'null' || $value == ''){
			return null;
		}else{
			return this.safe( $value, true );
		}
		},
	  removeNode: function( $key ) {
        if( this.storage == 'local' ){
			localStorage.removeItem( $key );
		}else{
			$.cookie( $key, null );
		}
	  },
	  setTempNode: function( $key, $value ){
		$value = this.safe( $value );
        if( this.storage == 'local' ){
			sessionStorage.setItem( $key, $value );
		}else{
			$.cookie( $key, $value, { expires: 0 } );
		}
	  },
	  getTempNode: function( $key ){
		if( this.storage == 'local' ){
			$value = sessionStorage.getItem( $key );
		}else{
			$value = $.cookie( $key );
		}
		if( typeof( $value ) == 'undefined' || $value == null || $value == 'null' || $value == '' ){
			return null;
		}else{
			return this.safe( $value, true );
		}
      },
	  removeTempNode: function( $key ){
		if( this.storage == 'local' ){
			sessionStorage.removeItem( $key );
		}else{
			$.cookie( $key, null );
		}
	},
	safe: function( $value, $return ){
		return ( $return == true )? JSON.parse( $value ) : JSON.stringify( $value );
	}
});

var app = function() {
    this.debuging = false;
	this.page = $('body').data('page');
	this.db = new Db();
	this.init(this.page);
	window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
	ga('create', (this.debuging == true)? 'UA-99096977-1':'UA-105527165-1', 'auto'); // Change 
	this.push('pageview');
}
$.extend( app.prototype,{
	init: function(page){
		switch(page){
			case 'item':
				this.relatedlist();
				this.latestlist();
				this.weeklypopular();
				this.push("landtosingle");
			break;
			case 'index':
				this.push("landtohome");
			break;
		}
	},
	validateMobile: function(phone) {
		var re = /\d{5}([- ]*)\d{6}/;
		return re.test(String(phone).toLowerCase());
    },
	validateEmail: function(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
    },
	push: function(action, label, value, object, eventname) {
		action 	= (typeof action !== 'undefined') ? action : false;
		object 	= (typeof object !== 'undefined') ? object : 'Not Available';
		label 	= (typeof label !== 'undefined') ? label : 'Not Available';
		value 	= (typeof value !== 'undefined') ? value : 'Not Available';
		this.debug("Analytics Call: Action: " + action + " :: Object: " + object + " :: Event: " + eventname + " :: Label : " + label + " :: Value: " + value);
		switch(action){
			case 'pageview':
				ga('send', 'pageview', location.pathname);
			break;
			case 'gotoread':
				ga('send', 'event', 'Clicks', 'Homepage Clicks', 'Read More');
			break;
			case 'previouspage':
				ga('send', 'event', 'Clicks', 'Single Page Clicks', 'Previous Page Clicks');
			break;
			case 'nextpage':
				ga('send', 'event', 'Clicks', 'Single Page Clicks', 'Next Page Clicks');
			break;
			case 'recommended':
				ga('send', 'event', 'Clicks', 'Single Page Clicks', 'Recommended Clicks');
			break;
			case 'recentpost':
				ga('send', 'event', 'Clicks', 'Single Page Clicks', 'Recent Post Clicks');
			break;
			case 'weeklypopular':
				ga('send', 'event', 'Clicks', 'Single Page Clicks', 'Weekly Popular Clicks');
			break;
			case 'clickonlogo':
				ga('send', 'event', 'Clicks', 'Clicks on Logo', 'Logo Clicked');
			break;
			case 'wpshare':
				ga('send', 'event', 'Whatsapp Share', 'Whatsapp Single Page Share', 'wpshare- ' + label, 1);
			break;
			case 'wplistshare':
				ga('send', 'event', 'Whatsapp Share', 'Whatsapp List Page Share', 'wpshare- ' + label, 1);
			break;
			case 'landtohome':
				ga('send', 'event', 'Total Page Views', 'User On Page', 'Homepage Views', 1);
			break;
			case 'landtosingle':
				ga('send', 'event', 'Total Page Views', 'User On Page', 'Homepage Views', 1);
			break;
			case 'landtostatic':
				ga('send', 'event', 'Total Page Views', 'User On Page', 'Homepage Views', 1);
			break;
			case 'reading':
				ga('send', 'event', 'Post Reading', 'Single Post Reading', 'Single Post Read - ' + label, 1);
			break;
			case 'wpskip':
				ga('send', 'event', 'Subscription Popup', 'Whatsapp Subscription', 'Skip Wp Subscription', 1);
			break;
			case 'wpjoin':
				ga('send', 'event', 'Subscription Popup', 'Whatsapp Subscription', 'Wp Subscribed', 1);
			break;
			case 'adsclick':
				ga('send', 'event', 'Advertisement', label, value, 1);
			break;
			case 'skipads':
				ga('send', 'event', 'Skip Advertisement', label, value, 1);
			break;
		}
    },
	showLoad: function(hide){
		if(hide == true){
			$(".lodmr").addClass('hidden');
		}else{
			$(".lodmr").removeClass('hidden');
		}
	},
	loadMore: function(){
		$next = $('#_nextlist');
		$url = $next.val();
		if($.trim($url) == ""){
			return false;
		}
		$this = this;
		$this.db.setNode('loading', 'true');
		$this.showLoad();
		$.ajax({
			dataType: "html",
			url: $url,
			success: function($response){
				$body = $($response).find('.conlist').html();
				$('.conlist').append($body);
				$nextUrl = $($response).find('#_nextlist').val();
				$next.val($nextUrl);
				$this.showLoad(true);
				$this.db.setNode('loading', 'false');
			}
		});
    },
	debug: function($content) {
		if(this.debuging == true){
			console.log($content);
		}
    },
	redirect: function($url) {
		window.location.href = $url;
    },
	getRandom: function($to){
		$to = ( typeof $to == 'undefined' || $to == "")? 3000 : $to;
		return Math.floor(Math.random() * $to) + 1;
	},
	relatedlist: function(){
		$start = this.getRandom();
		$url = "/feeds/posts/default?alt=json&max-results=20&start-index=" + $start;
		$tmp = this;
		$.ajax({
			dataType: "json",
			url: $url,
			success: function(response){
					var list = response.feed.entry;
					$.each( list, function( i, row ){
						var subject  = row.title.$t;
						var path	 = row.link[4].href;
						$("#relatedcall").append('<li><a href="'+path+'">'+subject+'</a></li>');
					});
				}
		});
	},
	latestlist: function(){
		$url = "/feeds/posts/default?alt=json&max-results=5&start-index=1";
		$tmp = this;
		$.ajax({
			dataType: "json",
			url: $url,
			success: function(response){
					var list = response.feed.entry;
					$.each( list, function( i, row ){
						var subject  = row.title.$t;
						var path	 = row.link[4].href;
						$("#nv-latest").append('<li><a href="'+path+'">'+subject+'</a></li>');
					});
				}
		});
	},
	weeklypopular: function(){
		$start = this.getRandom();
		$url = "/feeds/posts/default?alt=json&max-results=5&start-index=" + $start;
		$tmp = this;
		$.ajax({
			dataType: "json",
			url: $url,
			success: function(response){
					var list = response.feed.entry;
					$.each( list, function( i, row ){
						var subject  = row.title.$t;
						var path	 = row.link[4].href;
						$("#nv-popular").append('<li><a href="'+path+'">'+subject+'</a></li>');
					});
				}
		});
	},
	isThisExist: function(name){
		return ( $(name).length == 0 )? false : true;
	},
	getScrollHeight: function(){
		$scrollTop = $(document).scrollTop();
		$windowHeight = $(window).height();
		$bodyHeight = $(document).height() - $windowHeight;
		$scrollPercentage = ( $scrollTop / $bodyHeight );
		return $scrollPercentage;
	},
	onScrollAction:function(){
		$scrollPercentage = this.getScrollHeight();
		if( $scrollPercentage > 0.5 ) {
			if( this.db.getNode('loading') != 'true' ){
				switch(this.page){
					case 'item':
						
					break;
					case 'index':
						this.loadMore();
					break;
				}
			}
		}
	},
	wpshare: function(html, url){
			html = html + '\n\nWebsite: ' + url;
			$message = window.encodeURIComponent(html);
			//$message = 'https://wa.me/?text=' + $message;
			//$message = 'https://api.whatsapp.com/send?text=' + $message;
			$message = 'whatsapp://send?text=' + $message;
			this.redirect($message);
	}
});

$app = new app();
/*** Jquery Event Handle ***/
$('body').on('click', '.read', function() {
		$url = $(this).data('link');
		$app.push("gotoread");
		$app.redirect($url);
});

$('body').on('click', '.logo', function() {
		$app.push("clickonlogo");
		$app.redirect('/');
});

/** Detect Click on Recommended Post click **/
$('body').on('click', '#relatedcall li', function() {
		$app.push("recommended");
});

/** Detect Click on Recent Post click **/
$('body').on('click', '#nv-latest li', function() {
		$app.push("recentpost");
});

/** Detect Click on Popular Post click **/
$('body').on('click', '#nv-popular li', function() {
		$app.push("weeklypopular");
});

/** Detect Single Page Click on Whatsapp Share Button **/
$('body').on('click', '.wpbtnshr', function() {
	$title  = $.trim($("._stitle").text());
	$body 	= $.trim($("._pcontent").text());
	$url	= $(this).data('url');
	$app.push("wpshare", $title);
	$app.wpshare($body, $url);
});

/** Detect List Cards Click on Send to Friends Button **/
$('body').on('click', '.linker', function() {
	$title  = $.trim($(this).data('title'));	
	$url	= $(this).data('link');
	$body 	= $.trim($(this).closest("._card").find(".cardbody").text());
	$app.push("wplistshare", $title);
	$app.wpshare($body, $url);
});

$(document).scroll(function(){
   $app.onScrollAction();
});

$('body').on('click', '.navl', function() {
		$url = $(this).data('link');
		if($(this).hasClass("_snavl")){
			$app.push("previouspage");
		}else if($(this).hasClass("_snavr")){
			$app.push("nextpage");
		}		
		$app.redirect($url);
});
});