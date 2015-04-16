$(function() {
    $("#birthdata-birthplace-edit-btn").button({
        create: function(event, ui) {
            var $self = $(event.target);
            $self.click(function() {
                $self.hide();
                $("#birthdata-birthplace-info").hide();
                $("#birthdata-birthplace-edit").show();
                var $country = $("#birthdata-birthplace-country"),
                    $city = $("#birthdata-birthplace-city");
                $country.attr("disabled", false).parent().removeClass("disabled");
                $city.attr("disabled", false).parent().removeClass("disabled");
                $country.change(function() {
                    loadingAddress.call(null);
                    findAndSetCitiesByCountryId.call($city, +this.value);
                });
                loadingAddress.call(null);
                if (clientId === 0) {
                    loadingAddress.call(null);
                    $.ajax({
                        dataType: "json",
                        type: "GET",
                        url: domain + "modul/cim/api/find/countries/",
                        success: function(data) {
                            createOptions.call($country, 'country_id', 'country_name', data);
                            setUniformSelectValue.call($country, null);
                        },
                        error: function(xhr) {
                            alert("Hiba lépett fel a művelet során!");
                        }
                    });
                    findAndSetCitiesByCountryId.call($city, 124);
                } else {
                    $.ajax({
                        dataType: "json",
                        type: "GET",
                        url: DOMAIN_ADMIN + "ugyfel/" + clientId + "/birthplace",
                        success: function(data) {
                            createOptions.call($country, 'country_id', 'country_name', data.countries);
                            createOptions.call($city, 'city_id', 'city_name', data.cities);
                            setUniformSelectValue.call($country, data.country_id);
                            setUniformSelectValue.call($city, data.city_id);
                        },
                        error: function(xhr) {
                            alert("Hiba lépett fel a művelet során!");
                        },
                        complete: function() {
                            $("#dialog-loading").dialog("close");
                        }
                    });
                }
            });
        },
        icons: {
            primary: "ui-icon-pencil"
        }
    });
});