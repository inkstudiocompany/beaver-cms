'use strict';

/**
 * Define Modal Windows for Alerts, Message, Confirms and Contents.
 *
 * @type {{}}
 * @private
 */
(function (global) {
    global._Modal = {
        /**
         * Creates a Modal Window.
         *
         * @param options
         * @constructor
         */
        Open: function (options) {
            this.defaults = {
                title   : '',
                content : '<p>Your content could be here</p>',
                url     : '',
                data    : '',
                inline  : false,
                width   : 'auto',
                onClose : function () {},
                onOpen  : function () {}
            };

            var settings = $.extend(this.defaults, options);

            if (settings.inline === true) {
                $.ajax({
                    url     : settings.url,
                    data    : settings.data,
                    success : function (response) {
                        $.sweetModal({
                            width   : settings.width,
                            title   : settings.title,
                            content : response,
                            onClose : settings.onClose,
                            onOpen  : settings.onOpen
                        });
                    }
                })
                return false;
            }

            if (settings.inline === false) {
                $.sweetModal({
                    title   : settings.title,
                    content : settings.content,
                    onClose : settings.onClose
                });
            }
        },

        /**
         * Alert.
         * @param message
         * @constructor
         */
        Alert: function (message) {
            $.sweetModal(message);
        },

        /**
         * Success Alert.
         * @param options
         * @constructor
         */
        Success: function (options) {
            this.defaults = {
                message: '',
                onClose: function () {}
            };

            var settings = $.extend(this.defaults, options);

            $.sweetModal({
                content : settings.message,
                icon    : $.sweetModal.ICON_SUCCESS,
                onClose : settings.onClose
            });
        },

        /**
         * Error.
         * @param message
         * @constructor
         */
        Error: function (message) {
            _Utils.loadingOut();

            $.sweetModal({
                content : message,
                title   : 'Process Error!',
                icon    : $.sweetModal.ICON_ERROR,
                buttons: [
                    {
                        label: 'Esta bien!',
                        classes: 'redB'
                    }
                ]
            });
        },

        /**
         * Initilize Form into Modal Window.
         *
         * @param options
         * @constructor
         */
        Form: function (options) {
            this.defaults = {
                url     : false,
                data    : false,
                callback: function (response) {
                    console.log(response);
                },
            };

            var settings = $.extend(this.defaults, options);

            if (settings.source === false) {
                return;
            }

            _Http.Get({
                url     : settings.url,
                data    : settings.data,
                callback: function (data) {
                    $.sweetModal({
                        content             : data,
                        showCloseButton     : true,
                        onOpen: function () {
                            $('form').on('submit', function(e){
                                e.preventDefault();

                                _Http.Request({
                                    method  : $('form').attr('method'),
                                    url     : $('form').attr('action'),
                                    data    : $('form').serialize(),
                                    callback: function (data) {
                                        settings.callback(data);
                                        _Modal.Close();
                                    }
                                });
                            });
                        }
                    });
                }
            });
        },

        /**
         * Confirm.
         *
         * @param options
         * @constructor
         */
        Confirm: function (options) {
            this.defaults = {
                callback    : function () {},
                message     : false
            };

            var settings = $.extend(this.defaults, options);

            $.sweetModal.confirm(settings.message, settings.callback);
        },

        /**
         * Close Modal Windows.
         *
         * @constructor
         */
        Close: function () {
            $.sweetModal.storage.openModals.forEach(function (modal) {
                modal.close();
            });
        },
    };
}).call(this, typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : typeof window !== 'undefined' ? window : {});
