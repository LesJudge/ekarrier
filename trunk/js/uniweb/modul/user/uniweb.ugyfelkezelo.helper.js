function initParticipationCheckboxes(source, newForm, index, rindex) {
    var formData = source.getOption('data')[index], 
        $resztvett = newForm.find("input[id$=\"_resztvett\"]"),
        $fake = newForm.find(".fake-resztvett");
    $fake.click({ whenField: newForm.find(".mikor-field") }, function(event) {
        var whenField = event.data.whenField, $input = whenField.find("input[type=\"text\"]");
        if ($(this).attr("checked")) {
            whenField.show();
            $resztvett.val(1);
            $input.rules("add", {dateISO: true});
            $input.datepicker();
            $(this).parent("span").addClass("checked");
        } else {
            whenField.hide();
            $resztvett.val(0);
            whenField.find("input").rules("remove");
            $input.datepicker("destroy");
            $(this).parent("span").removeClass("checked");
        }
    });
    if (typeof formData == "object") {
        var value = formData[rindex];
        $resztvett.val(value);
        if (value) {
            $fake.attr("checked", true);
            $fake.trigger("click");
            $fake.attr("checked", true);
        }
    } else {
        $resztvett.val(0);
    }
}

function acBaseChange(event, ui) {
    var label = null, value = null;
    if(ui.item) {
        label = ui.item.label;
        value = ui.item.value;
    }
    $(this).parent("div").next().find("input[id$=\"_id\"]").val(value);
    this.value = label;
}

function sheepItNmAcBaseChange(event, ui) {
    acBaseChange.apply(this, [event, ui]);
    var $idRow = $(this).parents(".shpt-form-row").next(".shpt-form-row");
    if ($idRow.length == 1) {
        var $idField = $idRow.find("input[id$=\"_id\"]");
        if ($idField.length == 1) {
            $idRow.find("div." + $("#" + formName).data('validator').settings.errorClass).remove();
        }
    }
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function ageToString(age) {
    if (!isNaN(age)) {
        return age + " éves";
    }
    return "";
}

function setClientAgeByDate(date) {
    $("#clientAge").val(ageToString(getAge(date)));
}