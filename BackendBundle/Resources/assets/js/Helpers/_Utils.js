'use strict';

/**
 * Utils package.
 * 
 * @type {{}}
 * @private
 */
(function (global) {
    global._Utils = {
        progressbar: false,

        /**
         * Loader In.
         */
        loadingIn: function () {
            _Utils.lineProgress();
            $('#loading').removeClass('out in').addClass('in');
        },

        /**
         * Loader Out.
         */
        loadingOut: function () {
            $('#loading').removeClass('out in').addClass('out');
            $('#line-progress').remove();
        },

        /**
         * Start line progress animation.
         */
        lineProgress: function () {
            if (0 === $('body').has('#line-progress').length) {
                $('body').append($('<div id="line-progress"></div>'));
            }

            _Utils.progressbar = new ProgressBar.Line('#line-progress', {
                strokeWidth     : 4,
                easing          : 'easeInOut',
                duration        : 1400,
                color           : '#20c0ab',
                trailColor      : '#eee',
                trailWidth      : 1,
                svgStyle        : { width: '100%', height: '100%' },
                from            : { color: '#FFEA82' },
                to              : { color: '#ED6A5A' },
                step            : function (state, bar) {
                    bar.path.setAttribute('stroke', state.color);
                }
            });
        },

        /**
         * Initialize all bars buttons.
         */
        setBars: function () {
            _Area.Setup('[data-beaver="area"]');
            _Block.Setup('[data-beaver="block"]');
            _Slot.Setup('[data-beaver="slot"]');
        }
    };
}).call(this, typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : typeof window !== 'undefined' ? window : {});