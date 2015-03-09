;(function ( $, window, document, undefined ) {
    "use strict";
    
    var pluginName = "uniwebDynamicFilter",
        defaults = {
            activeFilters: {},
            afterInit: null,
            afterRender: null,
            beforeInit: null,
            filterContainer: "",
            renderFunctions: {}
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
            var self = this,
                activeFilters = this.settings.activeFilters,
                $element = $(this.element);
            // Inicializálás előtt lefutó callback.
            if ($.isFunction(this.settings.beforeInit)) {
                this.settings.beforeInit.call($element);
            }
            // Megvizsgálja, hogy vannak-e aktív szűrők, amiket renderelni kell.
            if (!$.isEmptyObject(activeFilters)) {
                $.each(activeFilters, function (alias, data) { // Bejárja azokat.
                    var $filter = $("script[data-filter-key=\"" + alias + "\"]"); // Szűrő template.
                    if ($filter.length === 1) { // Ha létezik a szűrő template, akkor rendereli.
                        // Elrejti a label-jét.
                        $(self.element).find(
                            "div[data-role=\"filter-label\"][data-filter-key=\"" + $filter.data("filter-key") + "\"]"
                        ).hide();
                        // Rendereli a szűrő template-et.
                        self.render($filter.html(), self.settings.renderFunctions[alias], data);
                    }
                });
            }
            // Megkeresi az elemben található szűrő label-öket.
            $element.find("div[data-role=\"filter-label\"] button").click(function() {
                // A benne található gombra kattintva rendereli a label-höz rendelt szűrőt.
                var $btn = $(this),
                    selector = $btn.data("filter-template-id"),
                    $parent = $btn.parents("div[data-role=\"filter-label\"]");
                $parent.hide();
                self.render($(selector).html(), self.settings.renderFunctions[$parent.data("filter-key")]);
            });
            // Inicializálás után lefutó callback.
            if ($.isFunction(this.settings.afterInit)) {
                this.settings.afterInit.call($element);
            }
        },
        render: function(html, renderFunction, renderData) {
            var self = this, 
                $filter = $(html),
                $deleteBtn = $("<button data-button-role=\"delete\" type=\"button\"></button>");
            $deleteBtn.click(function() {
                var $filter = $(this).parents("div[data-role=\"filter\"]");
                $filter.remove();
                $(self.element).find("div[data-role=\"filter-label\"][data-filter-key=\"" + $filter.data("filter-key") + "\"]").show();
            });
            if ($.isFunction(renderFunction)) {
                var parameter = undefined;
                if (renderData !== undefined && $.isPlainObject(renderData) && !$.isEmptyObject(renderData)) {
                    parameter = renderData;
                }
                renderFunction.call($filter, parameter);
            }
            $deleteBtn.appendTo($filter);
            $filter.appendTo(this.settings.filterContainer);
            if ($.isFunction(this.settings.afterRender)) {
                this.settings.afterRender.call($filter);
            }
        }
    });
    
    $.fn[ pluginName ] = function ( options ) {
        return this.each(function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            }
        });
    };

})( jQuery, window, document );