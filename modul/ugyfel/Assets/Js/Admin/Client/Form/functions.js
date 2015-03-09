function setClientAgeByDate(date) {
    var age = getAge(date), 
        ageStr = "";
    if (!isNaN(age)) {
        ageStr = age + " éves";
    }
    $("#clientAge").val(ageStr);
}

function loadingAddress() {
    var $dialog = $("#dialog-loading");
    $dialog.html("<strong>Címek betöltése...</strong>");
    $dialog.dialog("open");
}

function createOptions(id, name, data) {
    this.find("option").remove();
    this.append("<option value=\"\">--Kérem, válasszon!--</option>");
    var self = this;
    $.each(data, function(index, item) {
        self.append("<option value=\"" + item[id] + "\">" + item[name] + "</option>");
    });
}

function setUniformSelectValue(value) {
    this.val(value);
    this.prev("span").text(this.find("option:selected").text());
}

function findAndSetCitiesByCountryId(countryId) {
    var self = this;
    $.ajax({
        dataType: "json",
        type: "GET",
        url: domain + "modul/cim/api/find/cities/by/country/" + countryId + "/",
        success: function(data) {
            createOptions.call(self, 'city_id', 'city_name', data);
            setUniformSelectValue.call(self, null);
        },
        error: function(xhr) {
            createOptions.call(self, 'city_id', 'city_name', []);
        },
        complete: function() {
            $("#dialog-loading").dialog("close");
        }
    });
}