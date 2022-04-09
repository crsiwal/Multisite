(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  FE.URLRegEx = "(^| |\\u00A0)(".concat(FE.LinkRegEx, "|([a-z0-9+-_.]{1,}@[a-z0-9+-_.]{1,}\\.[a-z0-9+-_]{1,}))$");

  FE.PLUGINS.url = function (editor) {
    var $ = editor.$;
    var rel = null;
    /*
     * Transform string into a hyperlink.
     */

    function _linkReplaceHandler(match, p1, p2) {
      var dots = '';

      while (p2.length && p2[p2.length - 1] == '.') {
        dots += '.';
        p2 = p2.substring(0, p2.length - 1);
      }

      var link = p2; // Convert email.

      if (editor.opts.linkConvertEmailAddress) {
        if (editor.helpers.isEmail(link) && !/^mailto:.*/i.test(link)) {
          link = "mailto:".concat(link);
        }
      } else if (editor.helpers.isEmail(link)) {
        return p1 + p2;
      }

      if (!/^((http|https|ftp|ftps|mailto|tel|sms|notes|data)\:)/i.test(link)) {
        link = "//".concat(link);
      }

      return (p1 ? p1 : '') + "<a".concat(editor.opts.linkAlwaysBlank ? ' target="_blank"' : '').concat(rel ? " rel=\"".concat(rel, "\"") : '', " data-fr-linked=\"true\" href=\"").concat(link, "\">").concat(p2.replace(/&amp;/g, '&').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'), "</a>").concat(dots);
    }

    var _getRegEx = function _getRegEx() {
      return new RegExp(FE.URLRegEx, 'gi');
    };
    /*
     * Convert link paterns from html into hyperlinks.
     */


    function _convertToLink(html) {
      if (editor.opts.linkAlwaysNoFollow) {
        rel = 'nofollow';
      } // https://github.com/froala/wysiwyg-editor/issues/1576.


      if (editor.opts.linkAlwaysBlank) {
        if (editor.opts.linkNoOpener) {
          if (!rel) rel = 'noopener';else rel += ' noopener';
        }

        if (editor.opts.linkNoReferrer) {
          if (!rel) rel = 'noreferrer';else rel += ' noreferrer';
        }
      }

      return html.replace(_getRegEx(), _linkReplaceHandler);
    }

    function _isA(node) {
      if (!node) return false;
      if (node.tagName === 'A') return true;
      if (node.parentNode && node.parentNode != editor.el) return _isA(node.parentNode);
      return false;
    }

    function _lastPart(text) {
      var splits = text.split(' ');
      return splits[splits.length - 1];
    }

    function _inlineType() {
      var range = editor.selection.ranges(0);
      var node = range.startContainer;
      if (!node || node.nodeType !== Node.TEXT_NODE || range.startOffset !== (node.textContent || '').length) return false;
      if (_isA(node)) return false;

      if (_getRegEx().test(_lastPart(node.textContent))) {
        $(node).before(_convertToLink(node.textContent)); // Get linked link.

        var $link = $(node.parentNode).find('a[data-fr-linked]');
        $link.removeAttr('data-fr-linked');
        node.parentNode.removeChild(node); // Trigger link event.

        editor.events.trigger('url.linked', [$link.get(0)]);
      } else if (node.textContent.split(' ').length <= 2 && node.previousSibling && node.previousSibling.tagName === 'A') {
        var text = node.previousSibling.innerText + node.textContent;

        if (_getRegEx().test(_lastPart(text))) {
          $(node.previousSibling).replaceWith(_convertToLink(text));
          node.parentNode.removeChild(node);
        }
      }
    }
    /*
     * Initialize.
     */


    function _init() {
      // Handle special keys.
      editor.events.on('keypress', function (e) {
        if (editor.selection.isCollapsed() && (e.key == '.' || e.key == ')' || e.key == '(')) {
          _inlineType();
        }
      }, true); // Handle ENTER and SPACE.

      editor.events.on('keydown', function (e) {
        var keycode = e.which;

        if (editor.selection.isCollapsed() && (keycode == FE.KEYCODE.ENTER || keycode == FE.KEYCODE.SPACE)) {
          _inlineType();
        }
      }, true); // Handle pasting.

      editor.events.on('paste.beforeCleanup', function (html) {
        if (editor.helpers.isURL(html)) {
          var rel_attr = null;

          if (editor.opts.linkAlwaysBlank) {
            if (editor.opts.linkNoOpener) {
              if (!rel_attr) rel_attr = 'noopener';else rel_attr += ' noopener';
            }

            if (editor.opts.linkNoReferrer) {
              if (!rel_attr) rel_attr = 'noreferrer';else rel_attr += ' noreferrer';
            }
          }

          return "<a".concat(editor.opts.linkAlwaysBlank ? ' target="_blank"' : '').concat(rel_attr ? " rel=\"".concat(rel_attr, "\"") : '', " href=\"").concat(html, "\" >").concat(html, "</a>");
        }
      });
    }

    return {
      _init: _init
    };
  };

})));