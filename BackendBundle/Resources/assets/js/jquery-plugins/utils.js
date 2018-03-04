(function ($) {
    $.fn.extend({
        /**
         * Init the functions for navbar
         */
        navbar: function () {
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
        },

        /**
         * Sends form by ajax method.
         *
         * @param options
         * @returns {*}
         */
        formAjax: function (options) {
            var settings = $.extend({
                callback: function (response) {
                    console.log(response);
                }
            }, options);

            return this.each(function () {
                $(this).on('submit', function (e) {
                    e.preventDefault();

                    var ajaxOptions = {
                        method      : $(this).attr('method'),
                        url         : $(this).attr('action'),
                        data        : $(this).serialize(),
                        callback    : settings.callback
                    };

                    if ('multipart/form-data' === $(this).attr('enctype')) {
                        var formData = new FormData($(this));
                        $(this)
                            .find('input[type!="file"],input[type!="button"],input[type!="submit"],select,textarea')
                            .each(function (index,elem) {
                                formData.append($(elem).attr('name'), $(elem).val());
                            });

                        $(this).find('input[type="file"]').each(function (index,elem) {
                            formData.append($(elem).attr('name'), $(elem).prop('files')[0]);
                        });

                        ajaxOptions = {
                            method:     $(this).attr('method'),
                            url:        $(this).attr('action'),
                            data:       formData,
                            callback:   settings.callback,
                            processData:false,
                            contentType:false
                        };
                    }

                    _Http.Request(ajaxOptions);
                });
            });
        }
    });
})(jQuery);