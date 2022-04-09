(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  FE.PLUGINS.quote = function (editor) {
    var $ = editor.$;

    function _deepestParent(node) {
      while (node.parentNode && node.parentNode != editor.el) {
        node = node.parentNode;
      }

      return node;
    }

    function _increase() {
      // Get blocks.
      var blocks = editor.selection.blocks();
      var i; // Normalize blocks.

      for (i = 0; i < blocks.length; i++) {
        blocks[i] = _deepestParent(blocks[i]);
      } // Save selection to restore it later.


      editor.selection.save();
      var $quote = $(document.createElement('blockquote'));
      $quote.insertBefore(blocks[0]);

      for (i = 0; i < blocks.length; i++) {
        $quote.append(blocks[i]);
      } // Unwrap temp divs.


      editor.html.unwrap();
      editor.selection.restore();
    }

    function _decrease() {
      // Get blocks.
      var blocks = editor.selection.blocks();
      var i;

      for (i = 0; i < blocks.length; i++) {
        if (blocks[i].tagName != 'BLOCKQUOTE') {
          blocks[i] = $(blocks[i]).parentsUntil(editor.$el, 'BLOCKQUOTE').get(0);
        }
      }

      editor.selection.save();

      for (i = 0; i < blocks.length; i++) {
        if (blocks[i]) {
          $(blocks[i]).replaceWith(blocks[i].innerHTML);
        }
      } // Unwrap temp divs.


      editor.html.unwrap();
      editor.selection.restore();
    }

    function apply(val) {
      // Wrap.
      editor.selection.save();
      editor.html.wrap(true, true, true, true);
      editor.selection.restore();

      if (val == 'increase') {
        _increase();
      } else if (val == 'decrease') {
        _decrease();
      }
    }

    return {
      apply: apply
    };
  }; // Register the quote command.


  FE.RegisterShortcut(FE.KEYCODE.SINGLE_QUOTE, 'quote', 'increase', '\'');
  FE.RegisterShortcut(FE.KEYCODE.SINGLE_QUOTE, 'quote', 'decrease', '\'', true);
  FE.RegisterCommand('quote', {
    title: 'Quote',
    type: 'dropdown',
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = {
        increase: 'Increase',
        decrease: 'Decrease'
      };

      for (var val in options) {
        if (options.hasOwnProperty(val)) {
          var shortcut = this.shortcuts.get("quote.".concat(val));
          c += "<li role=\"presentation\"><a class=\"fr-command fr-active ".concat(val, "\" tabIndex=\"-1\" role=\"option\" data-cmd=\"quote\" data-param1=\"").concat(val, "\" title=\"").concat(options[val], "\">").concat(this.language.translate(options[val])).concat(shortcut ? "<span class=\"fr-shortcut\">".concat(shortcut, "</span>") : '', "</a></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    callback: function callback(cmd, val) {
      this.quote.apply(val);
    },
    plugin: 'quote'
  }); // Add the quote icon.

  FE.DefineIcon('quote', {
    NAME: 'quote-left',
    SVG_KEY: 'blockquote'
  });

})));