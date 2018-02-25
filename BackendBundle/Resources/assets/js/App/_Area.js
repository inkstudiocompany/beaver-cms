'use strict';

/**
 * Define prototype.
 *
 * @type {{}}
 * @private
 */
(function (global) {
    global._Area = {
        /**
         * Define HTML for Area Buttons Bar.
         *
         * @returns {string}
         * @constructor
         */
        ButtonBar: function () {
            return '<div class="area-admin-buttons">\n' +
                '        <button title="Add Block" data-rel="add-block">\n' +
                '            <i class="fa fa-plus-circle"></i>\n' +
                '        </button>\n' +
                '    </div>';
        },

        /**
         * Adds Buttons bar for each block.
         *
         * @param selector
         * @constructor
         */
        Setup: function (selector) {
            $(selector).each(function () {
                $(this).find('.area-admin-buttons').remove();

                var area = $(this).attr('id');

                var $bar = $(_Area.ButtonBar()).data('beaver', area).data('page', beaverInfo.page);
                $bar.find('[data-rel="add-block"]').off('click').on('click', _Area.Add);
                $(this).append($bar);
            });
        },

        /**
         * Adds New Block into Area.
         *
         * @param e
         * @constructor
         */
        Add: function () {
            var page = $(this).parents('.area-admin-buttons').data('page');
            var area = $(this).parents('.area-admin-buttons').data('beaver');

            _Modal.Form({
                url         :    Routing.generate('beaver.ajax.blocks.form'),
                data        :   'page=' + page + '&area=' + area,
                callback    : function (data) {
                    var block = $(data);
                    $('.area-admin-buttons[data-area="'+area+'"]').before(block);
                    _Utils.setBars();
                    _Modal.Close();
                }
            });
        }
    };
}).call(this, typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : typeof window !== 'undefined' ? window : {});
