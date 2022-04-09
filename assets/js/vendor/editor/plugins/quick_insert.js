(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    quickInsertButtons: ['image', 'video', 'embedly', 'table', 'ul', 'ol', 'hr'],
    quickInsertTags: ['p', 'div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'blockquote'],
    quickInsertEnabled: true
  });
  FE.QUICK_INSERT_BUTTONS = {};
  FE.DefineIcon('quickInsert', {
    SVG_KEY: 'add',
    template: 'svg'
  });

  FE.RegisterQuickInsertButton = function (name, data) {
    FE.QUICK_INSERT_BUTTONS[name] = Object.assign({
      undo: true
    }, data);
  };

  FE.RegisterQuickInsertButton('image', {
    icon: 'insertImage',
    requiredPlugin: 'image',
    title: 'Insert Image',
    undo: false,
    callback: function callback() {
      var editor = this;
      var $ = editor.$;

      if (!editor.shared.$qi_image_input) {
        editor.shared.$qi_image_input = $(document.createElement('input')).attr('accept', 'image/' + editor.opts.imageAllowedTypes.join(', image/').toLowerCase()).attr('name', "quickInsertImage".concat(this.id)).attr('style', 'display: none;').attr('type', 'file');
        $('body').first().append(editor.shared.$qi_image_input);
        editor.events.$on(editor.shared.$qi_image_input, 'change', function () {
          var inst = $(this).data('inst');

          if (this.files) {
            inst.quickInsert.hide();
            inst.image.upload(this.files);
          } // Chrome fix.


          $(this).val('');
        }, true);
      }

      editor.$qi_image_input = editor.shared.$qi_image_input;
      if (editor.helpers.isMobile()) editor.selection.save();
      editor.events.disableBlur();
      editor.$qi_image_input.data('inst', editor)[0].click();
    }
  });
  FE.RegisterQuickInsertButton('video', {
    icon: 'insertVideo',
    requiredPlugin: 'video',
    title: 'Insert Video',
    undo: false,
    callback: function callback() {
      var res = prompt(this.language.translate('Paste the URL of the video you want to insert.'));

      if (res) {
        this.video.insertByURL(res);
      }
    }
  });
  FE.RegisterQuickInsertButton('embedly', {
    icon: 'embedly',
    requiredPlugin: 'embedly',
    title: 'Embed URL',
    undo: false,
    callback: function callback() {
      var res = prompt(this.language.translate('Paste the URL of any web content you want to insert.'));

      if (res) {
        this.embedly.add(res);
      }
    }
  });
  FE.RegisterQuickInsertButton('table', {
    icon: 'insertTable',
    requiredPlugin: 'table',
    title: 'Insert Table',
    callback: function callback() {
      this.table.insert(2, 2);
    }
  });
  FE.RegisterQuickInsertButton('ol', {
    icon: 'formatOL',
    requiredPlugin: 'lists',
    title: 'Ordered List',
    callback: function callback() {
      this.lists.format('OL');
    }
  });
  FE.RegisterQuickInsertButton('ul', {
    icon: 'formatUL',
    requiredPlugin: 'lists',
    title: 'Unordered List',
    callback: function callback() {
      this.lists.format('UL');
    }
  });
  FE.RegisterQuickInsertButton('hr', {
    icon: 'insertHR',
    title: 'Insert Horizontal Line',
    callback: function callback() {
      this.commands.insertHR();
    }
  });

  FE.PLUGINS.quickInsert = function (editor) {
    var $ = editor.$;
    var $quick_insert;
    /*
     * Set the quick insert button left and top.
     */

    function _place($tag) {
      // Quick insert's possition.
      var qiTop;
      var qiLeft;
      var qiTagAlign;
      qiTop = $tag.offset().top - editor.$box.offset().top;

      if ((editor.$iframe && editor.$iframe.offset().left || 0) + $tag.offset().left < $quick_insert.outerWidth()) {
        qiLeft = $tag.offset().left + $quick_insert.outerWidth();
      } else {
        qiLeft = 0 - $quick_insert.outerWidth();
      }

      if (editor.opts.enter != FE.ENTER_BR) {
        qiTagAlign = ($quick_insert.outerHeight() - $tag.outerHeight()) / 2;
      } // Enter key is BR. Insert an empty SPAN to get line height.
      else {
          var $span = $(document.createElement('span')).html(FE.INVISIBLE_SPACE);
          $span.insertAfter($tag);
          qiTagAlign = ($quick_insert.outerHeight() - $tag.next().outerHeight()) / 2;
          $tag.next().remove();
        }

      if (editor.opts.iframe) {
        var iframePaddingTop = editor.helpers.getPX(editor.$wp.find('.fr-iframe').css('padding-top'));
        qiTop += editor.$iframe.offset().top + iframePaddingTop;
      } // Reposition QI helper if visible.


      if ($quick_insert.hasClass('fr-on')) {
        if (qiTop >= 0) {
          $helper.css('top', qiTop - qiTagAlign);
        }
      } // Set quick insert's top and left.


      if (qiTop >= 0 && qiTop - Math.abs(qiTagAlign) <= editor.$box.outerHeight() - $tag.outerHeight()) {
        if ($quick_insert.hasClass('fr-hidden')) {
          if ($quick_insert.hasClass('fr-on')) _showQIHelper();
          $quick_insert.removeClass('fr-hidden');
        }

        $quick_insert.css('top', qiTop - qiTagAlign);
      } else if ($quick_insert.hasClass('fr-visible')) {
        $quick_insert.addClass('fr-hidden');

        _hideHelper();
      }

      $quick_insert.css('left', qiLeft);
    }
    /*
     * Show quick insert.
     * Compute top, left, width and show the quick insert.
     */


    function _show($tag) {
      if (!$quick_insert) _initquickInsert(); // Hide the quick insert helper if visible.

      if ($quick_insert.hasClass('fr-on')) {
        _hideHelper();
      }

      editor.$box.append($quick_insert); // Quick insert's possition.

      _place($tag);

      $quick_insert.data('tag', $tag); // Show the quick insert.

      $quick_insert.addClass('fr-visible');
    }
    /*
     * Check the tag where the cursor is.
     */


    function _checkTag() {
      // If editor has focus.
      if (editor.core.hasFocus()) {
        var tag = editor.selection.element(); // Get block tag if Enter key is not BR.

        if (editor.opts.enter != FE.ENTER_BR && !editor.node.isBlock(tag)) {
          tag = editor.node.blockParent(tag);
        }

        if (editor.opts.enter == FE.ENTER_BR && !editor.node.isBlock(tag)) {
          var deep_tag = editor.node.deepestParent(tag);
          if (deep_tag) tag = deep_tag;
        }

        var _enterInBR = function _enterInBR() {
          return editor.opts.enter != FE.ENTER_BR && editor.node.isEmpty(tag) && editor.opts.quickInsertTags.indexOf(tag.tagName.toLowerCase()) >= 0;
        };

        var _enterInP = function _enterInP() {
          return editor.opts.enter == FE.ENTER_BR && (tag.tagName == 'BR' && (!tag.previousSibling || tag.previousSibling.tagName == 'BR' || editor.node.isBlock(tag.previousSibling)) || editor.node.isEmpty(tag) && (!tag.previousSibling || tag.previousSibling.tagName == 'BR' || editor.node.isBlock(tag.previousSibling)) && (!tag.nextSibling || tag.nextSibling.tagName == 'BR' || editor.node.isBlock(tag.nextSibling)));
        };

        if (tag && (_enterInBR() || _enterInP())) {
          // If the quick insert is not repositioned, just close the helper.
          if ($quick_insert && $quick_insert.data('tag').is($(tag)) && $quick_insert.hasClass('fr-on')) {
            _hideHelper();
          } // If selection is collapsed.
          else if (editor.selection.isCollapsed()) {
              _show($(tag));
            }
        } // Quick insert should not be visible.
        else {
            hide();
          }
      }
    }
    /*
     * Hide quick insert.
     */


    function hide() {
      if ($quick_insert) {
        // Hide the quick insert helper if visible.
        if ($quick_insert.hasClass('fr-on')) {
          _hideHelper();
        } // Hide the quick insert.


        $quick_insert.removeClass('fr-visible fr-on');
        $quick_insert.css('left', -9999).css('top', -9999);
      }
    }
    /*
     * Show the quick insert helper.
     */


    var $helper;

    function _showQIHelper(e) {
      if (e) e.preventDefault(); // Hide helper.

      if ($quick_insert.hasClass('fr-on') && !$quick_insert.hasClass('fr-hidden')) {
        _hideHelper();
      } else {
        if (!editor.shared.$qi_helper) {
          var btns = editor.opts.quickInsertButtons;
          var btns_html = '<div class="fr-qi-helper">';
          var idx = 0;

          for (var i = 0; i < btns.length; i++) {
            var info = FE.QUICK_INSERT_BUTTONS[btns[i]];

            if (info) {
              if (!info.requiredPlugin || FE.PLUGINS[info.requiredPlugin] && editor.opts.pluginsEnabled.indexOf(info.requiredPlugin) >= 0) {
                btns_html += "<a class=\"fr-btn fr-floating-btn\" role=\"button\" title=\"".concat(editor.language.translate(info.title), "\" tabIndex=\"-1\" data-cmd=\"").concat(btns[i], "\" style=\"transition-delay: ").concat(0.025 * idx++, "s;\">").concat(editor.icon.create(info.icon), "</a>");
              }
            }
          }

          btns_html += '</div>';
          editor.shared.$qi_helper = $(btns_html); // Quick insert helper tooltip.

          editor.tooltip.bind(editor.shared.$qi_helper, 'a.fr-btn');
          editor.events.$on(editor.shared.$qi_helper, 'mousedown', function (e) {
            e.preventDefault();
          }, true);
        }

        $helper = editor.shared.$qi_helper;
        editor.$box.append($helper); // Show the quick insert helper.

        setTimeout(function () {
          $helper.css('top', parseFloat($quick_insert.css('top')));
          $helper.css('left', parseFloat($quick_insert.css('left')) + $quick_insert.outerWidth());
          $helper.find('a').addClass('fr-size-1');
          $quick_insert.addClass('fr-on');
        }, 10);
      }
    }
    /*
     * Hides the quick insert helper and places the cursor.
     */


    function _hideHelper() {
      var $helper = editor.$box.find('.fr-qi-helper');
      var transition_delay = 25; //transition delay on fade in was set 0.025s

      if ($helper.length) {
        (function () {
          //set transition effect for quick insert link items on hide starting from last child
          var childItems = $helper.find('a'); //get all the buttons from quick insert menu

          var index = 0; //hide the quick insert buttons starting from lefmost button with increase in delay to the righmost button

          for (; index < childItems.length; index++) {
            (function (index) {
              setTimeout(function () {
                $helper.children().eq(childItems.length - 1 - index).removeClass('fr-size-1'); //removing class to hide the button
              }, transition_delay * index); //set the increasing transition delay
            })(index);
          } //remove on button and set back add button


          setTimeout(function () {
            $helper.css('left', -9999);
            if ($quick_insert && !$quick_insert.hasClass('fr-hidden')) $quick_insert.removeClass('fr-on'); //show Add button
          }, transition_delay * index); //set the transition delay for Add button
        })();
      }
    }
    /*
     * Initialize the quick insert.
     */


    function _initquickInsert() {
      if (!editor.shared.$quick_insert) {
        // Append quick insert HTML to editor wrapper.
        editor.shared.$quick_insert = $(document.createElement('div')).attr('class', 'fr-quick-insert').html("<a class=\"fr-floating-btn\" role=\"button\" tabIndex=\"-1\" title=\"".concat(editor.language.translate('Quick Insert'), "\">").concat(editor.icon.create('quickInsert'), "</a>")); //'<div class="fr-quick-insert"><a class="fr-floating-btn" role="button" tabIndex="-1" title="' + editor.language.translate('Quick Insert') + '">' + editor.icon.create('quickInsert') + '</a></div>')
      }

      $quick_insert = editor.shared.$quick_insert;
      // Quick Insert tooltip.
      editor.tooltip.bind(editor.$box, '.fr-quick-insert > a.fr-floating-btn'); // Editor destroy.

      editor.events.on('destroy', function () {
        $('body').first().append($quick_insert.removeClass('fr-on'));

        if ($helper) {
          _hideHelper();

          $('body').first().append($helper.css('left', -9999).css('top', -9999));
        }
      }, true);
      editor.events.on('shared.destroy', function () {
        $quick_insert.html('').removeData().remove();
        $quick_insert = null;

        if ($helper) {
          $helper.html('').removeData().remove();
          $helper = null;
        }
      }, true); // Hide before a command is executed.

      editor.events.on('commands.before', hide); // Check if the quick insert should be shown after a command has been executed.

      editor.events.on('commands.after', function () {
        if (!editor.popups.areVisible()) {
          _checkTag();
        }
      }); // User clicks on the quick insert.

      editor.events.bindClick(editor.$box, '.fr-quick-insert > a', _showQIHelper); // User clicks on a button from the quick insert helper.

      editor.events.bindClick(editor.$box, '.fr-qi-helper > a.fr-btn', function (e) {
        var cmd = $(e.currentTarget).data('cmd'); // Trigger commands.before.

        if (editor.events.trigger('quickInsert.commands.before', [cmd]) === false) {
          return false;
        }

        FE.QUICK_INSERT_BUTTONS[cmd].callback.apply(editor, [e.currentTarget]);

        if (FE.QUICK_INSERT_BUTTONS[cmd].undo) {
          editor.undo.saveStep();
        } // Trigger commands.after.


        editor.events.trigger('quickInsert.commands.after', [cmd]);
        editor.quickInsert.hide();
      }); // Scroll in editor wrapper. Quick insert buttons should scroll along

      editor.events.$on(editor.$wp, 'scroll', _repositionQIButton); // Re-position the quick insert button when more toolbar is expanded completely

      editor.events.$on(editor.$tb, 'transitionend', '.fr-more-toolbar', _repositionQIButton);
    }
    /**
     * Reposition the quick insert button
     */


    function _repositionQIButton() {
      if ($quick_insert.hasClass('fr-visible')) {
        _place($quick_insert.data('tag'));
      }
    }
    /*
     * Tear up.
     */


    function _init() {
      if (!editor.$wp || !editor.opts.quickInsertEnabled) return false; // Hide the quick insert if user click on an image.

      editor.popups.onShow('image.edit', hide); // Check tag where cursor is to see if the quick insert needs to be shown.

      editor.events.on('mouseup', _checkTag);

      if (editor.helpers.isMobile()) {
        editor.events.$on($(editor.o_doc), 'selectionchange', _checkTag);
      } // Hide the quick insert when editor loses focus.


      editor.events.on('blur', hide); // Check if the quick insert should be shown after a key was pressed.

      editor.events.on('keyup', _checkTag); // Hide quick insert on keydown.

      editor.events.on('keydown', function () {
        setTimeout(function () {
          _checkTag();
        }, 0);
      });
    }

    return {
      _init: _init,
      hide: hide
    };
  };

})));