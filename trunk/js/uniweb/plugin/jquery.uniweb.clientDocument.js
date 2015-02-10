;(function ( $, window, document, undefined ) {
    $.widget("uniweb.clientDocument", $.uniweb.clientBaseWidget, {
        options: {
            baseUrl: "",
            clientId: 0,
            documentsUrl: "",
            dataDocumentId: "",
            dialogDelete: {},
            selectors: {
                btnUpload: "",
                dialogDelete: "",
                dropzone: "",
                feedbackError: "",
                feedbackInfo: "",
                feedbackSuccess: "",
                fatalError: "",
                table: ""
            }
        },
        /**
         * Visszatér az AJAX kéréshez szükséges URL-lel.
         * @returns {String}
         */
        getAjaxUrl: function() {
            return this._getOption("baseUrl") + this._getOption("documentsUrl");
        },
        /**
         * Visszatér az ügyfél azonosítóval.
         * @returns {Number}
         */
        getClientId: function() {
            return this._getOption("clientId");
        },
        /**
         * Hozzáad egy fájlt a táblázathoz.
         * @param {Object} file
         */
        _addFile: function(file) {
            var $tr = $("<tr></tr>"), // Létrehoz egy új <tr> elemet.
                // Létrehozá egy új Date objektumot (feltöltés ideje)
                uploadedDate = new Date(file.letrehozas_timestamp),
                dateStr = uploadedDate, // Dátum string, ezt jeleníti majd meg.
                tds = ""; // <td> TAG-ek.
            /**
             * Warning:
             * Az uwGetFormattedDate() és uwGetFormattedTime() metódusok csak akkor elérhetőek a Date objektum 
             * esetében, ha az uniweb.prototype.js fájl be van töltve!
             */
            if ($.isFunction(uploadedDate.uwGetFormattedDate) && $.isFunction(uploadedDate.uwGetFormattedTime)) {
                dateStr = uploadedDate.uwGetFormattedDate() + " " + uploadedDate.uwGetFormattedTime();
            }
            // Elkészíti a táblázat oszlopait.
            tds += "<td>" + file.dokumentum_nev  + "</td>";
            tds += "<td>" + dateStr + "</td>";
            tds += "<td>" + file.user_vnev + " " + file.user_knev + " " + "(" + file.user_fnev + ")" + "</td>";
            tds += "<td></td><td></td>";
            // Az oszlopkat elhelyezi a sorban.
            $(tds).appendTo($tr);
            // Létrehoz egy letöltés gombot, majd az utolsó előtti oszlopba teszi azt.
            this._createDownloadBtn(file.nev).appendTo($tr.find("td:nth-child(4)"));
            // Létrehoz egy törlés gombot, majd az utolsó oszlopba teszi azt.
            this._createDeleteBtn(file.ugyfel_attr_dokumentum_id).appendTo($tr.find("td:nth-child(5)"));
            $tr.appendTo($(this._getSelector("table")).find("tbody"));
        },
        /**
         * Létrehoz egy törlés gombot.
         * @param {Number} id Dokumentum azonosítója.
         * @returns {$}
         */
        _createDeleteBtn: function(id) {
            var ddId = this._getOption("dataDocumentId"),
                ds = this._getSelector("dialogDelete");
            return $("<button type=\"button\" value=\"" + id + "\"></button>").button({
                create: function(event, ui) {
                    $(this).click(function() {
                        $(ds).data(ddId, +this.value).dialog("open");
                    });
                },
                icons: {
                    primary: "ui-icon-trash"
                },
                text: false
            });
        },
        /**
         * Létrehoz egy letöltés gombot.
         * @param {String} filename Fájl neve.
         * @returns {$}
         */
        _createDownloadBtn: function(filename) {
            return $("<a href=\"" + this.getAjaxUrl() + "?method=download&filename=" + filename + 
                    "\" target=\"_blank\"></a>").button({
                icons: {
                    primary: "ui-icon-arrowthickstop-1-s"
                },
                text: false
            });
        },
        /**
         * Plugin inicializálása.
         */
        _init: function() {
            var ajaxUrl = this.getAjaxUrl(),
                clientId = this.options.clientId,
                ddId = this._getOption("dataDocumentId"),
                uploadSelector = this._getSelector("btnUpload"),
                self = this;
            // Kattintásra rejtse el a feedback-et.
            this._bindMessageClick();
            // Törlés dialógusablak inicializálása.
            $(this._getSelector("dialogDelete")).dialog($.extend({}, this._getOption("dialogDelete"), {
                buttons: {
                    "Törlés": function() {
                        self.element.trigger("delete", $(this).data(ddId));
                    },
                    "Mégsem": function() {
                        $(this).data(ddId, 0).dialog("close");
                    }
                }
            }));
            // Dropzone inicializálása.
            $(this._getSelector("dropzone")).dropzone({
                addRemoveLinks: true,
                autoProcessQueue: false,
                clickable: false,
                dictRemoveFile: "Törlés",
                method: "post",
                paramName: "file",
                parallelUploads: 10,
                url: ajaxUrl,
                init: function() {
                    // Szükséges rejtett inputok hozzáadása a formhoz.
                    $("<input name=\"method\" value=\"upload\" type=\"hidden\" />").appendTo(this.element);
                    $("<input name=\"clientId\" value=\"" + clientId + "\" type=\"hidden\" />").appendTo(this.element);
                    // Feltöltés befejezése után lefutó esemény.
                    this.on("queuecomplete", function() {
                        self.element.trigger("afterUpload");
                    });
                    // Sikeres fájl feltöltés.
                    this.on("success", function(file) {
                        //console.log("Fájl feltöltés kész.");
                        this.removeFile(file);
                    });
                    // Hibás fájl feltöltés.
                    //this.on("error", function(file, data, xhr) {
                    //    console.log("Hiba!");
                    //});
                    var dz = this;
                    // Feltöltés gomb inicializálása.
                    $(uploadSelector).button({
                        create: function() {
                            $(this).click(function() {
                                dz.processQueue();
                            });
                        },
                        icons: {
                            primary: "ui-icon-arrowthickstop-1-n"
                        }
                    });
                }
            });
        },
        _create: function() {
            var self = this;
            // Dokumentum törlés esemény.
            self.element.bind("delete", function(e, documentId) {
                $.ajax({
                    data: {
                        documentId: documentId,
                        method: "delete"
                    },
                    dataType: "json",
                    success: function(data) {
                        self.element.trigger("afterDelete", data);
                    },
                    url: self.getAjaxUrl(),
                    type: "POST"
                });
            });
            // Dokumentum törlése után lefutó esemény.
            self.element.bind("afterDelete", function(e, data) {
                if (data.result === true) {
                    self._addMessage(self._getSelector("feedbackSuccess"), data.message);
                } else {
                    self._addMessage(self._getSelector("feedbackError"), data.message);
                }
                $(self._getSelector("dialogDelete")).data(self._getOption("dataDocumentId"), 0).dialog("close");
                self.element.trigger("refresh");
            });
            // Feltöltés esemény.
            self.element.bind("afterUpload", function(e) {
                self._addMessage(self._getSelector("feedbackInfo"), "A feltöltés befejeződött!");
                self.element.trigger("refresh");
            });
            // Refresh esemény.
            self.element.bind("refresh", function(e) {
                var $tbody = $(self._getSelector("table")).find("tbody");
                $tbody.html(null);
                $.ajax({
                    data: {
                        clientId: self.getClientId(),
                        method: "refresh"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.result === true) {
                            var files = data.files;
                            if (files.length > 0) {
                                $.each(files, function(index, file) {
                                    self._addFile(file);
                                });
                            } else {
                                $tbody.append("<tr><td colspan=\"5\">Nincs megjeleníthető dokumentum!</td></tr>");
                            }
                        } else {
                            self._fatalError();
                        }
                    },
                    url: self.getAjaxUrl(),
                    type: "GET"
                });
            });
        }
    });
})( jQuery, window , document );