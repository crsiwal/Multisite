
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  FE.PLUGINS.fullscreen = function (editor) {
    var $ = editor.$;
    var old_scroll;
    /**
     * Check if fullscreen mode is active.
     */

    var isActive = function isActive() {
      return editor.$box.hasClass('fr-fullscreen');
    };
    /**
     * Turn fullscreen on.
     */


    var height;
    var max_height;
    var z_index;

    function _on() {
      var _editor$opts, _editor$opts2, _editor$opts3;

      if (editor.helpers.isIOS() && editor.core.hasFocus()) {
        editor.$el.blur();
        setTimeout(toggle, 250);
        return false;
      }

      old_scroll = editor.helpers.scrollTop();
      editor.$box.toggleClass('fr-fullscreen');
      $('body').first().toggleClass('fr-fullscreen');

      if (editor.helpers.isMobile()) {
        editor.$tb.data('parent', editor.$tb.parent());
        editor.$box.prepend(editor.$tb);

        if (editor.$tb.data('sticky-dummy')) {
          editor.$tb.after(editor.$tb.data('sticky-dummy'));
        }
      }

      (_editor$opts = editor.opts, height = _editor$opts.height, _editor$opts)((_editor$opts2 = editor.opts, max_height = _editor$opts2.heightMax, _editor$opts2))((_editor$opts3 = editor.opts, z_index = _editor$opts3.z_index, _editor$opts3)); // Take second toolbar into consideration when in fullscreen mode

      editor.opts.height = editor.o_win.innerHeight - (editor.opts.toolbarInline ? 0 : editor.$tb.outerHeight() + (editor.$second_tb ? editor.$second_tb.outerHeight() : 0));
      editor.opts.zIndex = 2147483641;
      editor.opts.heightMax = null;
      editor.size.refresh();
      if (editor.opts.toolbarInline) editor.toolbar.showInline();
      var $parent_node = editor.$box.parent();

      while (!$parent_node.first().is('body')) {
        $parent_node.addClass('fr-fullscreen-wrapper');
        $parent_node = $parent_node.parent();
      }

      if (editor.opts.toolbarContainer) {
        editor.$box.prepend(editor.$tb);
      }

      editor.events.trigger('charCounter.update');
      editor.events.trigger('codeView.update');
      editor.$win.trigger('scroll');
    }
    /**
     * Turn fullscreen off.
     */


    function _off() {
      if (editor.helpers.isIOS() && editor.core.hasFocus()) {
        editor.$el.blur();
        setTimeout(toggle, 250);
        return false;
      }

      editor.$box.toggleClass('fr-fullscreen');
      $('body').first().toggleClass('fr-fullscreen');

      if (editor.$tb.data('parent')) {
        editor.$tb.data('parent').prepend(editor.$tb);
      }

      if (editor.$tb.data('sticky-dummy')) {
        editor.$tb.after(editor.$tb.data('sticky-dummy'));
      }

      editor.opts.height = height;
      editor.opts.heightMax = max_height;
      editor.opts.zIndex = z_index;
      editor.size.refresh();
      $(editor.o_win).scrollTop(old_scroll);
      if (editor.opts.toolbarInline) editor.toolbar.showInline();
      editor.events.trigger('charCounter.update');

      if (editor.opts.toolbarSticky) {
        if (editor.opts.toolbarStickyOffset) {
          if (editor.opts.toolbarBottom) {
            editor.$tb.css('bottom', editor.opts.toolbarStickyOffset).data('bottom', editor.opts.toolbarStickyOffset);
          } else {
            editor.$tb.css('top', editor.opts.toolbarStickyOffset).data('top', editor.opts.toolbarStickyOffset);
          }
        }
      }

      var $parent_node = editor.$box.parent();

      while (!$parent_node.first().is('body')) {
        $parent_node.removeClass('fr-fullscreen-wrapper');
        $parent_node = $parent_node.parent();
      }

      if (editor.opts.toolbarContainer) {
        $(editor.opts.toolbarContainer).append(editor.$tb);
      }

      $(editor.o_win).trigger('scroll');
      editor.events.trigger('codeView.update');
    }
    /**
     * Exec fullscreen.
     */


    function toggle() {
      if (!isActive()) {
        _on();
      } else {
        _off();
      }

      refresh(editor.$tb.find('.fr-command[data-cmd="fullscreen"]'));
      var moreText = editor.$tb.find('.fr-command[data-cmd="moreText"]');
      var moreParagraph = editor.$tb.find('.fr-command[data-cmd="moreParagraph"]');
      var moreRich = editor.$tb.find('.fr-command[data-cmd="moreRich"]');
      var moreMisc = editor.$tb.find('.fr-command[data-cmd="moreMisc"]'); // Refresh the more button toolbars on fullscreen toggle for repositioning 

      moreText.length && editor.refresh.moreText(moreText);
      moreParagraph.length && editor.refresh.moreParagraph(moreParagraph);
      moreRich.length && editor.refresh.moreRich(moreRich);
      moreMisc.length && editor.refresh.moreMisc(moreMisc);
    }

    function refresh($btn) {
      var active = isActive();
      $btn.toggleClass('fr-active', active).attr('aria-pressed', active);
      $btn.find('> *').not('.fr-sr-only').replaceWith(!active ? editor.icon.create('fullscreen') : editor.icon.create('fullscreenCompress'));
    }

    function _init() {
      if (!editor.$wp) return false;
      editor.events.$on($(editor.o_win), 'resize', function () {
        if (isActive()) {
          _off();

          _on();
        }
      });
      editor.events.on('toolbar.hide', function () {
        if (isActive() && editor.helpers.isMobile()) return false;
      });
      editor.events.on('position.refresh', function () {
        if (editor.helpers.isIOS()) {
          return !isActive();
        }
      });
      editor.events.on('destroy', function () {
        // Exit full screen.
        if (isActive()) {
          _off();
        }
      }, true);
    }

    return {
      _init: _init,
      toggle: toggle,
      refresh: refresh,
      isActive: isActive
    };
  }; // Register the font size command.


  FE.RegisterCommand('fullscreen', {
    title: 'Fullscreen',
    undo: false,
    focus: false,
    accessibilityFocus: true,
    forcedRefresh: true,
    toggle: true,
    callback: function callback() {
      this.fullscreen.toggle();
    },
    refresh: function refresh($btn) {
      this.fullscreen.refresh($btn);
    },
    plugin: 'fullscreen'
  }); // Add the font size icon.

  FE.DefineIcon('fullscreen', {
    NAME: 'expand',
    SVG_KEY: 'fullscreen'
  });
  FE.DefineIcon('fullscreenCompress', {
    NAME: 'compress',
    SVG_KEY: 'exitFullscreen'
  });

})));
