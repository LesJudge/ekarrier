;(function ( $, window, document, undefined ) {
    $.widget("uniweb.clientBaseWidget", {
        options: {
            baseUrl: "",
            messageDelay: 5000,
            messageFade: 500,
            messageTextTag: "p",
            selectors: {
                fatalError: "",
                feedbackError: "",
                feedbackInfo: "",
                feedbackSuccess: "",
                formError: ""
            }
        },
        /**
         * Visszatér az alap AJAX URL-el.
         * @returns {String}
         */
        getAjaxUrl: function() {
            return this._getOption("baseUrl");
        },
        /**
         * Visszatér a paraméterül adott beállítás értékével, ha az létezik. Ha nem, akkor null-lal.
         * @param {String} name Beállítás neve.
         * @returns {Mixed}
         */
        _getOption: function(name) {
            return (this.options[name] !== undefined) ? this.options[name] : null;
        },
        /**
         * Visszatér a paraméterül adott selectorral, ha az létezik. Ha nem, akkor null-lal.
         * @param {String} selector Selector neve.
         * @returns {Mixed}
         */
        _getSelector: function(selector) {
            var selectors = this._getOption("selectors");
            return (selectors[selector] !== undefined) ? selectors[selector] : null;
        },
        /**
         * Elhelyez egy feedback-et a paraméterül adott containerben.
         * @param {String} selector Selector neve. Ez határozza meg, hogy a success vagy az error feedbackbe rakja-e.
         * @param {String} message Üzenet.
         */
        _addMessage: function(selector, message) {
            this._hideAllFeedbacks();
            var $container = $(selector),
                fade = this._getOption('messageFade');
            $container.find(this._getOption('messageTextTag')).text(message);
            $container.fadeIn(fade).delay(this._getOption('messageDelay')).fadeOut(fade);
        },
        /**
         * Elrejti az összes feedback containert.
         */
        _hideAllFeedbacks: function() {
            this._getAllFeedback().clearQueue().hide();
        },
        /**
         * Visszatér az összes feedback containerrel.
         * @returns {$}
         */
        _getAllFeedback: function() {
            return $(
                this._getSelector('feedbackError') + ", " + this._getSelector('feedbackSuccess') + ", " +
                this._getSelector("feedbackInfo")
            );
        },
        /**
         * Hozzáadja a hibaüzenetet/hibaüzeneteket a formhoz.
         * @param {String|Object} message Hibaüzenet/ek
         * @returns {$}
         */
        _addFormError: function(message) {
            var $errorList = $(this._getSelector("formError"));
            $errorList.find("li").remove();
            if ($.isPlainObject(message)) {
                $.each (message, function(attribute, messages) {
                    $.each (messages, function(key, message) {
                        $errorList.append("<li>" + message + "</li>");
                    });
                });
            } else {
                $errorList.append("<li>" + message + "</li>");
            }
            return $errorList;
        },
        /**
         * Hozzáadja a click eseményt a feedback containerekhez.
         */
        _bindMessageClick: function() {
            var fadeOut = this._getOption('messageFade');
            this._getAllFeedback().click(function() {
                $(this).clearQueue().fadeOut(fadeOut);
            });
        },
        /**
         * Megszabítja a selector által kiválasztott elemeket a <b>uniform</b> plugin-tól.
         * @param {String} selector Selector
         */
        removeUniform: function(selector) {
            if ($.uniform && $.uniform.restore && $.isFunction($.uniform.restore)) {
                $.uniform.restore(selector);
            }
        },
        /**
         * Végzetes hiba esetén a megjeleníti a "hibaképernyőt", valamint megsemmisíti a plugint.
         */
        _fatalError: function(message) {
            this.element.hide();
            this._hideAllFeedbacks();
            var $fatalError = $(this._getSelector("fatalError"));
            $fatalError.html(this._createFatalErrorMessage(message));
            $fatalError.show();
            this.destroy();
        },
        _createFatalErrorMessage: function(message) {
            return '<div class="notice error"><p>' + message + '</p></div>';
        },
        /**
         * Megsemmisíti a plugint.
         */
        destroy: function(){
            $.Widget.prototype.destroy.apply( this, arguments );
        }
    });
})( jQuery, window , document );