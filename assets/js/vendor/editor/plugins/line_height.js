(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    lineHeights: {
      Default: '',
      Single: '1',
      '1.15': '1.15',
      '1.5': '1.5',
      Double: '2'
    }
  });

  FE.PLUGINS.lineHeight = function (editor) {
    var $ = editor.$;
    /**
     * Apply style.
     */

    function apply(val) {
      editor.selection.save();
      editor.html.wrap(true, true, true, true);
      editor.selection.restore();
      var blocks = editor.selection.blocks();

      if (blocks.length && $(blocks[0]).parent().is('td')) {
        editor.format.applyStyle('line-height', val.toString());
      } // Save selection to restore it later.


      editor.selection.save();

      for (var i = 0; i < blocks.length; i++) {
        $(blocks[i]).css('line-height', val);

        if ($(blocks[i]).attr('style') === '') {
          $(blocks[i]).removeAttr('style');
        }
      } // Unwrap temp divs.


      editor.html.unwrap(); // Restore selection.

      editor.selection.restore();
    }

    function refreshOnShow($btn, $dropdown) {
      var blocks = editor.selection.blocks();

      if (blocks.length) {
        var $blk = $(blocks[0]);
        $dropdown.find('.fr-command').each(function () {
          var lineH = $(this).data('param1');
          var blkStyle = $blk.attr('style');
          var active = (blkStyle || '').indexOf('line-height: ' + lineH + ';') >= 0; // Check if style contains line-height property, when text is pasted from other sources
          // If not make `default` text selected

          if (blkStyle) {
            var lineStyle = blkStyle.substring(blkStyle.indexOf('line-height'));
            var value = lineStyle.substr(0, lineStyle.indexOf(';')); // get value of line-height

            var lineHeight = value && value.split(':')[1];

            if ((!lineHeight || !lineHeight.length) && $blk.text() === 'Default') {
              active = true;
            }
          } // keep `default` text selected always


          if ((!blkStyle || blkStyle.indexOf('line-height') === -1) && lineH === '') {
            active = true;
          }

          $(this).toggleClass('fr-active', active).attr('aria-selected', active);
        });
      }
    }

    var _init = function _init() {};

    return {
      _init: _init,
      apply: apply,
      refreshOnShow: refreshOnShow
    };
  }; // Register the font size command.


  FE.RegisterCommand('lineHeight', {
    type: 'dropdown',
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = this.opts.lineHeights;

      for (var val in options) {
        if (options.hasOwnProperty(val)) {
          c += "<li role=\"presentation\"><a class=\"fr-command ".concat(val, "\" tabIndex=\"-1\" role=\"option\" data-cmd=\"lineHeight\" data-param1=\"").concat(options[val], "\" title=\"").concat(this.language.translate(val), "\">").concat(this.language.translate(val), "</a></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    title: 'Line Height',
    callback: function callback(cmd, val) {
      this.lineHeight.apply(val);
    },
    refreshOnShow: function refreshOnShow($btn, $dropdown) {
      this.lineHeight.refreshOnShow($btn, $dropdown);
    },
    plugin: 'lineHeight'
  }); // Add the font size icon.

  FE.DefineIcon('lineHeight', {
    NAME: 'arrows-v',
    FA5NAME: 'arrows-alt-v',
    SVG_KEY: 'lineHeight'
  });

})));