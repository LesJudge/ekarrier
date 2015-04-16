function dateFilterProcess(data) {
    var $inputs = this.find("input"), 
        $date1 = $($inputs.get(0)), 
        $date2 = $($inputs.get(1)), 
        $match = this.find("select"),
        year = new Date().getUTCFullYear();;
    $inputs.datepicker({
        yearRange: (year - 100) + ":" + year
    });
    $match.change(function() {
        if (this.value === "between") {
            $date2.attr("disabled", false);
            $date2.show();
        } else {
            $date2.attr("disabled", true);
            $date2.hide();
        }
    });
    if (data) {
        if (data.match) {
            $match.val(data.match);
        }
        if (data.date) {
            $date1.val(data.date);
        }
        if (data.date2) {
            $date2.val(data.date2).attr("disabled", false).show();
        }
    }
}