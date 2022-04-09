
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    fontAwesomeTemplate: '<i class="fa fa-[NAME] fr-deletable" aria-hidden="true"></i>',
    fontAwesomeSets: [{
      title: 'Web Application Icons',
      icon: 'address-book',
      list: ['address-book', 'address-book-o', 'address-card', 'address-card-o', 'adjust', 'american-sign-language-interpreting', 'anchor', 'archive', 'area-chart', 'arrows', 'arrows-h', 'arrows-v', 'asl-interpreting ', 'assistive-listening-systems', 'asterisk', 'at', 'audio-description', 'automobile ', 'balance-scale', 'ban', 'bank ', 'bar-chart', 'bar-chart-o ', 'barcode', 'bars', 'bath', 'bathtub ', 'battery ', 'battery-0 ', 'battery-1 ', 'battery-2 ', 'battery-3 ', 'battery-4 ', 'battery-empty', 'battery-full', 'battery-half', 'battery-quarter', 'battery-three-quarters', 'bed', 'beer', 'bell', 'bell-o', 'bell-slash', 'bell-slash-o', 'bicycle', 'binoculars', 'birthday-cake', 'blind', 'bluetooth', 'bluetooth-b', 'bolt', 'bomb', 'book', 'bookmark', 'bookmark-o', 'braille', 'briefcase', 'bug', 'building', 'building-o', 'bullhorn', 'bullseye', 'bus', 'cab ', 'calculator', 'calendar', 'calendar-check-o', 'calendar-minus-o', 'calendar-o', 'calendar-plus-o', 'calendar-times-o', 'camera', 'camera-retro', 'car', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'cart-arrow-down', 'cart-plus', 'cc', 'certificate', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'child', 'circle', 'circle-o', 'circle-o-notch', 'circle-thin', 'clock-o', 'clone', 'close ', 'cloud', 'cloud-download', 'cloud-upload', 'code', 'code-fork', 'coffee', 'cog', 'cogs', 'comment', 'comment-o', 'commenting', 'commenting-o', 'comments', 'comments-o', 'compass', 'copyright', 'creative-commons', 'credit-card', 'credit-card-alt', 'crop', 'crosshairs', 'cube', 'cubes', 'cutlery', 'dashboard ', 'database', 'deaf', 'deafness ', 'desktop', 'diamond', 'dot-circle-o', 'download', 'drivers-license ', 'drivers-license-o ', 'edit ', 'ellipsis-h', 'ellipsis-v', 'envelope', 'envelope-o', 'envelope-open', 'envelope-open-o', 'envelope-square', 'eraser', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'eyedropper', 'fax', 'feed ', 'female', 'fighter-jet', 'file-archive-o', 'file-audio-o', 'file-code-o', 'file-excel-o', 'file-image-o', 'file-movie-o ', 'file-pdf-o', 'file-photo-o ', 'file-picture-o ', 'file-powerpoint-o', 'file-sound-o ', 'file-video-o', 'file-word-o', 'file-zip-o ', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash ', 'flask', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'frown-o', 'futbol-o', 'gamepad', 'gavel', 'gear ', 'gears ', 'gift', 'glass', 'globe', 'graduation-cap', 'group ', 'hand-grab-o ', 'hand-lizard-o', 'hand-paper-o', 'hand-peace-o', 'hand-pointer-o', 'hand-rock-o', 'hand-scissors-o', 'hand-spock-o', 'hand-stop-o ', 'handshake-o', 'hard-of-hearing ', 'hashtag', 'hdd-o', 'headphones', 'heart', 'heart-o', 'heartbeat', 'history', 'home', 'hotel ', 'hourglass', 'hourglass-1 ', 'hourglass-2 ', 'hourglass-3 ', 'hourglass-end', 'hourglass-half', 'hourglass-o', 'hourglass-start', 'i-cursor', 'id-badge', 'id-card', 'id-card-o', 'image ', 'inbox', 'industry', 'info', 'info-circle', 'institution ', 'key', 'keyboard-o', 'language', 'laptop', 'leaf', 'legal ', 'lemon-o', 'level-down', 'level-up', 'life-bouy ', 'life-buoy ', 'life-ring', 'life-saver ', 'lightbulb-o', 'line-chart', 'location-arrow', 'lock', 'low-vision', 'magic', 'magnet', 'mail-forward ', 'mail-reply ', 'mail-reply-all ', 'male', 'map', 'map-marker', 'map-o', 'map-pin', 'map-signs', 'meh-o', 'microchip', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone ', 'money', 'moon-o', 'mortar-board ', 'motorcycle', 'mouse-pointer', 'music', 'navicon ', 'newspaper-o', 'object-group', 'object-ungroup', 'paint-brush', 'paper-plane', 'paper-plane-o', 'paw', 'pencil', 'pencil-square', 'pencil-square-o', 'percent', 'phone', 'phone-square', 'photo ', 'picture-o', 'pie-chart', 'plane', 'plug', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'podcast', 'power-off', 'print', 'puzzle-piece', 'qrcode', 'question', 'question-circle', 'question-circle-o', 'quote-left', 'quote-right', 'random', 'recycle', 'refresh', 'registered', 'remove ', 'reorder ', 'reply', 'reply-all', 'retweet', 'road', 'rocket', 'rss', 'rss-square', 's15 ', 'search', 'search-minus', 'search-plus', 'send ', 'send-o ', 'server', 'share', 'share-alt', 'share-alt-square', 'share-square', 'share-square-o', 'shield', 'ship', 'shopping-bag', 'shopping-basket', 'shopping-cart', 'shower', 'sign-in', 'sign-language', 'sign-out', 'signal', 'signing ', 'sitemap', 'sliders', 'smile-o', 'snowflake-o', 'soccer-ball-o ', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down ', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up ', 'space-shuttle', 'spinner', 'spoon', 'square', 'square-o', 'star', 'star-half', 'star-half-empty ', 'star-half-full ', 'star-half-o', 'star-o', 'sticky-note', 'sticky-note-o', 'street-view', 'suitcase', 'sun-o', 'support ', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'taxi', 'television', 'terminal', 'thermometer ', 'thermometer-0 ', 'thermometer-1 ', 'thermometer-2 ', 'thermometer-3 ', 'thermometer-4 ', 'thermometer-empty', 'thermometer-full', 'thermometer-half', 'thermometer-quarter', 'thermometer-three-quarters', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'times-rectangle ', 'times-rectangle-o ', 'tint', 'toggle-down ', 'toggle-left ', 'toggle-off', 'toggle-on', 'toggle-right ', 'toggle-up ', 'trademark', 'trash', 'trash-o', 'tree', 'trophy', 'truck', 'tty', 'tv ', 'umbrella', 'universal-access', 'university', 'unlock', 'unlock-alt', 'unsorted ', 'upload', 'user', 'user-circle', 'user-circle-o', 'user-o', 'user-plus', 'user-secret', 'user-times', 'users', 'vcard ', 'vcard-o ', 'video-camera', 'volume-control-phone', 'volume-down', 'volume-off', 'volume-up', 'warning ', 'wheelchair', 'wheelchair-alt', 'wifi', 'window-close', 'window-close-o', 'window-maximize', 'window-minimize', 'window-restore', 'wrench']
    }, {
      title: 'Accessibility Icons',
      icon: 'american-sign-language-interpreting',
      list: ['american-sign-language-interpreting', 'asl-interpreting ', 'assistive-listening-systems', 'audio-description', 'blind', 'braille', 'cc', 'deaf', 'deafness ', 'hard-of-hearing ', 'low-vision', 'question-circle-o', 'sign-language', 'signing ', 'tty', 'universal-access', 'volume-control-phone', 'wheelchair', 'wheelchair-alt']
    }, {
      title: 'Hand Icons',
      icon: 'hand-grab-o',
      list: ['hand-grab-o ', 'hand-lizard-o', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hand-paper-o', 'hand-peace-o', 'hand-pointer-o', 'hand-rock-o', 'hand-scissors-o', 'hand-spock-o', 'hand-stop-o ', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up']
    }, {
      title: 'Transportation Icons',
      icon: 'ambulance',
      list: ['ambulance', 'automobile ', 'bicycle', 'bus', 'cab ', 'car', 'fighter-jet', 'motorcycle', 'plane', 'rocket', 'ship', 'space-shuttle', 'subway', 'taxi', 'train', 'truck', 'wheelchair', 'wheelchair-alt']
    }, {
      title: 'Gender Icons',
      icon: 'genderless',
      list: ['genderless', 'intersex ', 'mars', 'mars-double', 'mars-stroke', 'mars-stroke-h', 'mars-stroke-v', 'mercury', 'neuter', 'transgender', 'transgender-alt', 'venus', 'venus-double', 'venus-mars']
    }, {
      title: 'Form Control Icons',
      icon: 'check-square',
      list: ['check-square', 'check-square-o', 'circle', 'circle-o', 'dot-circle-o', 'minus-square', 'minus-square-o', 'plus-square', 'plus-square-o', 'square', 'square-o']
    }, {
      title: 'Payment Icons',
      icon: 'cc-amex',
      list: ['cc-amex', 'cc-diners-club', 'cc-discover', 'cc-jcb', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'credit-card', 'credit-card-alt', 'google-wallet', 'paypal']
    }, {
      title: 'Chart Icons',
      icon: 'area-chart',
      list: ['area-chart', 'bar-chart', 'bar-chart-o ', 'line-chart', 'pie-chart']
    }, {
      title: 'Currency Icons',
      icon: 'bitcoin',
      list: ['bitcoin ', 'btc', 'cny ', 'dollar ', 'eur', 'euro ', 'gbp', 'gg', 'gg-circle', 'ils', 'inr', 'jpy', 'krw', 'money', 'rmb ', 'rouble ', 'rub', 'ruble ', 'rupee ', 'shekel ', 'sheqel ', 'try', 'turkish-lira ', 'usd', 'viacoin', 'won ', 'yen']
    }, {
      title: 'Text Editor Icons',
      icon: 'align-center',
      list: ['align-center', 'align-justify', 'align-left', 'align-right', 'bold', 'chain ', 'chain-broken', 'clipboard', 'columns', 'copy ', 'cut ', 'dedent ', 'eraser', 'file', 'file-o', 'file-text', 'file-text-o', 'files-o', 'floppy-o', 'font', 'header', 'indent', 'italic', 'link', 'list', 'list-alt', 'list-ol', 'list-ul', 'outdent', 'paperclip', 'paragraph', 'paste ', 'repeat', 'rotate-left ', 'rotate-right ', 'save ', 'scissors', 'strikethrough', 'subscript', 'superscript', 'table', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'underline', 'undo', 'unlink']
    }, {
      title: 'Brand Icons',
      icon: '500px',
      list: ['500px', 'adn', 'amazon', 'android', 'angellist', 'apple', 'bandcamp', 'behance', 'behance-square', 'bitbucket', 'bitbucket-square', 'bitcoin ', 'black-tie', 'bluetooth', 'bluetooth-b', 'btc', 'buysellads', 'cc-amex', 'cc-diners-club', 'cc-discover', 'cc-jcb', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'chrome', 'codepen', 'codiepie', 'connectdevelop', 'contao', 'css3', 'dashcube', 'delicious', 'deviantart', 'digg', 'dribbble', 'dropbox', 'drupal', 'edge', 'eercast', 'empire', 'envira', 'etsy', 'expeditedssl', 'fa ', 'facebook', 'facebook-f ', 'facebook-official', 'facebook-square', 'firefox', 'first-order', 'flickr', 'font-awesome', 'fonticons', 'fort-awesome', 'forumbee', 'foursquare', 'free-code-camp', 'ge ', 'get-pocket', 'gg', 'gg-circle', 'git', 'git-square', 'github', 'github-alt', 'github-square', 'gitlab', 'gittip ', 'glide', 'glide-g', 'google', 'google-plus', 'google-plus-circle ', 'google-plus-official', 'google-plus-square', 'google-wallet', 'gratipay', 'grav', 'hacker-news', 'houzz', 'html5', 'imdb', 'instagram', 'internet-explorer', 'ioxhost', 'joomla', 'jsfiddle', 'lastfm', 'lastfm-square', 'leanpub', 'linkedin', 'linkedin-square', 'linode', 'linux', 'maxcdn', 'meanpath', 'medium', 'meetup', 'mixcloud', 'modx', 'odnoklassniki', 'odnoklassniki-square', 'opencart', 'openid', 'opera', 'optin-monster', 'pagelines', 'paypal', 'pied-piper', 'pied-piper-alt', 'pied-piper-pp', 'pinterest', 'pinterest-p', 'pinterest-square', 'product-hunt', 'qq', 'quora', 'ra ', 'ravelry', 'rebel', 'reddit', 'reddit-alien', 'reddit-square', 'renren', 'resistance ', 'safari', 'scribd', 'sellsy', 'share-alt', 'share-alt-square', 'shirtsinbulk', 'simplybuilt', 'skyatlas', 'skype', 'slack', 'slideshare', 'snapchat', 'snapchat-ghost', 'snapchat-square', 'soundcloud', 'spotify', 'stack-exchange', 'stack-overflow', 'steam', 'steam-square', 'stumbleupon', 'stumbleupon-circle', 'superpowers', 'telegram', 'tencent-weibo', 'themeisle', 'trello', 'tripadvisor', 'tumblr', 'tumblr-square', 'twitch', 'twitter', 'twitter-square', 'usb', 'viacoin', 'viadeo', 'viadeo-square', 'vimeo', 'vimeo-square', 'vine', 'vk', 'wechat ', 'weibo', 'weixin', 'whatsapp', 'wikipedia-w', 'windows', 'wordpress', 'wpbeginner', 'wpexplorer', 'wpforms', 'xing', 'xing-square', 'y-combinator', 'y-combinator-square ', 'yahoo', 'yc ', 'yc-square ', 'yelp', 'yoast', 'youtube', 'youtube-play', 'youtube-square']
    }],
    faButtons: ['fontAwesomeBack', '|']
  });
  Object.assign(FE.POPUP_TEMPLATES, {
    'fontAwesome': '[_BUTTONS_][_CUSTOM_LAYER_]'
  });

  FE.PLUGINS.fontAwesome = function (editor) {
    var $ = editor.$; // Initialize categories with default font awesome data

    var selectedCategory = editor.opts.fontAwesomeSets[0];
    var categories = editor.opts.fontAwesomeSets;
    var faButtons = '';
    /** 
     * Initialize the font awesome icons popup 
     */

    function _initFaPopup() {
      if (editor.opts.toolbarInline) {
        // If toolbar is inline then load font-awesome buttons
        if (editor.opts.faButtons.length > 0) {
          faButtons = "<div class=\"fr-buttons fr-tabs\">".concat(editor.button.buildList(editor.opts.faButtons), "</div>");
        }
      } // Template for popup


      var template = {
        buttons: faButtons,
        custom_layer: _getFaHtml() // Create popup

      };
      var $popup = editor.popups.create('fontAwesome', template);

      _addAccessibility($popup);

      return $popup;
    }
    /** 
     * HTML for the font awesome popup 
     */


    function _getFaHtml() {
      var fa_html = "".concat(_renderCategoryHtml(categories, selectedCategory, editor.opts.fontAwesomeTemplate), "\n                     ").concat(_renderFaHtml(selectedCategory, editor.opts.fontAwesomeTemplate));
      return fa_html;
    }
    /** 
     * Shows the font awesome popup. 
     */


    function _showFaPopup() {
      var $popup = editor.popups.get('fontAwesome');
      if (!$popup) $popup = _initFaPopup();

      if (!$popup.hasClass('fr-active')) {
        // Font awesome popup.
        editor.popups.refresh('fontAwesome');
        editor.popups.setContainer('fontAwesome', editor.$tb);
        var $btn = editor.$tb.find('.fr-command[data-cmd="fontAwesome"]'); // Font awesome popup left and top position.

        var _editor$button$getPos = editor.button.getPosition($btn),
            left = _editor$button$getPos.left,
            top = _editor$button$getPos.top;

        editor.popups.show('fontAwesome', left, top, $btn.outerHeight());
      }
    }
    /** 
     * Update the category html 
     */


    function _refreshPopup() {
      editor.popups.get('fontAwesome').html(faButtons + _getFaHtml());
    }
    /** 
     * Set the selected font awesome category
     */


    function setIconCategory(categoryId) {
      selectedCategory = categories.filter(function (category) {
        return category.title === categoryId;
      })[0]; // Refresh popup for updating the popup view

      _refreshPopup();
    }
    /** 
     * Returns the font awesome popup HTML 
     */


    function _renderFaHtml(selectedCategory, faTemplate) {
      var faHtml = "\n        <div class=\"fr-icon-container fr-fa-container\">\n            ".concat(_renderEmoticon(selectedCategory, faTemplate), "\n        </div>\n        ");
      return faHtml;
    }
    /** 
     * Register keyboard events 
     */


    function _addAccessibility($popup) {
      // Register popup event.
      editor.events.on('popup.tab', function (e) {
        var $focused_item = $(e.currentTarget); // Skip if popup is not visible or focus is elsewere.

        if (!editor.popups.isVisible('fontAwesome') || !$focused_item.is('span, a')) {
          return true;
        }

        var key_code = e.which;
        var status;
        var index;
        var $el; // Tabbing.

        if (FE.KEYCODE.TAB == key_code) {
          // Extremities reached.
          if ($focused_item.is('span.fr-icon') && e.shiftKey || $focused_item.is('a') && !e.shiftKey) {
            var $tb = $popup.find('.fr-buttons'); // Focus back the popup's toolbar if exists.

            status = !editor.accessibility.focusToolbar($tb, e.shiftKey ? true : false);
          }

          if (status !== false) {
            // Build elements that should be focused next.
            var $tabElements = $popup.find('span.fr-icon:focus').first().concat($popup.findVisible(' span.fr-icon').first().concat($popup.find('a')));

            if ($focused_item.is('span.fr-icon')) {
              $tabElements = $tabElements.not('span.fr-icon:not(:focus)');
            } // Get focused item position.


            index = $tabElements.index($focused_item); // Backwards.

            if (e.shiftKey) {
              index = ((index - 1) % $tabElements.length + $tabElements.length) % $tabElements.length; // Javascript negative modulo bug.
              // Forward.
            } else {
              index = (index + 1) % $tabElements.length;
            } // Find next element to focus.


            $el = $tabElements.get(index);
            editor.events.disableBlur();
            $el.focus();
            status = false;
          }
        } // Arrows.
        else if (FE.KEYCODE.ARROW_UP == key_code || FE.KEYCODE.ARROW_DOWN == key_code || FE.KEYCODE.ARROW_LEFT == key_code || FE.KEYCODE.ARROW_RIGHT == key_code) {
            if ($focused_item.is('span.fr-icon')) {
              // Get all current icons.
              var $icons = $focused_item.parent().find('span.fr-icon'); // Get focused item position.

              index = $icons.index($focused_item); // Get icons matrix dimensions.

              var columns = 8;
              var lines = Math.floor($icons.length / columns); // Get focused item coordinates.

              var column = index % columns;
              var line = Math.floor(index / columns);
              var nextIndex = line * columns + column;
              var dimension = lines * columns; // Calculate next index. Go to the other opposite site of the matrix if there is no next adjacent element.
              // Up/Down: Traverse matrix lines.
              // Left/Right: Traverse the matrix as it is a vector.

              if (FE.KEYCODE.ARROW_UP == key_code) {
                nextIndex = ((nextIndex - columns) % dimension + dimension) % dimension; // Javascript negative modulo bug.
              } else if (FE.KEYCODE.ARROW_DOWN == key_code) {
                nextIndex = (nextIndex + columns) % dimension;
              } else if (FE.KEYCODE.ARROW_LEFT == key_code) {
                nextIndex = ((nextIndex - 1) % dimension + dimension) % dimension; // Javascript negative modulo bug.
              } else if (FE.KEYCODE.ARROW_RIGHT == key_code) {
                nextIndex = (nextIndex + 1) % dimension;
              } // Get the next element based on the new index.


              $el = $($icons.get(nextIndex)); // Focus.

              editor.events.disableBlur();
              $el.focus();
              status = false;
            }
          } // ENTER or SPACE.
          else if (FE.KEYCODE.ENTER == key_code) {
              if ($focused_item.is('a')) {
                $focused_item[0].click();
              } else {
                editor.button.exec($focused_item);
              }

              status = false;
            } // Prevent propagation.


        if (status === false) {
          e.preventDefault();
          e.stopPropagation();
        }

        return status;
      }, true);
    }
    /**
     * Render the emoticon HTML
     */


    function _renderEmoticon(selectedCategory, faTemplate) {
      var icon_html = '';
      selectedCategory.list.forEach(function (icon) {
        var iconMap = {
          dataParam1: icon,
          title: icon,
          iconValue: faTemplate.replace(/\[NAME\]/g, icon)
        };
        icon_html += "<span class=\"fr-command fr-fa-icon fr-icon\" role=\"button\" data-cmd=\"insertIcon\" data-param1=\"".concat(iconMap.dataParam1, "\" title=\"").concat(iconMap.title, "\">").concat(iconMap.iconValue, "</span>");
      });
      return icon_html;
    }
    /** 
     * Returns the Category HTML 
     */


    function _renderCategoryHtml(categories, selectedCategory, faTemplate) {
      var categoryHtml = "\n        <div class=\"fr-buttons fr-tabs fr-tabs-scroll\">\n            ".concat(_renderCategory(categories, selectedCategory, faTemplate), "\n        </div>\n        ");
      return categoryHtml;
    }
    /** 
     * Render the category to html 
     */


    function _renderCategory(categories, selectedCategory, faTemplate) {
      var buttonHtml = '';
      categories.forEach(function (category) {
        var buttonMap = {
          elementClass: category.title === selectedCategory.title ? 'fr-active fr-active-tab' : '',
          title: category.title,
          dataCmd: 'setIconCategory',
          dataParam1: category.title,
          iconValue: faTemplate.replace(/\[NAME\]/g, category.icon)
        };
        buttonHtml += "<button class=\"fr-fa-icon-category fr-command fr-btn ".concat(buttonMap.elementClass, "\" title=\"").concat(buttonMap.title, "\" data-cmd=\"").concat(buttonMap.dataCmd, "\" data-param1=\"").concat(buttonMap.dataParam1, "\"</button><span>").concat(buttonMap.iconValue, "</span>");
      });
      return buttonHtml;
    }
    /*
      * Go back to the inline editor.
    */


    function back() {
      editor.popups.hide('fontAwesome');
      editor.toolbar.showInline();
    }

    return {
      setIconCategory: setIconCategory,
      showFontAwesomePopup: _showFaPopup,
      back: back
    };
  };

  FE.DefineIcon('fontAwesome', {
    NAME: 'flag',
    SVG_KEY: 'fontAwesome'
  });
  FE.RegisterCommand('fontAwesome', {
    title: 'Font Awesome',
    icon: 'fontAwesome',
    undo: false,
    focus: false,
    refreshAfterCallback: false,
    popup: true,
    callback: function callback() {
      if (!this.popups.isVisible('fontAwesome')) {
        this.fontAwesome.showFontAwesomePopup();
      } else {
        if (this.$el.find('.fr-marker')) {
          this.events.disableBlur();
          this.selection.restore();
        }

        this.popups.hide('fontAwesome');
      }
    },
    plugin: 'fontAwesome',
    showOnMobile: true
  });
  FE.RegisterCommand('insertIcon', {
    callback: function callback(cmd, icon) {
      // Insert font awesome icons
      this.undo.saveStep();
      this.html.insert("".concat(this.opts.fontAwesomeTemplate.replace(/\[NAME\]/g, icon), "&nbsp;"));
      this.undo.saveStep();
      this.popups.hide('fontAwesome');
    }
  });
  FE.RegisterCommand('setIconCategory', {
    undo: false,
    focus: false,
    callback: function callback(cmd, category) {
      this.fontAwesome.setIconCategory(category);
    }
  });
  FE.DefineIcon('fontAwesomeBack', {
    NAME: 'arrow-left',
    SVG_KEY: 'back'
  });
  FE.RegisterCommand('fontAwesomeBack', {
    title: 'Back',
    undo: false,
    focus: false,
    back: true,
    refreshAfterCallback: false,
    callback: function callback() {
      this.fontAwesome.back();
    }
  });

})));
