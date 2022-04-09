(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    paragraphStyles: {
      'fr-text-gray': 'Gray',
      'fr-text-bordered': 'Bordered',
      'fr-text-spaced': 'Spaced',
      'fr-text-uppercase': 'Uppercase'
    },
    paragraphMultipleStyles: true
  });

  FE.PLUGINS.paragraphStyle = function (editor) {
    var $ = editor.$;
    /**
     * Apply style.
     */

    function apply(val, paragraphStyles, paragraphMultipleStyles) {
      if (typeof paragraphStyles === 'undefined') paragraphStyles = editor.opts.paragraphStyles;
      if (typeof paragraphMultipleStyles === 'undefined') paragraphMultipleStyles = editor.opts.paragraphMultipleStyles;
      var styles = ''; // Remove multiple styles.

      if (!paragraphMultipleStyles) {
        styles = Object.keys(paragraphStyles);
        styles.splice(styles.indexOf(val), 1);
        styles = styles.join(' ');
      }

      editor.selection.save();
      editor.html.wrap(true, true, true, true);
      editor.selection.restore();
      var blocks = editor.selection.blocks(); // Save selection to restore it later.

      editor.selection.save();
      var hasClass = $(blocks[0]).hasClass(val);

      for (var i = 0; i < blocks.length; i++) {
        $(blocks[i]).removeClass(styles).toggleClass(val, !hasClass);
        if ($(blocks[i]).hasClass('fr-temp-div')) $(blocks[i]).removeClass('fr-temp-div');
        if ($(blocks[i]).attr('class') === '') $(blocks[i]).removeAttr('class');
      } // Unwrap temp divs.


      editor.html.unwrap(); // Restore selection.

      editor.selection.restore();
    }

    function refreshOnShow($btn, $dropdown) {
      var blocks = editor.selection.blocks();

      if (blocks.length) {
        var $blk = $(blocks[0]);
        $dropdown.find('.fr-command').each(function () {
          var cls = $(this).data('param1');
          var active = $blk.hasClass(cls);
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


  FE.RegisterCommand('paragraphStyle', {
    type: 'dropdown',
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = this.opts.paragraphStyles;

      for (var val in options) {
        if (options.hasOwnProperty(val)) {
          c += "<li role=\"presentation\"><a class=\"fr-command ".concat(val, "\" tabIndex=\"-1\" role=\"option\" data-cmd=\"paragraphStyle\" data-param1=\"").concat(val, "\" title=\"").concat(this.language.translate(options[val]), "\">").concat(this.language.translate(options[val]), "</a></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    title: 'Paragraph Style',
    callback: function callback(cmd, val) {
      this.paragraphStyle.apply(val);
    },
    refreshOnShow: function refreshOnShow($btn, $dropdown) {
      this.paragraphStyle.refreshOnShow($btn, $dropdown);
    },
    plugin: 'paragraphStyle'
  }); // Add the font size icon.

  FE.DefineIcon('paragraphStyle', {
    NAME: 'magic',
    SVG_KEY: 'paragraphStyle'
  });

})));