(function ($) {
    $.fn.extend({
        /**
         * Setup buttons for page list
         * @returns {*}
         */
        pagePublishButtons: function () {
            $('[data-rel="page-publish"]').each(function () {
                return $(this).on('click', function () {
                    $.fn.loadingIn();
                    let page = $(this).data('id');

                    $.ajax({
                        method: 'POST',
                        url:    'page/publish/' + page,
                        success: function (response) {
                            if (false === response.status) {
                                alert('Algo malió sal!');
                                $.fn.loadingOut();
                                return;
                            }

                            let page = $('[data-rel="page-publish"][data-id="'+response.data.id+'"]');
                            page
                                .removeClass('olive red')
                            ;
                            if (false === response.data.published) {
                                page
                                    .addClass('red')
                                    .html('Unpublished\n')
                                    .append($('<i class="fa fa-times-circle-o"></i>'))
                                ;
                            }
                            if (true === response.data.published) {
                                page
                                    .addClass('olive')
                                    .html('Published\n')
                                    .append($('<i class="fa fa-check-circle-o"></i>'))
                                ;
                            }

                            $.fn.loadingOut();
                        }
                    });
                });
            });
        },
    });
})(jQuery);