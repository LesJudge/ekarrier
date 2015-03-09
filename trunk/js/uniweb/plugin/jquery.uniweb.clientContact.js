;(function ( $, window, document, undefined ) {
    $.widget("uniweb.clientContact", $.uniweb.clientBaseWidget, {
        options: {
            baseUrl: "", // Alap (DOMAIN) URL.
            clientId: 0, // Ügyfél azonosító.
            contactsUrl: "", // Kapcsolatfelvétel útvonal.
            dataContactId: "", // Esetnapló azonosítót tároló data-attribútum neve.
            dialogCreate: {}, // Létrehozás dialógus ablak beállításai.
            dialogDelete: {}, // Törlés dialógus ablak beállításai.
            useTinyMCE: false,
            selectors: {
                addButton: "", // Hozzáadás gomb.
                createDialog: "", // Létrehozás dialógus ablak.
                deleteDialog: "", // Törlés dialógus ablak.
                fatalError: "", // Végzetes hiba.
                feedbackError: "", // Hibás művelet.
                feedbackSuccess: "", // Sikeres művelet.
                formError: "", // Form hibaüzenet.
                inputContactDate: "",
                inputComment: "",
                inputTypeId: "",
                table: "" // Táblázat.
            }
        },
        /**
         * Visszatér az ügyfél azonosítóval.
         * @returns {Number}
         */
        getClientId: function() {
            return this._getOption("clientId");
        },
        /**
         * Visszatér az alap AJAX URL-el.
         * @returns {String}
         */
        getAjaxUrl: function() {
            return this._getOption("baseUrl") + this._getOption("contactsUrl");
        },
        /**
         * Visszatér az alap AJAX objektummal.
         * @returns {Object}
         */
        _getBaseAjax: function() {
            return {
                dataType: "json",
                method: "POST",
                url: this.getAjaxUrl()
            };
        },
        /**
         * Beszúrja az esetnapló bejegyzést a táblázatba.
         * @param {Object} contact Esetnapló bejegyzés adatai.
         */
        _addContactRow: function(contact) {
            var $row = $("<tr></tr>"), // Új <tr> TAG létrehozása.
                contactDate = new Date(contact.datum), // Kapcsolatfelvétel ideje Date objektum.
                createDate = new Date(contact.letrehozas_timestamp), // Létrehozás ideje Date objektum.
                coStr = contactDate, // Kapcsolatfelvétel ideje (ezt jeleníti majd meg.)
                crStr = createDate; // Létrehozás ideje (ezt jeleníti majd meg).
                /**
                 * Warning:
                 * Az uwGetFormattedDate() és uwGetFormattedTime() metódusok csak akkor elérhetőek a Date objektum 
                 * esetében, ha az uniweb.prototype.js fájl be van töltve!
                 */
                // Megvizsgálja, hogy létrezik-e az uwGetFormattedDate() metódus.
                if ($.isFunction(contactDate.uwGetFormattedDate)) {
                    coStr = contactDate.uwGetFormattedDate(); // Ha igen, felülírja a jelenlegi értéket.
                }
                // Ugyanaz, mint feljebb.
                if ($.isFunction(createDate.uwGetFormattedDate) && $.isFunction(createDate.uwGetFormattedTime)) {
                    crStr = createDate.uwGetFormattedDate() + " " + createDate.uwGetFormattedTime();
                }
            // <td> TAG-ek hozzáadása a feljebb létrehozott <tr> TAG-hez.
            $("<td>" + contact.megjegyzes + "</td>").appendTo($row);
            $("<td>" + coStr  + "</td>").appendTo($row);
            $("<td>" + contact.nev + "</td>").appendTo($row);
            $("<td>" + crStr + "</td>").appendTo($row);
            $("<td>" + contact.user_vnev + " " + contact.user_knev + " (" + contact.user_fnev + ")" + "</td>").appendTo(
                $row
            );
            // Törlés gomb létrehozása és inicializálása.
            this._createDeleteButton(contact.ugyfel_attr_esetnaplo_id).appendTo($("<td></td>").appendTo($row));
            // Sor hozzáadása a táblázathoz.
            $row.appendTo($(this._getSelector("table")).find("tbody"));
        },
        /**
         * Beszúr egy "üres" sort a táblázatba.
         * @param {String} message Üzenet.
         */
        _addEmptyRow: function(message) {
            $("<tr><td colspan=\"6\">" + message + "</td></tr>").appendTo($(this._getSelector("table")).find("tbody"));
        },
        /**
         * Létrehoz egy törlés gombot.
         * @param {Number} id Esetnapló bejegyzés azonosítója.
         * @returns {$}
         */
        _createDeleteButton: function(id) {
            var $btn = $("<button type=\"button\" value=\"" + id + "\"></button>"), // <button> TAG létrehozása.
                dialogSelector = this._getSelector('deleteDialog'), // Törlés dialógus ablak selector.
                contactId = this._getOption("dataContactId"); // Contact ID data "index".
            $btn.button({
                create: function(event, ui) {
                    $(this).bind("click", function() {
                        // A dialógus ablakban egy data attribútumban letárolja az esetnapló bejegyzés azonosítót.
                        // Erre azért van szükség, mert az AJAX hívásnál ezt használja.
                        // Ezután megnyitja a dialógus ablakot.
                        $(dialogSelector).data(contactId, +this.value).dialog("open");
                    });
                },
                icons: {
                    primary: "ui-icon-trash"
                },
                text: false
            });
            return $btn;
        },
        /**
         * Inicializálja a plugint.
         */
        _init: function() {
            var self = this;
            // Új esetnapló bejegyzés dialógus ablak inicializálása.
            $(this._getSelector("createDialog")).dialog($.extend({}, self._getOption("dialogCreate"), {
                buttons: {
                    "Mentés": function() {
                        self.element.trigger("create");
                    }
                }
            }));
            // Esetnapló bejegyzés törlés dialógus ablak.
            $(this._getSelector("deleteDialog")).dialog($.extend({}, self._getOption("dialogDelete"), {
                buttons: {
                    "Mégsem": function() {
                        $(this).data(self._getOption("dataContactId"), 0).dialog("close");
                    },
                    "Törlés": function() {
                        self.element.trigger("delete", $(this).data(self._getOption("dataContactId")));
                    }
                }
            }));
            // Létrehozás gomb inicializálása.
            $(this._getSelector("addButton")).button({
                create: function(event, ui) {
                    $(this).click(function() {
                        $(self._getSelector("createDialog")).dialog("open");
                    });
                },
                icons: {
                    primary: "ui-icon-comment"
                }
            });
            // Click esemény a feedback containerekre.
            this._bindMessageClick();
        },
        /**
         * Létrehozza a plugint, bindeli az eseményeket.
         */
        _create : function() {
            var self = this;
            // Esetnapló bejegyzések lekérdezése és megjelenítése.
            self.element.bind("refresh", function(e) {
                // Törli a táblázat <tbody> TAG-jének tartalmát.
                $(self._getSelector("table")).find("tbody").html(null);
                $.ajax($.extend({}, self._getBaseAjax(), {
                    method: "GET",
                    url: self.getAjaxUrl() + self.getClientId() + "/all",
                    success: function(data) {
                        // Ha van esetnapló bejegyzés, akkor megjeleníti azokat.
                        if (data.length > 0) {
                            $.each(data, function(index, contact) {
                                self._addContactRow(contact);
                            });
                        } else {
                            // Ha nincs, egy "üres" sort szúr be.
                            self._addEmptyRow("Nincs megjeleníthető kapcsolat!");
                        }
                    },
                    error: function(xhr) {
                        self._fatalError();
                    }
                }));
            });
            // Új esetnapló bejegyzés mentése.
            self.element.bind("create", function(e) {
                var comment = $(self._getSelector("inputComment")).val();
                if (self._getOption("useTinyMCE")) {
                    comment = tinyMCE.activeEditor.getContent();
                }
                $.ajax($.extend({}, self._getBaseAjax(), {
                    type: "POST",
                    data: {
                        ClientContact: {
                            felvetel_ideje: $(self._getSelector("inputContactDate")).val(),
                            megjegyzes: comment,
                            ugyfel_esetnaplo_tipus_id: $(self._getSelector("inputTypeId")).val(),
                            ugyfel_id: self.getClientId()
                        },
                        method: "create"
                    },
                    success: function(data) {
                        if (data.result === true) {
                            self.element.trigger("afterCreate");
                        } else {
                            self._addFormError(data.message).show();
                        }
                    }
                }));
            });
            // Sikeres esetnapló bejegyzés mentés után lefutó esemény.
            self.element.bind("afterCreate", function(e) {
                // "Alapértelmezetté" teszi a formot.
                $(self._getSelector("inputContactDate") + 
                    ", " + 
                    self._getSelector("inputComment") + ", " + 
                    self._getSelector("inputTypeId")
                ).val(null);
                if (self._getOption("useTinyMCE")) {
                    tinyMCE.activeEditor.setContent("");
                }
                // Form hibaüzenetek elrejtése.
                $(self._getSelector("formError")).hide();
                // Bezárja a dialógus ablakot.
                $(self._getSelector("createDialog")).dialog("close");
                // Megjeleníti a sikeres művelet feedback-et.
                self._addMessage(self._getSelector("feedbackSuccess"), "Sikeresen létrehozta a bejegyzést!");
                // Majd pedig frissíti a listát.
                self.element.trigger("refresh");
            });
            // Esetnapló bejegyzés törlése.
            self.element.bind("delete", function(e, id) {
                $.ajax($.extend({}, self._getBaseAjax(), {
                    data: {
                        contactId: id,
                        method: "delete"
                    },
                    success: function(data) {
                        self.element.trigger("afterDelete", data.result);
                    }
                }));
            });
            // Esetnapló bejegyzés törlés után lefutó esemény.
            self.element.bind("afterDelete", function(e, success) {
                if (success) {
                    self._addMessage(self._getSelector("feedbackSuccess"), "Sikeresen törölte a bejegyzést!");
                } else {
                    self._addMessage(self._getSelector("feedbackError"), "A bejegyzés törlése sikertelen!");
                }
                $(self._getSelector("deleteDialog")).dialog("close");
                self.element.trigger("refresh");
            });
        }
    });
})( jQuery, window , document );