;(function ( $, window, document, undefined ) {
    $.widget("uniweb.projectCreator", $.uniweb.clientBaseWidget, {
        options: {
            projectUrl: "",
            action: "",
            dialogSettings: {},
            selectors: {
                dialog: "",
                filters: "",
                formError: "",
                projectNameInput: ""
            }
        },
        /**
         * Visszatér az AJAX URL-el.
         * @returns {String}
         */
        getAjaxUrl: function() {
            return this._getOption("baseUrl") + this._getOption("projectUrl");
        },
        /**
         * Inicializálja a plugint.
         */
        _init: function() {
            var self = this,
                ds = this._getSelector("dialog");
            // Dialógusablak inicializálása.
            $(ds).dialog($.extend({}, this._getOption("dialogSettings"), {
                buttons: {
                    "Mentés": function() {
                        self.element.trigger("create");
                    },
                    "Mégsem": function() {
                        $(this).dialog("close");
                    }
                }
            }));
            // Kattintásra nyissa meg a dialógus ablakot.
            this.element.click(function() {
                $(ds).dialog("open");
            });
        },
        _fatalError: function() {
            this.element.hide();
            this.destroy();
        },
        /**
         * Létrehozza a plugint.
         */
        _create: function() {
            var self = this;
            // Projekt létrehozása.
            self.element.bind("create", function(e) {                
                var rd = new Object(), // RequestData objektum.
                    $pni = $(self._getSelector("projectNameInput")); // Projekt neve input.
                rd[self._getOption("action")] = 1; // Beállítja az action nevét.
                rd["name"] = $pni.val();
                $.ajax({
                    data: $.param(rd) + "&" + $.param($(self._getSelector("filters")).serializeArray()),
                    dataType: "json",
                    success: function(data) {
                        if (data.result === true) {
                            var $formError = $(self._getSelector("formError")),
                                msg = "Sikeresen létrehozta a/az " + $pni.val() + " nevű projektet!";
                            $formError.find("li").remove();
                            $formError.hide();
                            $pni.val(null);
                            $(self._getSelector("dialog")).dialog("close");
                            self._addMessage(self._getSelector("feedbackSuccess"), msg);
                        } else {
                            self._addFormError(data.message).show();
                        }
                    },
                    url: self.getAjaxUrl(),
                    type: "POST"
                });
            });
        }
    });
})( jQuery, window , document );