(function ($) {
    $.fn.extend({
        /**
         * Init the functions for navbar
         */
        navbar: () => {
            $('.submenu')
                .off('click')
                .on('click', function(){
                $(this).next('ul').toggleClass('active');
            });

            $('.ui.dropdown.item')
                .off('mouseover')
                .on('mouseover', function () {
                $(this).addClass('active');
                $(this).find('.menu').addClass('transition visible');
            })
                .off('mouseout')
                .on('mouseout', function () {
                $(this).find('.menu').removeClass('visible').addClass('hidden');
                $(this).removeClass('active');
            })
            ;

            $('#menu-button.hamburguer-menu').burger();
        },

        /** Animate CSS
         * https://github.com/daneden/animate.css
         * @param animationName
         * @returns {animateCss}
         */
        animateCss: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
            return this;
        }

    });
})(jQuery);