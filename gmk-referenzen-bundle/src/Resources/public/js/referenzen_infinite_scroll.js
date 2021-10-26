/**
 * ReferenzenInfiniteScroll
 * https://github.com/markocupic/news_infinite_scroll
 * Marko Cupic, Oberkirch (Switzerland)
 * Copyright 2017
 */

(function ($) {
    /**
     * @param {Object} options
     */
    ReferenzenInfiniteScroll = function (options) {
        var _opts = $.extend({
            // Defaults
            // Array with news-ids
            ids: [],
            // CSS selector: Abbend loaded items to this container
            newsContainer: '.gmk_ref',
            // CSS selector: Default to $(window)
            scrollContainer: $(window),
            // When set to true, this will disable infinite scrolling and start firing ajax requests on domready with an interval of 3s
            loadAllOnDomready: false,
            // Load x items per request
            itemsPerRequest: 10,
            // CSS selector: When you scroll and the window has reached the anchor point, requests will start
            anchorPoint: '',
            // Distance in px from the top of the anchorPoint
            bottomPixels: 0,
            // Integer: Fading time for loades news items
            fadeInTime: 800,
            // HTML: Show this message during the loading process
            msgText: '<em>Loading...</em>',


            // Callbacks
            onInitialize: function (instance) {
            },
            onXHRStart: function (instance) {
            },
            onXHRComplete: function (response, instance) {
                return response;
            },
            onXHRFail: function (instance) {
            },
            onAppendCallback: function (instance) {
            }
        }, options || {});


        // Private variables
        var _self = this;
        var _newsContainer = null;
        var _anchorPoint = null;
        var _scrollContainer = null;
        var _blnLoadingInProcess = 0;
        var _arrUrls = [];
        var _blnLoadedAllItems = 0;
        var _xhrInterval = 0;

        // Public variables
        _self.blnHasError = false;
        _self.currentUrl = '';
        _self.urlIndex = 0;

        /** Public Methods **/

        /**
         * Get option
         * @param option
         * @returns {boolean|string}
         */
        this.getOption = function (option) {
            if (typeof _opts[option] !== 'undefined') {

                return _opts[option];
            }
            return false;
        };

        /** Private Methods **/

        /**
         * Init function
         */
        var _initialize = function () {
            // Call onInitialize-callback
            _opts.onInitialize(_self);

            if (_opts.ids.length < 1) {
                console.log('ReferenzenInfiniteScroll aborted! There are no items to load.');
                return;
            }
            var i = 0;
            var m = 0;
            var arrIds = [];
            $.each(_opts.ids, function (index, id) {
                i++;
                m++;
                arrIds.push(id);
                if (i == _opts.itemsPerRequest || _opts.ids.length == m) {
                    _arrUrls.push(window.location.href + '?ids=' + arrIds.join('-'));
                    i = 0;
                    arrIds = [];
                }
            });

            // newsContainer
            _newsContainer = $(_opts.newsContainer)[0];
            if (typeof _newsContainer === 'undefined') {
                console.log('ReferenzenInfiniteScroll aborted! Define a valid newsContainer in the template settings.');
                return;
            }

            // scrollContainer
            _scrollContainer = $(_opts.scrollContainer)[0];
            if (typeof _scrollContainer === 'undefined') {
                console.log('ReferenzenInfiniteScroll aborted! Please select a valid scroll container.');
                return;
            }

            // Bottom Pixels
            if (_opts.bottomPixels == 0) {
                _opts.bottomPixels = 1;
            }

            // anchor points settings
            _anchorPoint = $(_newsContainer);
            if (typeof $(_opts.anchorPoint)[0] !== 'undefined') {
                _anchorPoint = $(_opts.anchorPoint)[0];
            }


            // Load elements on domready or load them when scrolling to the bottom
            if (_opts.loadAllOnDomready === true) {
                _load();
                _xhrInterval = setInterval(_load, 100);
            } else {
                // load content by event scroll
                $(_scrollContainer).on('scroll', function () {
                    if ($(_scrollContainer).scrollTop() > ($(_anchorPoint).offset().top + $(_anchorPoint).innerHeight() - $(_scrollContainer).height() - _opts.bottomPixels)) {
                        _load();
                    }
                });
            }
        };


        /**
         * Load html with xhr
         */
        var _load = function () {

            if (_blnLoadingInProcess == 1 || _blnLoadedAllItems == 1) return;
            _self.blnHasError = false;

            if (_arrUrls.length == _self.urlIndex) {
                _blnLoadedAllItems = 1;
                if (typeof _xhrInterval !== 'undefined') {
                    clearInterval(_xhrInterval);
                }
            }

            _self.currentUrl = _arrUrls[_self.urlIndex];
            if (typeof _self.currentUrl !== 'undefined') {
                $.ajax({
                    url: _self.currentUrl,
                    beforeSend: function () {
                        // Call onXHRStart-Callback
                        _opts.onXHRStart(_self);

                        _blnLoadingInProcess = 1;

                        if (_opts.msgText != '') {
                            // Append Load Icon
                            $(_opts.msgText).addClass('infiniteScrollMsgText').appendTo(_newsContainer).fadeIn(100);
                        }
                    }
                }).done(function (data) {
                    _self.blnHasError = false;
                    var arrResponse = data.split('***####***####***');
                    var response = {
                        status: arrResponse[0],
                        ids: arrResponse[1],
                        html: arrResponse[2]
                    };
                    _self.response = response;
                    var html = _opts.onXHRComplete(response.html, _self);
                    if (_self.blnHasError === false) {
                        _self.urlIndex++;
                        setTimeout(function () {
                            _appendToDom(html);
                        }, 100);
                    } else {
                        _fail();
                    }
                }).fail(function () {
                    _fail();
                }).always(function () {
                    setTimeout(function () {
                        // Remove Load Icon
                        $('.infiniteScrollMsgText').remove();
                        _blnLoadingInProcess = 0;
                    }, 100);

                })
            } else {
                _blnLoadedAllItems = 1;
                if (typeof _xhrInterval !== 'undefined') {
                    clearInterval(_xhrInterval);
                }
            }
        };

        /**
         * Fail Method
         */
        var _fail = function () {

            _blnLoadingInProcess = 0;
            // Call onXHRFail-callback
            _opts.onXHRFail(_self);
        };

        /**
         * Append items to DOM
         * @param html
         */
        var _appendToDom = function (html) {
            // Append html to dom and fade in
            $(html).hide().appendTo(_newsContainer).fadeIn(_opts.fadeInTime);

            // Call onAppendCallback-callback
            _opts.onAppendCallback(_self);
        }

        // Start procedure
        _initialize();
    };
})(jQuery);
