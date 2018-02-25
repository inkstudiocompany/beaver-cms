(function ($) {
    $.fn.extend({
        /**
         * Start
         */
        burger: function () {
            $(this)
                .off('click')
                .on('click', function() {
                    console.log('click');
                    $('.hamburguer-menu').toggleClass('open');
                    $('navbar.backend-navbar').toggleClass('active');
                });
        },
    });
})(jQuery);