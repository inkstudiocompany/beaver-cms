'use strict';

(function ($) {
    $.fn.extend({
        /**
         * Start
         */
        galleryType: function () {
            $(this)
                .off('click')
                .on('click', function() {
                    var rel = $(this).data('rel');
                    _Modal.Open({
                        inline  : true,
                        url     : Routing.generate('beaver.gallery.type'),
                        data    : 'idType=' + rel,
                        width   : '90%',
                        onOpen  : function () {
                            var $images = $('.gallery-selection[data-rel="' + rel + '"] .card');
                            $images.each(function () {
                               $('.gallery-choice-type .card[data-image="'+$(this).data('image')+'"]').addClass('selected');
                            });
                            $.fn.galleryValidate($images);
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

                    var $input  = $('#' + $(this).parents('.gallery').data('type'));
                    var $images = $('.gallery-selection[data-rel="' + $(this).parents('.gallery').data('type') + '"]');

                    $input.val('');
                    $images.find('[data-image="' + $(this).data('image') + '"]').remove();

                    if (true === $(this).is('.selected')) {
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
            console.log($images.length);
        }
    });
})(jQuery);