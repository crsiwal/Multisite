
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.POPUP_TEMPLATES, {
    'forms.edit': '[_BUTTONS_]',
    'forms.update': '[_BUTTONS_][_TEXT_LAYER_]'
  }); // Extend defaults.

  Object.assign(FE.DEFAULTS, {
    formEditButtons: ['inputStyle', 'inputEdit'],
    formStyles: {
      'fr-rounded': 'Rounded',
      'fr-large': 'Large'
    },
    formMultipleStyles: true,
    formUpdateButtons: ['inputBack', '|']
  });

  FE.PLUGINS.forms = function (editor) {
    var $ = editor.$;
    var current_input;
    /**
     * Input mousedown.
     */

    function _inputMouseDown(e) {
      editor.selection.clear();
      $(this).data('mousedown', true);
    }
    /**
     * Mouseup on the input.
     */


    function _inputMouseUp(e) {
      // Mousedown was made.
      if ($(this).data('mousedown')) {
        e.stopPropagation();
        $(this).removeData('mousedown');
        current_input = this;
        showEditPopup(this);
      }

      e.preventDefault();
    }
    /**
     * Cancel if mousedown was made on any input.
     */


    function _cancelSelection() {
      editor.$el.find('input, textarea, button').removeData('mousedown');
    }
    /**
     * Touch move.
     */


    function _inputTouchMove() {
      $(this).removeData('mousedown');
    }
    /**
     * Assign the input events.
     */


    function _bindEvents() {
      editor.events.$on(editor.$el, editor._mousedown, 'input, textarea, button', _inputMouseDown);
      editor.events.$on(editor.$el, editor._mouseup, 'input, textarea, button', _inputMouseUp);
      editor.events.$on(editor.$el, 'touchmove', 'input, textarea, button', _inputTouchMove);
      editor.events.$on(editor.$el, editor._mouseup, _cancelSelection);
      editor.events.$on(editor.$win, editor._mouseup, _cancelSelection);

      _initUpdatePopup(true);
    }
    /**
     * Get the current button.
     */


    function getInput() {
      if (current_input) return current_input;
      return null;
    }
    /**
     * Init the edit button popup.
     */


    function _initEditPopup() {
      // Button edit buttons.
      var buttons = '';

      if (editor.opts.formEditButtons.length > 0) {
        buttons = "<div class=\"fr-buttons\">".concat(editor.button.buildList(editor.opts.formEditButtons), "</div>");
      }

      var template = {
        buttons: buttons // Set the template in the popup.

      };
      var $popup = editor.popups.create('forms.edit', template);

      if (editor.$wp) {
        editor.events.$on(editor.$wp, 'scroll.link-edit', function () {
          if (getInput() && editor.popups.isVisible('forms.edit')) {
            showEditPopup(getInput());
          }
        });
      }

      return $popup;
    }
    /**
     * Show the edit button popup.
     */


    function showEditPopup(input) {
      var hideEditPopups = ['checkbox', 'radio'];

      if (hideEditPopups.indexOf(input.type) != -1) {
        return;
      }

      var $popup = editor.popups.get('forms.edit');
      if (!$popup) $popup = _initEditPopup();
      current_input = input;
      var $input = $(input);
      editor.popups.refresh('forms.edit');
      editor.popups.setContainer('forms.edit', editor.$sc);
      var left = $input.offset().left + $input.outerWidth() / 2;
      var top = $input.offset().top + $input.outerHeight();
      editor.popups.show('forms.edit', left, top, $input.outerHeight());
    }
    /**
     * Refresh update button popup callback.
     */


    function _refreshUpdateCallback() {
      var $popup = editor.popups.get('forms.update');
      var input = getInput();

      if (input) {
        var $input = $(input);

        if ($input.is('button')) {
          $popup.find('input[type="text"][name="text"]').val($input.text());
        } else if ($input.is('input[type=button]') || $input.is('input[type=submit]') || $input.is('input[type=reset]')) {
          $popup.find('input[type="text"][name="text"]').val($input.val());
        } else {
          $popup.find('input[type="text"][name="text"]').val($input.attr('placeholder'));
        }
      }

      $popup.find('input[type="text"][name="text"]').trigger('change');
    }
    /**
     * Hide update button popup callback.
     */


    function _hideUpdateCallback() {
      current_input = null;
    }
    /**
     * Init update button popup.
     */


    function _initUpdatePopup(delayed) {
      if (delayed) {
        editor.popups.onRefresh('forms.update', _refreshUpdateCallback);
        editor.popups.onHide('forms.update', _hideUpdateCallback);
        return true;
      } // Button update buttons.


      var buttons = '';

      if (editor.opts.formUpdateButtons.length >= 1) {
        buttons = "<div class=\"fr-buttons\">".concat(editor.button.buildList(editor.opts.formUpdateButtons), "</div>");
      }

      var text_layer = '';
      var tab_idx = 0;
      text_layer = "<div class=\"fr-forms-text-layer fr-layer fr-active\"> \n    <div class=\"fr-input-line\"><input name=\"text\" type=\"text\" placeholder=\"Text\" tabIndex=\" ".concat(++tab_idx, " \"></div>\n    <div class=\"fr-action-buttons\"><button class=\"fr-command fr-submit\" data-cmd=\"updateInput\" href=\"#\" tabIndex=\"").concat(++tab_idx, "\" type=\"button\">").concat(editor.language.translate('Update'), "</button></div></div>");
      var template = {
        buttons: buttons,
        text_layer: text_layer // Set the template in the popup.

      };
      var $popup = editor.popups.create('forms.update', template);
      return $popup;
    }
    /**
     * Show the button update popup.
     */


    function showUpdatePopup() {
      var input = getInput();

      if (input) {
        var $input = $(input);
        var $popup = editor.popups.get('forms.update');
        if (!$popup) $popup = _initUpdatePopup();

        if (!editor.popups.isVisible('forms.update')) {
          editor.popups.refresh('forms.update');
        }

        editor.popups.setContainer('forms.update', editor.$sc);
        var left = $input.offset().left + $input.outerWidth() / 2;
        var top = $input.offset().top + $input.outerHeight();
        editor.popups.show('forms.update', left, top, $input.outerHeight());
      }
    }
    /**
     * Apply specific style.
     */


    function applyStyle(val, formStyles, multipleStyles) {
      if (typeof formStyles === 'undefined') formStyles = editor.opts.formStyles;
      if (typeof multipleStyles === 'undefined') multipleStyles = editor.opts.formMultipleStyles;
      var input = getInput();
      if (!input) return false; // Remove multiple styles.

      if (!multipleStyles) {
        var styles = Object.keys(formStyles);
        styles.splice(styles.indexOf(val), 1);
        $(input).removeClass(styles.join(' '));
      }

      $(input).toggleClass(val);
    }
    /**
     * Back button in update button popup.
     */


    function back() {
      editor.events.disableBlur();
      editor.selection.restore();
      editor.events.enableBlur();
      var input = getInput();

      if (input && editor.$wp) {
        if (input.tagName === 'BUTTON') editor.selection.restore();
        showEditPopup(input);
      }
    }
    /**
     * Hit the update button in the input popup.
     */


    function updateInput() {
      var $popup = editor.popups.get('forms.update');
      var input = getInput();

      if (input) {
        var $input = $(input);
        var inputBtns = ['button', 'submit', 'reset'];
        var val = $popup.find('input[type="text"][name="text"]').val() || ''; // https://github.com/froala-labs/froala-editor-js-2/issues/1988
        // update the text content if input is a button

        if ($input.is('button')) {
          if (val.length) {
            $input.text(val);
          } else {
            // If tag is button, Update empty text.
            $input.text("\u200B");
          }
        } else if (inputBtns.indexOf(input.type) != -1) {
          $input.attr('value', val);
        } // update the place holder if input type is text
        else {
            $input.attr('placeholder', val);
          }

        editor.popups.hide('forms.update');
        showEditPopup(input);
      }
    }
    /**
     * Initialize.
     */


    function _init() {
      // Bind input events.
      _bindEvents(); // Prevent form submit.


      editor.events.$on(editor.$el, 'submit', 'form', function (e) {
        e.preventDefault();
        return false;
      });
    }

    return {
      _init: _init,
      updateInput: updateInput,
      getInput: getInput,
      applyStyle: applyStyle,
      showUpdatePopup: showUpdatePopup,
      showEditPopup: showEditPopup,
      back: back
    };
  }; // Register command to update input.


  FE.RegisterCommand('updateInput', {
    undo: false,
    focus: false,
    title: 'Update',
    callback: function callback() {
      this.forms.updateInput();
    }
  }); // Link styles.

  FE.DefineIcon('inputStyle', {
    NAME: 'magic',
    SVG_KEY: 'inlineStyle'
  });
  FE.RegisterCommand('inputStyle', {
    title: 'Style',
    type: 'dropdown',
    html: function html() {
      var c = '<ul class="fr-dropdown-list">';
      var options = this.opts.formStyles;

      for (var cls in options) {
        if (options.hasOwnProperty(cls)) {
          c += "<li><a class=\"fr-command\" tabIndex=\"-1\" data-cmd=\"inputStyle\" data-param1=\"".concat(cls, "\">").concat(this.language.translate(options[cls]), "</a></li>");
        }
      }

      c += '</ul>';
      return c;
    },
    callback: function callback(cmd, val) {
      var input = this.forms.getInput();

      if (input) {
        this.forms.applyStyle(val);
        this.forms.showEditPopup(input);
      }
    },
    refreshOnShow: function refreshOnShow($btn, $dropdown) {
      var $ = this.$;
      var input = this.forms.getInput();

      if (input) {
        var $input = $(input);
        $dropdown.find('.fr-command').each(function () {
          var cls = $(this).data('param1');
          $(this).toggleClass('fr-active', $input.hasClass(cls));
        });
      }
    }
  });
  FE.DefineIcon('inputEdit', {
    NAME: 'edit',
    SVG_KEY: 'edit'
  });
  FE.RegisterCommand('inputEdit', {
    title: 'Edit Button',
    undo: false,
    refreshAfterCallback: false,
    callback: function callback() {
      this.forms.showUpdatePopup();
    }
  });
  FE.DefineIcon('inputBack', {
    NAME: 'arrow-left',
    SVG_KEY: 'back'
  });
  FE.RegisterCommand('inputBack', {
    title: 'Back',
    undo: false,
    focus: false,
    back: true,
    refreshAfterCallback: false,
    callback: function callback() {
      this.forms.back();
    }
  }); // Register command to update button.

  FE.RegisterCommand('updateInput', {
    undo: false,
    focus: false,
    title: 'Update',
    callback: function callback() {
      this.forms.updateInput();
    }
  });

})));
