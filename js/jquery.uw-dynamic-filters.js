;(function ( $, window, document, undefined ) {
    var pluginName = 'uwDynamicFilters',
        defaults = {
            activeFilters: [],
            // Selectors
            addBtnSelector: ".uw-df-filters-btn-dialog-open",
            containerSelector: ".uw-df-filters-container",
            dialogSelector: ".uw-df-dialog",
            viewSelector: "script[type=\"text/html\"]",
            // Classes
            viewListClass: "uw-df-list",
            viewListItemClass: "uw-df-li",
            viewListNoneClass: "uw-df-list-none",
            // Options
            dialogSettings: {},
            // Tags
            viewListTag: "ul",
            viewListItemTag: "li",
            viewListNoneTag: "div",
            // Callbacks
            filterCallbacks: {
                // Example code:
                /*
                uwDynamicFilterViewBirthdate: {
                    afterAdd: function($filter) {
                        // Do something after filter added.
                    },
                    afterRemove: function() {
                        // Do something after filter removed.
                    },
                    beforeAdd: function() {
                        // Do something before filter added.
                    },
                    beforeRemove: function($filter) {
                        // Do something before filter removed.
                    },
                    initialize: function($filter) {
                        // Do something here.
                    }
                }
                */
            }
        };
    // Constructor.
    function Plugin( element, options ) {
        this.element = element;
        this.options = $.extend( {}, defaults, options) ;
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var self = this,
                $dialog = $(this.options.dialogSelector),
                createTag = function(tagName) {
                    return $("<" + tagName + ">");
                };
            try {
                var $views = this.getViews(),
                    $list = createTag(this.getViewListTag()).addClass(this.options.viewListClass),
                    $filterNone = createTag(self.options.viewListNoneTag).addClass(self.options.viewListNoneClass).text(
                        "Nincs megjeleníthető szűrő!"
                    ).hide();
                $dialog.html($list); // Lista hozzáadása a dialógusablakhoz.
                $filterNone.appendTo($dialog);
                $.each($views, function(index, view) {
                    var $view = $(view), // Nézet kiválasztása.
                        data = view.dataset, // Nézet data attribútumai.
                        $listItem = createTag(self.getViewListItemTag()), // Lista elem létrehozása.
                        $addBtn = createAddBtn(data.uwDynamicFilterView, self); // Hozzáadás gomb létrehozása.
                    // Lista elem hozzáadása a listához.
                    //$listItem.addClass(self.options.viewListItemClass).text(data.uwDynamicFilterName).appendTo($list);
                    $listItem.addClass(self.options.viewListItemClass);
                    $("<div title=\"" + data.uwDynamicFilterName + "\">" + data.uwDynamicFilterName + "</div>").appendTo($listItem);
                    $addBtn.appendTo($listItem); // Hozzáadás gomb hozzáadása a lista elemhez.
                    $listItem.appendTo($list);
                    if(validateView($view)) { // Nézet validálása.
                        if(self.isActive(data.uwDynamicFilterItem)) { // Ha a szűrő aktív.
                            $addBtn.trigger("click");
                        }
                    }
                });
                // Ha enter-t nyom valamelyik input fókuszakor, akkor küldje el a formot.
                $(this.element).find("input").live("keypress", function(e) {
                    if(e.which == 13) {
                        e.preventDefault();
                        $(this).closest("form").submit();
                    }
                });
            } catch(error) {
                console.error(error); // Ha bármilyen hiba történik, akkor azt a konzolban logolja.
            }
            // Hozzáadás gomb inicializálása.
            $(this.options.addBtnSelector).button({
                create: function(event, ui) {
                    $(event.target).bind("click", function() {
                        $dialog.dialog("open");
                    });
                },
                icons: {
                    primary: "ui-icon-plusthick"
                }
            });
            // Dialógus ablak inicializálása.
            $(this.options.dialogSelector).dialog(this.options.dialogSettings);
        },
        /**
         * @description Visszatér a plugin filter container elemével.
         * @returns {$}
         */
        getContainer: function() {
            return $(this.element).find(this.options.containerSelector);
        },
        /**
         * @description Visszatér a plugin dialógus ablakával.
         * @returns {$}
         */
        getDialog: function() {
            return $(this.options.dialogSelector);
        },
        /**
         * @description Visszatér a nézet listát tartalmazó TAG-gel.
         * @returns {String}
         */
        getViewListTag: function() {
            return this.options.viewListTag;
        },
        /**
         * @description Visszatér a nézet lista elemet tartalmazó TAG-gel.
         * @returns {String}
         */
        getViewListItemTag: function() {
            return this.options.viewListItemTag;
        },
        /**
         * @description Visszatér a plugin-hoz tartozó nézetekkel.
         * @returns {Object}
         */
        getViews: function() {
            return $(this.element).find(this.options.viewSelector);
        },
        /**
         * Megvizsgálja, hogy a paraméterül adott item aktív-e.
         * @param {String} item Nézet azonosító.
         * @returns {Boolean}
         */
        isActive: function(item) {
            return this.options.activeFilters.indexOf(item) < 0 ? false : true;
        },
        /**
         * Megjeleníti vagy elrejti a nézethez tartozó lista elemet a dialógusablakban.
         * @param {String} view A nézet azonosítjója.
         * @param {String} action A metódus neve (show vagy hide).
         * @returns {void}
         */
        showHideFilterBtn: function(view, action) {
            if(view !== undefined && (action === "show" || action === "hide")) {
                var $item = this.getDialog(). // Visszatér a dialógus ablakkal.
                            find("." + this.options.viewListClass). // Megkeresi benne a lista TAG-et.
                            find("." + this.options.viewListItemClass). // Abban a lista elem TAG-et.
                            find("button[data-uw-dynamic-filter-view=\"" + view + "\"]"). // Abban a keresett elem gombját.
                            parent(), // Majd visszatér a lista elemmel.
                    $listNone = this.getDialog().find("." + this.options.viewListNoneClass);
                if(action === "show") {
                    $listNone.hide();
                    $item.show();
                } else {
                    $item.hide();
                    if (this.getDialog().find("." + this.options.viewListItemClass + ":visible").length == 0) {
                        $listNone.show();
                    }
                }                
            } else {
                throw "A nézet megadása kötelező, valamint az action paraméter értéke csak show vagy hide lehet!";
            }
        },
        /**
         * Megjeleníti a nézethez tartozó lista elemet a dialógus ablakban.
         * @param {String} view Nézet azonosító.
         * @returns {void}
         */
        showFilterBtn: function(view) {
            this.showHideFilterBtn(view, "show");
        },
        /**
         * Elrejti a nézethez tartozó lista elemet a dialógus ablakban.
         * @param {String} view Nézet azonosító.
         * @returns {void}
         */
        hideFilterBtn: function(view) {
            this.showHideFilterBtn(view, "hide");
        }
    };
    /**
     * Létrehoz egy gombot a megadott paraméterekkel.
     * @param {Object} properties Gomb attribútumait tartalmazó objektum (kulcs-érték párok).
     * @param {Object} buttonOptions button() metódus paramétere.
     * @returns {$}
     */
    var createBtn = function(properties, buttonOptions) {
        var $btn = $("<button>"); // Létrehoz egy button elemet.
        $.each(properties, function(index, item) {
            $btn.attr(index, item); // Beállítja az attribútumait a paraméterül kapott objektumból.
        });
        $btn.attr("type", "button"); // "button" típusúvá alakítja.
        if(buttonOptions instanceof Object) { // Ha a buttonOptions paraméter egy valid Js objektum.
            $btn.button(buttonOptions); // Akkor inicializálja a gombot a kapott paraméterek alapján.
        }
        return $btn;
    };
    /**
     * Létrehoz egy hozzáadás gombot. A createBtn shorthand metódusa.
     * @param {String} viewId Nézet azonosító.
     * @param {Plugin} plugin Plugin objektum.
     * @returns {$}
     */
    var createAddBtn = function(viewId, plugin) {
        return createBtn({
            // Class beállítása.
            class: "uw-df-li-btn-add",
            // Nézet beállítása, ebből lehet tudni, hogy melyik nézetre hivatkozik.
            'data-uw-dynamic-filter-view': viewId
        }, {
            create: function(event, ui) {
                $(event.target).click(function() { // Gombra kattintva lefutó esemény.
                    var viewId = this.dataset.uwDynamicFilterView,
                        $view = $(plugin.element).find(
                            plugin.options.viewSelector + "[data-uw-dynamic-filter-view=\"" + viewId + "\"]"
                        );
                    renderView(plugin, $view);
                    plugin.hideFilterBtn(viewId);
                });
            },
            icons: {
                primary: "ui-icon-plusthick"
            },
            text: false
        });
    };
    /**
     * Létrehoz egy eltávolítás gombot. A createBtn shorthand metódusa.
     * @param {String} viewId Nézet azonosító.
     * @param {Plugin} plugin Plugin objektum.
     * @returns {$}
     */
    var createRemoveBtn = function(viewId, plugin) {
        return createBtn({
            class: "uw-df-li-btn-remove", // Class beállítása.
            'data-uw-dynamic-filter-view': viewId // Nézet beállítása, ebből lehet tudni, hogy melyik filtert kell eltávolítania.
        }, {
            create: function(event, ui) {
                $(event.target).click(function() { // Gombra kattintva lefutó esemény.
                    // Container-ben megkeresi az adott nézetet.
                    var viewId = this.dataset.uwDynamicFilterView,
                        $view = plugin.getContainer().find("#" + viewId);
                    if($view.length === 1) { // Ha a nézet létezik.
                        executeCallback(plugin, viewId, "beforeRemove", $view);
                        $view.remove(); // Akkor eltávolítja azt.
                        plugin.showFilterBtn(viewId); // Megjeleníti a hozzáadás gombot.
                        executeCallback(plugin, viewId, "afterRemove", $view);
                    }
                });
            },
            icons: {
                primary: "ui-icon-minusthick"
            },
            text: false
        });
    };
    /**
     * Végrehajtja a callback-et.
     * @param {Plugin} self Plugin objektum.
     * @param {String} view Nézet azonosító.
     * @param {String} name Callback neve.
     * @param {Mixed} argument Callback paramétere (opcionális)
     * @returns {void}
     */
    var executeCallback = function(self, view, name, argument) {
        if(
            self.options.filterCallbacks[view] !== undefined
            &&
            $.isFunction(self.options.filterCallbacks[view][name])
        ) {
            if(argument === undefined) {
                self.options.filterCallbacks[view][name].call(this);
            } else {
                self.options.filterCallbacks[view][name].call(this, argument);
            }
        }
    };
    /**
     * Rendereli a paraméterül adott nézetet.
     * @param {Plugin} self Plugin objektum.
     * @param {$} $view View jQuery objektum.
     * @returns {void}
     */
    var renderView = function(self, $view) {
        var $template = $($view.get(0).outerText), // Template.
            viewId = $view.data("uw-dynamic-filter-view"), // Nézet azonosító.
            $removeBtn = createRemoveBtn(viewId, self); // Létrehozza az eltávolítás gombot.
        $template.attr("id", viewId); // Beállítja a template ID-t.
        executeCallback(self, viewId, "beforeAdd"); // Végrehajtja a beforeAdd callback-et.
        $removeBtn.appendTo($template); // A gombot hozzáadja a template-hez.
        executeCallback(self, viewId, "initialize", $template); // Inicializálja a filter-t.
        if ($template.hasClass("uw-df-filter-radio") || $template.hasClass("uw-df-filter-checkbox")) {
            $template.find("input:radio, input:checkbox").uniform();
        }
        $template.appendTo(self.getContainer()); // A filter hozzáadása.
        executeCallback(self, viewId, "afterAdd", $template); // Végrehajtja az afterAdd callback-et.
    };
    /**
     * Megvizsgálja, hogy a nézet megfelelő-e.
     * @param {Object} $view Nézet objektum.
     * @returns {Boolean}
     */
    var validateView = function($view) {
        /** @type Object */
        var viewData = $view.data(),
            /**
             * Megvizsgálja, hogy megfelelő-e az attribútum értéke.
             * @param {String} value Az attribútum értéke.
             * @param {String} attribute Az attribútum neve.
             * @returns {Boolean}
             */
            validate = function(value, attribute) {
                if(value === undefined || value.length < 2) {
                    throw "A nézet " + attribute + " attribútuma hiányzik, vagy nem megfelelő!";
                } else {
                    return true;
                }
            };
        return validate(viewData["uw-dynamic-filter-view"], "data-uw-dynamic-filter-view")
               &&
               validate(viewData["uw-dynamic-filter-name"], "data-uw-dynamic-filter-name")
               &&
               validate(viewData["uw-dynamic-filter-item"], "data-uw-dynamic-filter-item");
    };

    $.fn[ pluginName ] = function ( options ) {
        this.each(function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            }
        });
        // chain jQuery functions
        return this;
    };
    
}(jQuery, window, document));