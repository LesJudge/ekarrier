function serviceFilterProcess(data) {
    var year = new Date().getUTCFullYear(),
        $checkboxes = this.find("input[type=\"checkbox\"]"),
        $select = this.find("select"),
        $wantToParticipate = $($checkboxes.get(0)),
        $attended = $($checkboxes.get(1)),
        $when = this.find("input[name=\"filter[service][when]\"]"),
        $whenBetween = this.find("input[name=\"filter[service][whenBetween]\"]");
    this.find("input[type=\"text\"]").datepicker({
        yearRange: (year - 100) + ":" + year
    });
    $select.change(function() {
        if (this.value === "between") {
            $whenBetween.show();
        } else {
            $whenBetween.hide();
        }
    });
    if (data) {
        if (data.want_to_participate && data.want_to_participate === "on") {
            $wantToParticipate.attr("checked", true);
        }
        if (data.attended && data.attended === "on") {
            $attended.attr("checked", true);
        }
        if (data.whenMatch) {
            $select.val(data.whenMatch);
            $select.trigger("change");
        }
        if (data.when) {
            $when.val(data.when);
        }
        if (data.whenBetween) {
            $whenBetween.val(data.whenBetween);
        }
        if (data.serviceId) {
            $select.val(data.serviceId);
        }
    }
}