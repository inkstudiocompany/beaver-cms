'use strict';

/**
 * Define prototype.
 *
 * @type {{}}
 * @private
 */
(function (global) {
    global._Block = {
        /**
         * Adds Buttons bar for each block.
         *
         * @param selector
         * @constructor
         */
        Setup: function (selector) {
            $(selector).each(function () {
                $(this).find('.block-admin-buttons').remove();

                var id      = $(this).data('id');
                var status  = $(this).data('status');

                var $bar = $('.block-admin-buttons.beaver-mockup').clone();

                $bar.find('button').each(function () {
                    $(this).data('id', id);

                    if ('publish' === $(this).data('rel')) {
                        $(this).data('published', status);
                        $(this).find('.far').removeClass('fa-check-circle fa-times-circle');
                        $(this).find('svg').removeClass('fa-check-circle fa-times-circle');
                        $(this).removeClass('unpublished, published');

                        if (0 === status) {
                            $(this).find('.far').addClass('fa-times-circle');
                            $(this).find('svg').addClass('fa-times-circle');
                            $(this).addClass('unpublished');
                        }
                        if (1 === status) {
                            $(this).find('.far').addClass('fa-check-circle');
                            $(this).find('svg').addClass('fa-check-circle');
                            $(this).addClass('published');
                        }
                    }
                });

                $bar.removeClass('beaver-mockup');

                $(this).prepend($bar);

                // Set buttons.
                var refreshButton   = $(this).find('[data-rel="refresh"]');
                var moveDownButton  = $(this).find('[data-rel="move-down"]');
                var moveUpButton    = $(this).find('[data-rel="move-up"]');
                var dropButton      = $(this).find('[data-rel="drop"]');
                var publishButton   = $(this).find('[data-rel="publish"]');

                moveDownButton.off('click').on('click', _Block.Move);
                moveUpButton.off('click').on('click', _Block.Move);
                dropButton.off('click').on('click', _Block.Delete);
                refreshButton.off('click').on('click', _Block.Refresh);
                publishButton.off('click').on('click', _Block.Publish);

                _Block.DisableMoveButtons();
            });
        },

        /**
         * Publish/Unpublish a Block.
         *
         * @constructor
         */
        Publish: function () {
            var $block = $(this).parents('[data-beaver="block"]');
            var id = $block.data('id');

            // 1 - Published || 0 - Unpublished
            var status  = parseInt($block.data('status'));

            if (1 === status) {
                _Modal.Confirm({
                    message     : 'Esta acción despublicará el bloque. ¿Desea continuar?',
                    callback    : function () {
                        _Http.Put({
                            url         : Routing.generate('beaver.ajax.blocks.publish', {id:id}),
                            callback    : function (data) {
                                $('#block-' + id).replaceWith(data);
                                _Utils.setBars();
                                _Modal.Close();
                            }
                        });
                    }
                });
            }

            if (0 === status) {
                _Http.Put({
                    url         : Routing.generate('beaver.ajax.blocks.publish', {id:id}),
                    callback    : function (data) {
                        $('#block-' + id).replaceWith($(data));
                        _Utils.setBars();
                    }
                });
            }
        },

        /**
         * Reload Block.
         *
         * @constructor
         */
        Refresh: function (block) {
            var id = block;
            if (true === block.hasOwnProperty('type')) {
                var $block = $(this).parents('[data-beaver="block"]');
                id = $block.data('id');
            }

            _Http.Get({
                url         :    Routing.generate('beaver.ajax.blocks.get', {id:id}),
                callback    :   function (data) {
                    $('#block-' + id).replaceWith(data);
                    _Utils.setBars();
                }
            });
        },

        /**
         * Disable move buttons of first and last Blocks.
         *
         * @constructor
         */
        DisableMoveButtons: function () {
            // Disable Move Buttons
            $('[data-beaver="block"]')
                .find('[data-rel="move-down"], [data-rel="move-up"]').attr('disabled', false);
            $('[data-beaver="block"][data-order="1"]')
                .find('[data-rel="move-up"]').attr('disabled', true);
            $('[data-beaver="block"][data-order="1"]').parent()
                .find('[data-beaver="block"]:last')
                .find('[data-rel="move-down"]').attr('disabled', true);
        },

        /**
         * Change Block Vertical Position.
         *
         * @constructor
         */
        Move: function () {
            var $block = $(this).parents('[data-beaver="block"]');

            var $blockToMove     = $block;
            var $blockToReplace  = $blockToMove.next('[data-beaver="block"]');

            if ('move-up' === $(this).data('rel')) {
                $blockToReplace = $blockToMove.prev('[data-beaver="block"]');
            }

            var $actionButton = $(this);
            _Http.Put({
                url         : Routing.generate('beaver.backend.ajax.block.move', {id: $blockToMove.data('id'), blockToReplace: $blockToReplace.data('id')}),
                callback    : function (data) {
                    var reorder = function () {
                        $blockToMove.parent().find('[data-beaver="block"]')
                            .each(function () {
                                $(this).attr('data-order', $(this).index() + 1);
                            });

                        _Block.DisableMoveButtons();
                    };

                    if ('move-up' === $actionButton.data('rel')) {
                        $.when($blockToMove.insertBefore($blockToReplace)).then(reorder);
                    }

                    if ('move-down' === $actionButton.data('rel')) {
                        $.when($blockToMove.insertAfter($blockToReplace)).then(reorder);
                    }
                }
            });
        },

        /**
         * Drop a Block.
         *
         * @constructor
         */
        Delete: function () {
            var id = $(this).data('id');

            _Modal.Confirm({
                message : 'Are you sure chavón?',
                callback: function () {
                    _Http.Delete({
                        url         : Routing.generate('beaver.ajax.blocks.drop', {id: id}),
                        callback    : function (data) {
                            _Modal.Success({
                                message     : 'Muy bien!',
                                callback    : function () {
                                    $('#block-' + id).fadeOut(750, 'swing', function () {
                                        $.when($(this).remove())
                                            .then(function () {
                                                $('.beaver-block').each(function () {
                                                    $(this).attr('data-order', $(this).index() + 1);
                                                });
                                                _Block.DisableMoveButtons();
                                            });
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }
    };
}).call(this, typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : typeof window !== 'undefined' ? window : {});
