(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('froala-editor')) :
  typeof define === 'function' && define.amd ? define(['froala-editor'], factory) :
  (factory(global.FroalaEditor));
}(this, (function (FE) { 'use strict';

  FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

  Object.assign(FE.DEFAULTS, {
    html2pdf: window.html2pdf
  });

  FE.PLUGINS.print = function (editor) {
    function _prepare(callback) {
      // Get editor content for printing.
      var contents = editor.html.get(); // Get or create the iframe for printing.

      var print_iframe = null;

      if (editor.shared.print_iframe) {
        print_iframe = editor.shared.print_iframe;
      } else {
        print_iframe = document.createElement('iframe');
        print_iframe.name = 'fr-print';
        print_iframe.style.position = 'fixed';
        print_iframe.style.top = '0';
        print_iframe.style.left = '-9999px';
        print_iframe.style.height = '100%';
        print_iframe.style.width = '0';
        print_iframe.style.overflow = 'hidden';
        print_iframe.style['z-index'] = '2147483647';
        print_iframe.style.tabIndex = '-1'; // Remove editor on shared destroy.

        editor.events.on('shared.destroy', function () {
          print_iframe.remove();
        });
        editor.shared.print_iframe = print_iframe;
      }

      try {
        document.body.removeChild(print_iframe);
      } catch (ex) {}

      document.body.appendChild(print_iframe); // Iframe ready.

      var listener = function listener() {
        callback();
        print_iframe.removeEventListener('load', listener);
      };

      print_iframe.addEventListener('load', listener); // Build printing document.

      var _print_iframe = print_iframe,
          frame_doc = _print_iframe.contentWindow;
      frame_doc.document.open();
      frame_doc.document.write('<!DOCTYPE html><html ' + (editor.opts.documentReady ? 'style="margin: 0; padding: 0;"' : '') + '><head><title>' + document.title + '</title>'); // Add styles.

      Array.prototype.forEach.call(document.querySelectorAll('style'), function (style_el) {
        style_el = style_el.cloneNode(true);
        frame_doc.document.write(style_el.outerHTML);
      }); // Add css links.

      var style_elements = document.querySelectorAll('link[rel=stylesheet]');
      Array.prototype.forEach.call(style_elements, function (link_el) {
        var new_link_el = document.createElement('link');
        new_link_el.rel = link_el.rel;
        new_link_el.href = link_el.href;
        new_link_el.media = 'print';
        new_link_el.type = 'text/css';
        new_link_el.media = 'all';
        frame_doc.document.write(new_link_el.outerHTML);
      });
      frame_doc.document.write('</head><body style="height:auto;text-align: ' + (editor.opts.direction == 'rtl' ? 'right' : 'left') + '; direction: ' + editor.opts.direction + '; ' + (editor.opts.documentReady ? ' padding: 2cm; width: 17cm; margin: 0;' : '') + '"><div class="fr-view">'); // Add editor contents.

      frame_doc.document.write(contents);
      frame_doc.document.write('</div></body></html>');
      frame_doc.document.close();
    }

    function run() {
      _prepare(function () {
        setTimeout(function () {
          // Focus iframe window.
          editor.events.disableBlur();
          window.frames['fr-print'].focus(); // Open printing window.

          window.frames['fr-print'].print(); // Refocus editor's window.

          editor.$win.get(0).focus(); // Focus editor.

          editor.events.disableBlur();
          editor.events.focus();
        }, 0);
      });
    }

    function toPDF() {
      if (editor.opts.html2pdf) {
        editor.$el.css('text-align', 'left');
        editor.opts.html2pdf().set({
          margin: [10, 20],
          html2canvas: {
            useCORS: true
          }
        }).from(editor.el).save();
        setTimeout(function () {
          editor.$el.css('text-align', '');
        }, 100);
      }
    }

    return {
      run: run,
      toPDF: toPDF
    };
  };

  FE.DefineIcon('print', {
    NAME: 'print',
    SVG_KEY: 'print'
  });
  FE.RegisterCommand('print', {
    title: 'Print',
    undo: false,
    focus: false,
    plugin: 'print',
    callback: function callback() {
      this.print.run();
    }
  });
  FE.DefineIcon('getPDF', {
    NAME: 'file-pdf-o',
    FA5NAME: 'file-pdf',
    SVG_KEY: 'pdfExport'
  });
  FE.RegisterCommand('getPDF', {
    title: 'Download PDF',
    type: 'button',
    focus: false,
    undo: false,
    callback: function callback() {
      this.print.toPDF();
    }
  });

})));