
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    fontFamily: {
      'Arial,Helvetica,sans-serif': 'Arial',
      'Georgia,serif': 'Georgia',
      'Impact,Charcoal,sans-serif': 'Impact',
      'Tahoma,Geneva,sans-serif': 'Tahoma',
      'Times New Roman,Times,serif,-webkit-standard': 'Times New Roman',
      'Verdana,Geneva,sans-serif': 'Verdana'
    },
    fontFamilySelection: false,
    fontFamilyDefaultSelection: 'Font Family'
  });

  FE.PLUGINS.fontFamily = function (editor) {
    var $ = editor.$;

    function apply(val) {
      editor.format.applyStyle('font-family', val);
    }

    function refreshOnShow($btn, $dropdown) {
      $dropdown.find('.fr-command.fr-active').removeClass('fr-active').attr('aria-selected', false);
      $dropdown.find(".fr-command[data-param1=\"".concat(_getSelection(), "\"]")).addClass('fr-active').attr('aria-selected', true);
    }

    function _getArray(val) {
      var font_array = val.replace(/(sans-serif|serif|monospace|cursive|fantasy)/gi, '').replace(/"|'| /g, '').split(',');
      return $(this).grep(font_array, function (txt) {
        return txt.length > 0;
      });
    }
    /**
     * Return first match position.
     */


    function _matches(array1, array2) {
      for (var i = 0; i < array1.length; i++) {
        for (var j = 0; j < array2.length; j++) {
          if (array1[i].toLowerCase() === array2[j].toLowerCase()) {
            return [i, j];
          }
        }
      }

      return null;
    }

    function _getSelection() {
      var val = $(editor.selection.element()).css('font-family');

      var font_array = _getArray(val);

      var font_matches = [];

      for (var key in editor.opts.fontFamily) {
        if (editor.opts.fontFamily.hasOwnProperty(key)) {
          var c_font_array = _getArray(key);

          var match = _matches(font_array, c_font_array);

          if (match) {
            font_matches.push([key, match]);
          }
        }
      }

      if (font_matches.length === 0) return null; // Sort matches by their position.
      // Times,Arial should be detected as being Times, not Arial.

      font_matches.sort(function (a, b) {
        var f_diff = a[1][0] - b[1][0];

        if (f_diff === 0) {
          return a[1][1] - b[1][1];
        } else {
          return f_diff;
        }
      });
      return font_matches[0][0];
    }

    function refresh($btn) {
      if (editor.opts.fontFamilySelection) {
        var val = $(editor.selection.element()).css('font-family').replace(/(sans-serif|serif|monospace|cursive|fantasy)/gi, '').replace(/"|'|/g, '').split(',');
        $btn.find('> span').text(editor.opts.fontFamily[_getSelection()] || val[0] || editor.language.translate(editor.opts.fontFamilyDefaultSelection));
      }
    }

    return {
      apply: apply,
      refreshOnShow: refreshOnShow,
      refresh: refresh
    };
  }; // Register the font size command.


  FE.RegisterCommand('fontFamily', {
    type: 'dropdown',
    displaySelection: function displaySelection(editor) {
      return editor.opts.fontFamilySelection;
    },
    defaultSelection: function defaultSelection(editor) {
      return editor.opts.fontFamilyDefaultSelection;
    },
    displaySelectionWidth: 120,
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = this.opts.fontFamily;

      for (var val in options) {
        if (options.hasOwnProperty(val)) {
          c += "<li role=\"presentation\"><a class=\"fr-command\" tabIndex=\"-1\" role=\"option\" data-cmd=\"fontFamily\" data-param1=\"\n        ".concat(val, "\" style=\"font-family: ").concat(val, "\" title=\"").concat(options[val], "\">").concat(options[val], "</a></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    title: 'Font Family',
    callback: function callback(cmd, val) {
      this.fontFamily.apply(val);
    },
    refresh: function refresh($btn) {
      this.fontFamily.refresh($btn);
    },
    refreshOnShow: function refreshOnShow($btn, $dropdown) {
      this.fontFamily.refreshOnShow($btn, $dropdown);
    },
    plugin: 'fontFamily'
  }); // Add the font size icon.

  FE.DefineIcon('fontFamily', {
    NAME: 'font',
    SVG_KEY: 'fontFamily'
  });

})));
