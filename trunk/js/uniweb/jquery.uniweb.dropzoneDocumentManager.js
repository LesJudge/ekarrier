;(function ( $, window, document, undefined ) {
    $.widget("uniweb.dropzoneDocumentManager", {
        options: {
            deleteUrl: "",
            downloadUrl: "",
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
            },
            readUrl: "",
            uploadUrl: ""
        },
        _addMessage: function(selector, message) {
            //console.log(selector);
            $(selector).html("<p>" + message + "</p>").show();
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
            this._createDeleteBtn(file.nev).appendTo($tr.find("td:nth-child(5)"));
            $tr.appendTo($(this.options.selectors.table).find("tbody"));
        },
        /**
         * Létrehoz egy törlés gombot.
         * @param {Number} id Dokumentum azonosítója.
         * @returns {$}
         */
        _createDeleteBtn: function(id) {
            var ds = this.options.selectors.dialogDelete;
            return $('<button type="button" value="' + id + '">Btn</button>').button({
                create: function(event, ui) {
                    $(this).click(function() {
                        $(ds).data("document-name", this.value).dialog("open");
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
            var self = this,
                url = self.options.downloadUrl.replace("-filename-", filename),
                $button = $('<button type="button">Btn</button>').button({
                create: function(event, ui) {
                    var $element = $(event.target);
                    $element.click(function() {
                        $.ajax({
                            url: url,
                            type: "GET",
                            success: function() {
                                window.location = url;
                            },
                            error: function(xhr) {
                                var message = xhr.responseText && xhr.responseText.length > 0 ? xhr.responseText : "Végzetes hiba történt!";
                                self._addMessage(self.options.selectors.feedbackError, message);
                            }
                        });
                    });
                },
                icons: {
                    primary: "ui-icon-arrowthickstop-1-s"
                },
                text: false
            });
            return $button;
        },
        /**
         * Plugin inicializálása.
         */
        _init: function() {
            var uploadUrl = this.options.uploadUrl,
                uploadSelector = this.options.selectors.btnUpload,
                self = this;
            // Törlés dialógusablak inicializálása.
            $(this.options.selectors.dialogDelete).dialog($.extend({}, this.options.dialogDelete, {
                buttons: {
                    "Törlés": function() {
                        self.element.trigger("delete", $(this).data("document-name"));
                    },
                    "Mégsem": function() {
                        $(this).data("document-name", 0).dialog("close");
                    }
                }
            }));
            // Dropzone inicializálása.
            $(this.options.selectors.dropzone).dropzone({
                addRemoveLinks: true,
                autoProcessQueue: false,
                clickable: false,
                dictRemoveFile: "Törlés",
                method: "post",
                paramName: "file",
                parallelUploads: 10,
                url: uploadUrl,
                init: function() {
                    // Feltöltés befejezése után lefutó esemény.
                    this.on("queuecomplete", function() {
                        self.element.trigger("afterUpload");
                    });
                    // Sikeres fájl feltöltés.
                    this.on("success", function(file) {
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
            self.element.bind("delete", function(e, documentName) {
                $.ajax({
                    data: {
                        "_METHOD": "delete"
                    },
                    success: function(data) {
                        self.element.trigger("afterDelete", data);
                    },
                    error: function(xhr) {
                        self.element.trigger("afterDelete", {
                            message: xhr.responseText && xhr.responseText.length > 0 ? xhr.responseText : "Végzetes hiba!",
                            result: false
                        });
                    },
                    url: self.options.deleteUrl.replace("-filename-", documentName),
                    type: "POST"
                });
            });
            // Dokumentum törlése után lefutó esemény.
            self.element.bind("afterDelete", function(e, data) {
                if (data.result === true) {
                    self._addMessage(self.options.selectors.feedbackSuccess, data.message);
                } else {
                    self._addMessage(self.options.selectors.feedbackError, data.message);
                }
                $(self.options.selectors.dialogDelete).data("document-name", 0).dialog("close");
                self.element.trigger("refresh");
            });
            // Feltöltés esemény.
            self.element.bind("afterUpload", function(e) {
                self._addMessage(self.options.selectors.feedbackInfo, "A feltöltés befejeződött!");
                self.element.trigger("refresh");
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
                        if (data.result === true) {
                            var files = data.files;
                            if (files.length > 0) {
                                $.each(files, function(index, file) {
                                    self._addFile(file);
                                });
                            } else {
                                $tbody.append("<tr><td colspan=\"5\">Nincs megjeleníthető dokumentum!</td></tr>");
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