;(function($) {

    $.uwLocationFinder = function(zipCodeInput, options) {

        var defaults = {};

        var plugin = this;

        plugin.settings = {};

        /**
         * Inicializálja a plugint.
         */
        var init = function() {
            plugin.settings = $.extend({}, defaults, options); // Beállítja a plugin példányváltozóinak értékét.
            plugin.zipCodeInput = zipCodeInput; // Beállítja az irányítószámot tároló mezőt.
            try {
                plugin.zipCodeIdInput = setObjectAttribute(options.zipCodeIdInput);
                //plugin.shireSelect = setObjectAttribute(options.shireSelect); // Beállítja a megyét tároló selectet.
                plugin.shireInput = setObjectAttribute(options.shireInput); // Beállítja a megyét tároló selectet.
                plugin.cityInput = setObjectAttribute(options.cityInput); // Beállítja a város nevét tároló mezőt.
                if (options.cityIdInput) {
                    plugin.cityIdInput = setObjectAttribute(options.cityIdInput);
                }
                plugin.getShireInput().attr("readonly", "readonly"); // Tiltja a selectet.
                plugin.getCityInput().attr("readonly", "readonly"); // Readonly-vá teszi a város input mezőt.
                $(plugin.getZipCodeInput()).autocomplete({
                    minLength: 2,
                    source: options.ajaxUrl,
                    select: function(event, ui) {
                        var item = ui.item;
                        $(this).val(item.iranyitoszam);
                        plugin.getZipCodeIdInput().val(item.cim_iranyitoszam_id);
                        //plugin.getShireSelect().val(item.cim_megye_id);
                        plugin.getShireInput().val(item.megye);
                        plugin.getCityInput().val(item.varos);
                        if (options.cityIdInput) {
                            plugin.getCityIdInput().val(item.cim_varos_id);
                        }
                        return false;
                    },
                    change: function(event, ui) {
                        if (!ui.item || !ui.item.label || !ui.item.value) {
                            plugin.getZipCodeIdInput().val(null);
                            plugin.getShireInput().val(null);
                            plugin.getCityInput().val(null);
                            if (options.cityIdInput) {
                                plugin.getCityIdInput().val(null);
                            }
                        }
                        return false;
                    }
                });
            }
            catch (error)
            {
                console.log(error);
            }
        };

        /**
         * Visszatér az irányítószámot tároló input objecttel.
         * @returns {@exp;plugin@pro;zipCodeInput}
         */
        plugin.getZipCodeInput = function() {
            return plugin.zipCodeInput;
        };

        plugin.getZipCodeIdInput = function() {
            return plugin.zipCodeIdInput;
        };

        /**
         * Visszatér a megyét tároló select objecttel.
         * @returns {@exp;plugin@pro;shireSelect}
         */
        plugin.getShireSelect = function() {
            return plugin.shireSelect;
        };

        /**
         * Visszatér a megyét tároló select objecttel.
         * @returns {@exp;plugin@pro;shireInput}
         */
        plugin.getShireInput = function() {
            return plugin.shireInput;
        };

        /**
         * Visszatér a város nevét tartalmazó input objecttel.
         * @returns {@exp;plugin@pro;cityInput}
         */
        plugin.getCityInput = function() {
            return plugin.cityInput;
        };

        /**
         * Visszatér a város azonosítót tároló input objecttel.
         * @returns {@exp;plugin@pro;cityIdInput}
         */
        plugin.getCityIdInput = function() {
            return plugin.cityIdInput;
        };

        /**
         * @param {string} objId Objektum azonosítója.
         */
        var setObjectAttribute = function(objId) {
            var object = $(objId);
            if (object.length === 1) {
                return object;
            }
            else {
                throw "Nem létezik az elem! (" + objId + ")";
            }
        };

        init();

    };

})(jQuery);