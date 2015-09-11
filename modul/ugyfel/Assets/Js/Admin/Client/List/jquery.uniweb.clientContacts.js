;(function ( $, window, document, undefined ) {
    $.widget("uniweb.clientContacts", {
        options: {
            selectors: {
                dialogCreate: "",
                createBtn: "",
                feedbackError: "",
                feedbackSuccess: "",
                fatalError: "",
                table: ""
            },
            readUrl: "",
            createUrl: ""
        },
        _addMessage: function(selector, message) {
            $(selector).html("<p>" + message + "</p>").show();
        },
        /**
         * Plugin inicializálása.
         */
        _init: function() {
            var self = this, 
                $formContainer = $('#contact-form-container');
        
            $(this.options.selectors.createBtn).button({
                create: function(ui, event) {
                    $(ui.target).click(function() {
                        $(self.options.selectors.dialogCreate).dialog("open");
                    });
                },
                icons: {
                    primary: "ui-icon-plusthick"
                }
            });
            
            // Létrehozás dialógusablak inicializálása.
            $(this.options.selectors.dialogCreate).dialog($.extend({}, this.options.dialogCreate, {
                buttons: {
                    "Mentés": function() {
                        self.element.trigger("create");
                    },
                    "Mégsem": function() {
                        $(this).dialog("close");
                    }
                }
            }));
            
            $('#contact-type-select').change(function() {
                if (this.value != '') {
                    var $form = $('#contact-form-' + this.value);

                    if ($form.length > 0) {
                        $formContainer.html($form.html());
                    } else {
                        console.log('nincs form!');
                    }
                } else {
                    $formContainer.html('');
                }
            });
            
        var currentYear = new Date().getUTCFullYear(), // Aktuális év.
            datepickerSettings = { // Datepicker alapértelmezett beállítása a formon.
                yearRange: (currentYear - 100) + ":" + currentYear
            };
            $("#contact-datum, #contact-mediation-mikor").datepicker(datepickerSettings);
        },
        _create: function() {
            var self = this;
            // Esetnapló bejegyzés mentése.
            self.element.bind("create", function() {
                $.ajax({
                    url: self.options.createUrl,
                    dataType: "json",
                    success: function(data) {
                        self.element.trigger("afterCreate", {
                            message: "Sikeresen mentette a bejegyzést!",
                            result: true
                        });
                    },
                    error: function(xhr) {
                        var message = "";
                        switch (xhr.status) {
                            case 400:
                                message = "Nem megfelelő adatok! Kérem ellenőrizze, hogy megfelelő dátum értékeket " + 
                                        "adott-e meg, illetve a név hossza 3 és 128 karakter között van!" ;
                                break;
                            case 403:
                                message = "Nincs jogosultsága a bejegyzés mentéséhez!";
                                break;
                            case 404:
                                message = "Az URL nem megfelelő!";
                                break;
                            case 500:
                                message = "A bejegyzés mentése sikertelen!";
                                break;
                            default:
                                message = "Ismeretlen hiba!";
                                break;
                        }
                        self.element.trigger("afterCreate", {
                            message: message,
                            result: false
                        });
                    },
                    data: {
                        contact: {
                            isMediation: $("#contact-is-mediation").val(),
                            nev: $("#contact-nev").val(),
                            datum: $("#contact-datum").val(),
                            megjegyzes: $("#contact-megjegyzes").val(),
                            mediation: {
                                hova: $("#contact-mediation-hova").val(),
                                megjelent: $("#contact-mediation-megjelent").val(),
                                mikor: $("#contact-mediation-mikor").val()
                            }
                        }
                    },
                    type: "POST"
                });
            });
            self.element.bind("afterCreate", function(e, data) {
                if (data.result === true) {
                    self._addMessage(self.options.selectors.feedbackSuccess, data.message);
                } else {
                    self._addMessage(self.options.selectors.feedbackError, data.message);
                }
                $(self.options.selectors.dialogCreate).dialog("close");
                if (data.result === true) {
                    self.element.trigger("refresh");
                }
            });
            // Refresh esemény.
            self.element.bind("refresh", function(e) {
                var $table = $(self.options.selectors.table),
                    $tbody = $table.find("tbody");
                $tbody.html(null);
                $.ajax({
                    dataType: "json",
                    error: function (xhr) {
                        var message = xhr.responseText && xhr.responseText.length > 0 ? xhr.responseText : "Végzetes hiba történt!";
                        $table.hide();
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(index, contact) {
                                var html = "<tr>";
                                html += "<td>" + contact.tipus + "</td>";
                                html += "<td>" + contact.nev + "</td>";
                                html += "<td>" + contact.datum + "</td>";
                                html += '<td><button type="button"></button></td>';
                                html += '<td><button type="button"></button></td>';
                                html += "</tr>";
                                $(html).appendTo($tbody);
                            });
                        } else {
                            $tbody.append('<tr><td colspan="5">Nincs megjeleníthető bejegyzés!</td></tr>');
                        }
                        
                        if (data.result === true) {
                            var files = data.files;
                            if (files.length > 0) {
                                $.each(files, function(index, file) {
                                    self._addFile(file);
                                });
                            } else {
                                $tbody.append('<tr><td colspan="5">Nincs megjeleníthető bejegyzés!</td></tr>');
                            }
                        }
                        $table.show();
                    },
                    url: self.options.readUrl,
                    type: "GET"
                });
            });
        }
    });
})( jQuery, window , document );