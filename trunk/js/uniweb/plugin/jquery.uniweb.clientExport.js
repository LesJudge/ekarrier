;(function ( $, window, document, undefined ) {
    var pluginName = "clientExport",
        defaults = {
            dialogSelector: "",
            dialogSettings: {
                autoOpen: false,
                height: 600,
                modal: true,
                width: 800
            },
            errorSelector: "",
            formSelector: "",
            submitSelector: ""
        };

    function Plugin ( element, options ) {
        this.element = element;
        this.settings = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    $.extend(Plugin.prototype, {
        init: function () {
            var $error = $(this.settings.errorSelector),
                $form = $(this.settings.formSelector), // Formon belül szelektor, amibe klónozva lesznek az elemek.
                $submit = $(this.settings.submitSelector), // Submit gomb selector.
                // Dialógus ablak inicializálása.
                $dialog = $(this.settings.dialogSelector).dialog($.extend({}, this.settings.dialogSettings, {
                    buttons: {
                        "Bezárás": function() {
                            $dialog.dialog("close");
                        },
                        "Exportálás": function() {
                            $error.hide();
                            // Kiválasztja az összes checked checkboxot.
                            var $checkedBoxes = $dialog.find("input:checkbox:checked");
                            if ($checkedBoxes.length > 0) {
                                $form.find("input:checkbox").remove();
                                $checkedBoxes.clone().appendTo($form);
                                $checkedBoxes.attr("checked", false);
                                $dialog.dialog("close");
                                $submit.trigger("click");
                            } else {
                                $error.show();
                            }
                        }
                    }
                }))
            $(this.element).click(function() {
                $dialog.dialog("open");
            });
        }
    });

    $.fn[ pluginName ] = function ( options ) {
        this.each(function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            }
        });
        return this;
    };
})( jQuery, window, document );