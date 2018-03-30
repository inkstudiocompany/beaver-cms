'use strict';

(function ($) {
    $.fn.extend({
        /**
         * Start
         */
        galleryType: function () {
            var size = $(this).data('size');
            $(this)
                .off('click')
                .on('click', function() {
                    var rel = $(this).data('rel');
                    _Modal.Open({
                        inline  : true,
                        url     : Routing.generate('beaver.gallery.type'),
                        data    : 'idType=' + rel + '&size=' + size,
                        width   : '90%',
                        onOpen  : function () {
                            var $images = $('.gallery-selection[data-rel="' + rel + '"] .card');
                            $images.each(function () {
                               $('.gallery-choice-type .card[data-image="'+$(this).data('image')+'"]').addClass('selected');
                            });

                            console.log(size, $images.length);

                            $('.card.image-type').toggleImage();
                        }
                    });
                });
        },

        /**
         *
         */
        toggleImage: function () {
            $(this)
                .off('click')
                .on('click', function() {
                    $(this).toggleClass('selected');

                    var size    = $(this).parents('.gallery').data('size');
                    var $input  = $('#' + $(this).parents('.gallery').data('type'));
                    var $images = $('.gallery-selection[data-rel="' + $(this).parents('.gallery').data('type') + '"]');

                    var selectAllowed = true;
                    if (size === $images.find('.card').length) {
                        selectAllowed = false;
                        if (false === $(this).is('.selected')) {
                            selectAllowed = true;
                        }
                    }

                    if (false === selectAllowed) {
                        $(this).removeClass('selected');
                        _Modal.Alert('La cantidad máxima de imágenes es ' + size);
                        return false;
                    }

                    $input.val('');
                    $images.find('[data-image="' + $(this).data('image') + '"]').remove();

                    if (true === $(this).is('.selected') && true === selectAllowed) {
                        $input.val($(this).data('image'));
                        var $card = $(this).clone();
                        $card.find('[data-prefix="far"]').remove();
                        $images.append($card);
                    }
                });
        },

        /**
         *
         * @param $images
         */
        galleryValidate: function ($images) {
            console.log($images.find('.card').length);
        }
    });
})(jQuery);