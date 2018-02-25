'use strict';

/**
 * Define prototype.
 *
 * @type {{}}
 * @private
 */
(function (global) {
    global._Widget = {
        Add: function () {
            var block = false; let slot = 0; let size = 0;

            var $slotButtonBar   = $(this).parents('[data-beaver="slot"]');
            var $blockHtml       = $(this).parents('[data-beaver="block"]');

            if ($slotButtonBar.length) {
                slot    = $slotButtonBar.data('id');
                size    = $slotButtonBar.data('size');
            }

            if ($blockHtml.length) {
                var $block = $blockHtml.data('id');
            }

            _Modal.Form({
                source      : Routing.generate('beaver.ajax.widgets.form'),
                data        : 'block=' + block + '&size=' + size + '&slot=' + slot,
                callback: function (data) {
                    _Modal.Close();
                    _Modal.Success({
                        text: 'El widget se agregó correctamente!',
                        onClose: function () {
                            _Block.Refresh($block);
                        }
                    });
                }
            });
        }
    };
}).call(this, typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : typeof window !== 'undefined' ? window : {});

