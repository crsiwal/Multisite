(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  FE.PLUGINS.align = function (editor) {
    var $ = editor.$;

    function apply(val) {
      var el = editor.selection.element();

      if ($(el).parents('.fr-img-caption').length) {
        $(el).css('text-align', val);
      } else {
        // Wrap.
        editor.selection.save();
        editor.html.wrap(true, true, true, true);
        editor.selection.restore();
        var blocks = editor.selection.blocks();

        for (var i = 0; i < blocks.length; i++) {
          // https://github.com/froala-labs/froala-editor-js-2/issues/674
          $(blocks[i]).css('text-align', val).removeClass('fr-temp-div');
          if ($(blocks[i]).attr('class') === '') $(blocks[i]).removeAttr('class');
          if ($(blocks[i]).attr('style') === '') $(blocks[i]).removeAttr('style');
        }

        editor.selection.save();
        editor.html.unwrap();
        editor.selection.restore();
      }
    }

    function refresh($btn) {
      var blocks = editor.selection.blocks();

      if (blocks.length) {
        var alignment = editor.helpers.getAlignment($(blocks[0]));
        $btn.find('> *').first().replaceWith(editor.icon.create("align-".concat(alignment)));
      }
    }

    function refreshOnShow($btn, $dropdown) {
      var blocks = editor.selection.blocks();

      if (blocks.length) {
        var alignment = editor.helpers.getAlignment($(blocks[0]));
        $dropdown.find("a.fr-command[data-param1=\"".concat(alignment, "\"]")).addClass('fr-active').attr('aria-selected', true);
      }
    }

    function refreshForToolbar($btn) {
      var blocks = editor.selection.blocks();

      if (blocks.length) {
        var alignment = editor.helpers.getAlignment($(blocks[0])); // Capitalize.

        alignment = alignment.charAt(0).toUpperCase() + alignment.slice(1);

        if ("align".concat(alignment) === $btn.attr('data-cmd')) {
          $btn.addClass('fr-active');
        }
      }
    }

    return {
      apply: apply,
      refresh: refresh,
      refreshOnShow: refreshOnShow,
      refreshForToolbar: refreshForToolbar
    };
  };

  FE.DefineIcon('align', {
    NAME: 'align-left',
    SVG_KEY: 'alignLeft'
  });
  FE.DefineIcon('align-left', {
    NAME: 'align-left',
    SVG_KEY: 'alignLeft'
  });
  FE.DefineIcon('align-right', {
    NAME: 'align-right',
    SVG_KEY: 'alignRight'
  });
  FE.DefineIcon('align-center', {
    NAME: 'align-center',
    SVG_KEY: 'alignCenter'
  });
  FE.DefineIcon('align-justify', {
    NAME: 'align-justify',
    SVG_KEY: 'alignJustify'
  });
  FE.RegisterCommand('align', {
    type: 'dropdown',
    title: 'Align',
    options: {
      left: 'Align Left',
      center: 'Align Center',
      right: 'Align Right',
      justify: 'Align Justify'
    },
    html: function html() {
      var c = '<ul class="fr-dropdown-list" role="presentation">';
      var options = FE.COMMANDS.align.options;

      for (var val in options) {
        if (options.hasOwnProperty(val)) {
          c += "<li role=\"presentation\"><a class=\"fr-command fr-title\" tabIndex=\"-1\" role=\"option\" data-cmd=\"align\"data-param1=\"\n        ".concat(val, "\" title=\"").concat(this.language.translate(options[val]), "\">").concat(this.icon.create("align-".concat(val)), "<span class=\"fr-sr-only\">\n        ").concat(this.language.translate(options[val]), "</span></a></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    callback: function callback(cmd, val) {
      this.align.apply(val);
    },
    refresh: function refresh($btn) {
      this.align.refresh($btn);
    },
    refreshOnShow: function refreshOnShow($btn, $dropdown) {
      this.align.refreshOnShow($btn, $dropdown);
    },
    plugin: 'align'
  });
  FE.RegisterCommand('alignLeft', {
    type: 'button',
    icon: 'align-left',
    title: 'Align Left',
    callback: function callback() {
      this.align.apply('left');
    },
    refresh: function refresh($btn) {
      this.align.refreshForToolbar($btn);
    },
    plugin: 'align'
  });
  FE.RegisterCommand('alignRight', {
    type: 'button',
    icon: 'align-right',
    title: 'Align Right',
    callback: function callback() {
      this.align.apply('right');
    },
    refresh: function refresh($btn) {
      this.align.refreshForToolbar($btn);
    },
    plugin: 'align'
  });
  FE.RegisterCommand('alignCenter', {
    type: 'button',
    icon: 'align-center',
    title: 'Align Center',
    callback: function callback() {
      this.align.apply('center');
    },
    refresh: function refresh($btn) {
      this.align.refreshForToolbar($btn);
    },
    plugin: 'align'
  });
  FE.RegisterCommand('alignJustify', {
    type: 'button',
    icon: 'align-justify',
    title: 'Align Justify',
    callback: function callback() {
      this.align.apply('justify');
    },
    refresh: function refresh($btn) {
      this.align.refreshForToolbar($btn);
    },
    plugin: 'align'
  });

})));