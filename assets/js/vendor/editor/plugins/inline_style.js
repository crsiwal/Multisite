(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    inlineStyles: {
      'Big Red': 'font-size: 20px; color: red;',
      'Small Blue': 'font-size: 14px; color: blue;'
    }
  });

  FE.PLUGINS.inlineStyle = function (editor) {
    function apply(val) {
      // https://github.com/froala-labs/froala-editor-js-2/issues/1934
      var splits = val.split(';');

      for (var i = 0; i < splits.length; i++) {
        var new_split = splits[i].split(':');

        if (splits[i].length && new_split.length == 2) {
          editor.format.applyStyle(new_split[0].trim(), new_split[1].trim());
        }
      }
    }

    return {
      apply: apply
    };
  }; // Register the inline style command.


  FE.RegisterCommand('inlineStyle', {
    type: 'dropdown',
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = this.opts.inlineStyles;

      for (var val in options) {
        if (options.hasOwnProperty(val)) {
          var inlineStyle = options[val] + (options[val].indexOf('display:block;') === -1 ? ' display:block;' : '');
          c += "<li role=\"presentation\"><span style=\"".concat(inlineStyle, "\" role=\"presentation\"><a class=\"fr-command\" tabIndex=\"-1\" role=\"option\" data-cmd=\"inlineStyle\" data-param1=\"").concat(options[val], "\" title=\"").concat(this.language.translate(val), "\">").concat(this.language.translate(val), "</a></span></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    title: 'Inline Style',
    callback: function callback(cmd, val) {
      this.inlineStyle.apply(val);
    },
    plugin: 'inlineStyle'
  }); // Add the font size icon.

  FE.DefineIcon('inlineStyle', {
    NAME: 'paint-brush',
    SVG_KEY: 'inlineStyle'
  });

})));