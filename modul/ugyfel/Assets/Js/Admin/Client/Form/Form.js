$(function() {
    // Kattintásra rejtse el a flash-t.
    $("#flash-error, #flash-info, #flash-success").click(function() {
        $(this).fadeOut(1000);
    });
    
    // Betöltés dialógus ablak.
    $("#dialog-loading").dialog({
        autoOpen: false,
        draggable: false,
        height: 300,
        modal: true,
        resizable: false,
        width: 500
    });
    
    var currentYear = new Date().getUTCFullYear(), // Aktuális év.
        datepickers = [ // Selectorokat tartalmazó tömb, amikre datepicker kell.
            "#labor-market-gyes-gyed-lejar-datum", 
            "#labor-market-kov-felulv-date", 
            ".uw-ugyfelkezelo-service-mikor"
        ],
        datepickerSettings = { // Datepicker alapértelmezett beállítása a formon.
            yearRange: (currentYear - 100) + ":" + currentYear
        };
        
    // Születési idő datepicker inicializálása, érték változásakor írja át az ügyfél korát a szomszédos input mezőben.
    var $birthDate = $("#clientBirthDataSzuletesiIdo").datepicker($.extend({}, datepickerSettings, {
        onClose: function() {
            setClientAgeByDate(this.value);
        }
    }));
    
    // Ügyfél korának megjelenítése.
    setClientAgeByDate($birthDate.val());
    
    // Datepicker-ek inicializálása.
    $(datepickers.join()).datepicker(datepickerSettings);
    
    // Nem engedélyezett szolgáltatás input-ok engedélyezése, ha a user kiválaszt egy szolgáltatást.
    $(".uw-ugyfelkezelo-service-option-checkbox").click(function() {
        var $self = $(this), 
            $parent = $self.parents(".parent-item"), 
            checked = $parent.find("input:checkbox:checked").length;
        $parent.find(".disable-on-unchecked").attr("disabled", checked === 0);
        $self.val($self.attr("checked") ? 1 : 0);
    });
    
    // Nem engedélyezett program információ, munkarend input-ok engedélyezése, ha a user kiválasztja valamelyiket.
    $(".program-information-checkbox, .workschedule-checkbox").click(function() {
        var $self = $(this), 
            $items = $self.parents(".parent-item").find(".disable-on-unchecked");
        $items.attr("disabled", !$self.attr("checked"));
    });
    
    // "Dummy" hibaüzenet elrejtése.
    $(".shpt-form-error:contains('shpt-form-error-dummy')").hide();
    
    // SheepIt hibaüzenetek megjelenítése, ha vannak.
    $.each($(".shpt-form-row"), function(index, item) {
        var $item = $(item).find("input[id$=\"_error\"][type=\"hidden\"]"),
            errorMessage = $item.val();
        if (errorMessage !== undefined && errorMessage.length > 0) {
            $item.next(".shpt-form-error").html(errorMessage).show();
        }
    });

    // Hibás tabok megjelölése.
    var $clientTabs = $('#ugyfel-edit-tabs');
    var tabs = $clientTabs.find('div[id^="tab"]');

    $.each(tabs, function(index, item) {
            // Kiválasztja a jelenlegi tab-ot.
            var $tab = $(item);

            // Ha van bármilyen div ui-state-error class-szal, az azt jelenti, hogy van hibás adat.
            var hasError = $tab.find('div.ui-state-error').length > 0;

            // Kiválvasztja az összes sheep it form sort.
            var sheepItRows = $tab.find('.shpt-form-row');

            // Ha eddig nicns hiba, akkor bejárja a sheepit form sorokat hibaüzenet után kutatva.
            if (!hasError) {
                $.each(sheepItRows, function(index, item) {
                    // Hibaüzenetet tartalmazó hidden input.
                    var $item = $(item).find("input[id$=\"_error\"][type=\"hidden\"]");
                    // Hibaüzenet.
                    var errorMessage = $item.val();

                    // Van hiba, kilép a ciklusból.
                    if (errorMessage !== undefined && errorMessage.length > 0) {
                        hasError = true;
                        return false;
                    }
                });
            }

        if (hasError) {
            $clientTabs.find('li a[href=#' + $tab.attr('id') + ']').css({'color': 'red'});
        }
    });
});