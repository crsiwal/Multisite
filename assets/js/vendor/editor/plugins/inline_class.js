(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    inlineClasses: {
      'fr-class-code': 'Code',
      'fr-class-highlighted': 'Highlighted',
      'fr-class-transparency': 'Transparent'
    }
  });

  FE.PLUGINS.inlineClass = function (editor) {
    var $ = editor.$;

    function apply(val) {
      editor.format.toggle('span', {
        'class': val
      });
    }

    function refreshOnShow($btn, $dropdown) {
      $dropdown.find('.fr-command').each(function () {
        var val = $(this).data('param1');
        var active = editor.format.is('span', {
          'class': val
        });
        $(this).toggleClass('fr-active', active).attr('aria-selected', active);
      });
    }

    return {
      apply: apply,
      refreshOnShow: refreshOnShow
    };
  }; // Register the inlineClass size command.


  FE.RegisterCommand('inlineClass', {
    type: 'dropdown',
    title: 'Inline Class',
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = this.opts.inlineClasses;

      for (var val in options) {
        if (options.hasOwnProperty(val)) {
          c += "<li role=\"presentation\"><a class=\"fr-command\" tabIndex=\"-1\" role=\"option\" data-cmd=\"inlineClass\" data-param1=\"".concat(val, "\" title=\"").concat(options[val], "\">").concat(options[val], "</a></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    callback: function callback(cmd, val) {
      this.inlineClass.apply(val);
    },
    refreshOnShow: function refreshOnShow($btn, $dropdown) {
      this.inlineClass.refreshOnShow($btn, $dropdown);
    },
    plugin: 'inlineClass'
  }); // Add the inlineClass icon.

  FE.DefineIcon('inlineClass', {
    NAME: 'tag',
    SVG_KEY: 'inlineClass'
  });

})));