'use strict';

/**
 * Define Http Helpers Package.
 *
 * @type {{}}
 * @private
 */
(function (global) {
    global._Http = {
        /**
         * Request default values.
         */
        defaults: {
            method      : 'GET',
            url         : '',
            data        : '',
            callback    : function (response) {
                console.log(response);
            }
        },

        /**
         * Define Http Ajax Request.
         *
         * @param options
         * @constructor
         */
        Request: function (options) {
            var settings = $.extend(_Http.defaults, options);

            _Utils.loadingIn();
            _Utils.progressbar.animate(0.4);

            $.ajax({
                method  : settings.method,
                url     : settings.url,
                data    : settings.data,
                success : function (response) {
                    if (false === response.status) {
                        _Modal.Error(response.error);
                    }

                    if (true === response.status) {
                        _Utils.progressbar.animate(1, function() {
                            _Utils.loadingOut();
                            settings.callback(response.data);
                        });
                        return true;
                    }
                }
            });
        },

        /**
         * Http GET Method Request.
         *
         * @param options
         * @constructor
         */
        Get: function (options) {
            var settings = $.extend(_Http.defaults, options);
            _Http.Request(settings);
        },

        /**
         * Http POST Method Request.
         *
         * @param options
         * @constructor
         */
        Post: function (options) {
            var settings = $.extend(_Http.defaults, options);
            settings.method = 'POST';

            _Http.Request(settings);
        },

        /**
         * Http PUT Method Request.
         *
         * @param options
         * @constructor
         */
        Put: function (options) {
            var settings = $.extend(_Http.defaults, options);
            settings.method = 'PUT';

            _Http.Request(settings);
        },

        /**
         * Http DELETE Method Request.
         *
         * @param options
         * @constructor
         */
        Delete: function (options) {
            var settings = $.extend(_Http.defaults, options);
            settings.method = 'DELETE';

            _Http.Request(settings);
        }
    };
}).call(this, typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : typeof window !== 'undefined' ? window : {});