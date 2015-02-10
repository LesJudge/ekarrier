;(function ( $, window, document, undefined ) {
    // Create the defaults once
    var pluginName = 'locationFinder',
        defaults = {
            sources: {
                country: [],
                zipCode: [],
                county: [],
                city: []
            },
            itemSelectors: {
                country: null,
                countryId: null,
                zipCode: null,
                zipCodeId: null,
                county: null,
                countyId: null,
                city: null,
                cityId: null
            }
        }

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = $(element);
        // Item-ek.
        this.items = {};
        // Beállítások.
        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {
        init: function() {
            try {
                var self = this;
                $.each(this.options.itemSelectors, function(index, value) {
                    //console.log(index + " - " + value);
                    var $item = self.element.find(value);
                    if ($item.length == 1) {
                        self.items[index] = $item;
                    } else {
                        throw "A/az " + index + " elem nem található!";
                    }
                });
                self.getItem("country").autocomplete({
                    source: self.options.sources.country,
                    change: function ( event, ui ) {
                        console.log("Country change");
                        self.getItem("zipCode").val(null);
                        self.getItem("zipCodeId").val(null);
                        self.getItem("county").val(null);
                        self.getItem("countyId").val(null);
                        self.getItem("city").val(null);
                        self.getItem("cityId").val(null);
                    }
                });
                self.getItem("zipCode").autocomplete({
                    source: self.options.sources.zipCode,
                    change: function ( event, ui ) {
                        console.log("zipCode change");
                    }
                });
            } catch (e) {
                console.warn(e);
            }
        },
        inject: function( data ) {
            console.log(data);
        },
        getItem: function ( name ) {
            if (this.items[name] !== undefined) {
                return this.items[name];
            }
            throw "A/az " + name + " elem nem található!";
        }
    };

    $.fn[pluginName] = function ( options ) {
        var args = arguments;
        if (options === undefined || typeof options === 'object') {
            return this.each(function () {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
                }
            });
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
            var returns;
            this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);
                if (instance instanceof Plugin && typeof instance[options] === 'function') {
                    returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
                }
                if (options === 'destroy') {
                    $.data(this, 'plugin_' + pluginName, null);
                }
            });
            return returns !== undefined ? returns : this;
        }
    };

}(jQuery, window, document));