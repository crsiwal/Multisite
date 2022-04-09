
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    fontSize: ['8', '9', '10', '11', '12', '14', '18', '24', '30', '36', '48', '60', '72', '96'],
    fontSizeSelection: false,
    fontSizeDefaultSelection: '12',
    fontSizeUnit: 'px'
  });

  FE.PLUGINS.fontSize = function (editor) {
    var $ = editor.$;

    function apply(val) {
      editor.format.applyStyle('font-size', val);
    }

    function refreshOnShow($btn, $dropdown) {
      var val = $(editor.selection.element()).css('font-size');

      if (editor.opts.fontSizeUnit === 'pt') {
        val = "".concat(Math.round(parseFloat(val, 10) * 72 / 96), "pt");
      }

      $dropdown.find('.fr-command.fr-active').removeClass('fr-active').attr('aria-selected', false);
      $dropdown.find(".fr-command[data-param1=\"".concat(val, "\"]")).addClass('fr-active').attr('aria-selected', true);
    }

    function refresh($btn) {
      if (editor.opts.fontSizeSelection) {
        var val = editor.helpers.getPX($(editor.selection.element()).css('font-size'));

        if (editor.opts.fontSizeUnit === 'pt') {
          val = "".concat(Math.round(parseFloat(val, 10) * 72 / 96), "pt");
        }

        $btn.find('> span').text(val);
      }
    }

    return {
      apply: apply,
      refreshOnShow: refreshOnShow,
      refresh: refresh
    };
  }; // Register the font size command.


  FE.RegisterCommand('fontSize', {
    type: 'dropdown',
    title: 'Font Size',
    displaySelection: function displaySelection(editor) {
      return editor.opts.fontSizeSelection;
    },
    displaySelectionWidth: 30,
    defaultSelection: function defaultSelection(editor) {
      return editor.opts.fontSizeDefaultSelection;
    },
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = this.opts.fontSize;

      for (var i = 0; i < options.length; i++) {
        var val = options[i];
        c += "<li role=\"presentation\"><a class=\"fr-command\" tabIndex=\"-1\" role=\"option\" data-cmd=\"fontSize\" data-param1=\"\n      ".concat(val).concat(this.opts.fontSizeUnit, "\" title=\"").concat(val, "\">").concat(val, "</a></li>");
      }

      c += '</ul>';
      return c;
    },
    callback: function callback(cmd, val) {
      this.fontSize.apply(val);
    },
    refresh: function refresh($btn) {
      this.fontSize.refresh($btn);
    },
    refreshOnShow: function refreshOnShow($btn, $dropdown) {
      this.fontSize.refreshOnShow($btn, $dropdown);
    },
    plugin: 'fontSize'
  }); // Add the font size icon.

  FE.DefineIcon('fontSize', {
    NAME: 'text-height',
    SVG_KEY: 'fontSize'
  });

})));
