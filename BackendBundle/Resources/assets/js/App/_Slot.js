'use strict';

/**
 * Define prototype.
 *
 * @type {{}}
 * @private
 */
(function (global) {
    global._Slot = {
        Setup: function (selector) {
            $(selector).each(function () {
                var id = $(this).data('id');
                var $htmlAdminBar = $(this).find('.slot-admin-buttons');
                var $actionButton = $($htmlAdminBar).find('.slot-action-button');

                if ('add-widget' === $actionButton.data('rel')) {
                    $actionButton.off('click').on('click', _Widget.Add);
                }
                if ('drop-widget' === $actionButton.data('rel')) {
                    $actionButton.off('click').on('click', $.fn.dropWidget);
                }

                $($htmlAdminBar).removeClass('beaver-mockup');

                $(this).prepend($htmlAdminBar);
            });
        },
    };
}).call(this, typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : typeof window !== 'undefined' ? window : {});

