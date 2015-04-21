;(function ( $, window, document, undefined ) {
    $.widget("uniweb.jobSelect", $.uniweb.clientBaseWidget, {
        options: {
            data: {},
            disableValue: "",
            jobUrl: "munkakor/ajax",
            selectors: {
                idInput: ".job-select-id",
                nameInput: ".job-select-name",
                mainCategory: ".job-select-main",
                subCategory: ".job-select-sub"
            }
        },
        /**
         * Visszatér az AJAX URL-el.
         * @returns {String}
         */
        getAjaxUrl: function() {
            return this._getOption("baseUrl") + this._getOption("jobUrl");
        },
        /**
         * Selector alapján visszatér a kért elemmel, ha az létezik.
         * @param {String} selector Elem selectora.
         * @returns {$|undefined}
         */
        _getElement: function(selector) {
            return this.element.find(this._getSelector(selector));
        },
        /**
         * Feltölti az alkategória selectet.
         * @param {Object|Array} data
         */
        _fillSub: function(data) {
            var $subSelect = this._getElement("subCategory");
            $subSelect.find("option").remove();
            $("<option>--Kérem, válasszon!--</option>").appendTo($subSelect);
            $.each(data, function(key, value) {
                var $option = $("<option></option>");
                $option.val(key);
                $option.text(value);
                $option.appendTo($subSelect);
            });
        },
        inject: function(data) {
            try {
                var isUndefined = function(data) {
                        return data === undefined;
                    },
                    $name = this._getElement("nameInput");
                if ($.isPlainObject(data.subCategories) && !$.isEmptyObject(data.subCategories)) {
                    this._fillSub(data.subCategories);
                } else {
                    throw "Az alkategória érték nem megfelelő!";
                }
                if ($.isArray(data.jobs) && data.jobs.length > 0) {
                    $name.autocomplete("option", "source", data.jobs);
                } else {
                    throw "A munkakör érték nem megfelelő!";
                }
                if (!isUndefined(data.jobId)) {
                    this._getElement("idInput").val(data.jobId);
                } else {
                    throw "Az azonosító értéke nem megfelelő!";
                }
                if (!isUndefined(data.mainId)) {
                    this._getElement("mainCategory").val(data.mainId);
                } else {
                    throw "A főkategória azonosító értéke nem megfelelő!";
                }
                if (!isUndefined(data.subId)) {
                    this._getElement("subCategory").val(data.subId);
                } else {
                    throw "Az alkategória azonosító értéke nem megfelelő!";
                }
                if (!isUndefined(data.name)) {
                    $name.val(data.name);
                } else {
                    throw "A név nem megfelelő!";
                }
            } catch (e) {
                if (console) {
                    console.log(e);
                }
            }
        },
        _init: function() {
            var $id = this._getElement("idInput"),
                $name = this._getElement("nameInput"),
                injectData = this.options.data;
            $name.autocomplete({
                change: function(event, ui) {
                    var value = null;
                    if(ui.item) {
                        value = ui.item.value;
                    }
                    $id.val(value);
                },
                focus: function(event, ui) {
                    event.preventDefault();
                },
                select: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                source: []
            });
            if ($.isPlainObject(injectData) && !$.isEmptyObject(injectData)) {
                this.inject(injectData);
            }
        },
        _create: function() {
            var self = this,
                $mainSelect = this._getElement("mainCategory"),
                $subSelect = this._getElement("subCategory");
            // Change event for main category select.
            $mainSelect.change(function() {
                var disabled = true,
                    mainId = +this.value;
                if (mainId > 0) {
                    $.ajax({
                        async: false,
                        dataType: "json",
                        error: function() {
                            alert("Az alkategóriák lekérdezése sikertelen volt!");
                        },
						method: "GET",
                        success: function(data) {
                            self._fillSub(data);
                        },
                        url: self.getAjaxUrl() + "/filterbymain/" + mainId + "/"
                    });
                    disabled = false;
                } else {
                    alert("A folytatáshoz kötelező főkategóriát választania!");
                }
                $subSelect.attr("disabled", disabled);
            });
            // Change event for sub category select.
            $subSelect.change(function() {
                var $name = self._getElement("nameInput"),
                    subId = +this.value;
                if (subId > 0) {
                    $.ajax({
                        async: false,
                        dataType: "json",
                        error: function() {
                            alert("Az alkategóriák lekérdezése sikertelen volt!");
                        },
                        method: "GET",
                        success: function(data) {
                            $name.autocomplete("option", "source", data);
                        },
                        url: self.getAjaxUrl() + "/filterbysub/" + subId + "/"
                    });
                } else {
                    alert("A munkakör kiválasztásához kötelező alkategóriát választania!");
                    $name.autocomplete("option", "source", []);
                    self._getElement("idInput").val(null);
                }
            });
            /*
            console.log("ready");
            self.element.bind("create", function(e) {
                
            });
            */
        }
    });
})( jQuery, window , document );