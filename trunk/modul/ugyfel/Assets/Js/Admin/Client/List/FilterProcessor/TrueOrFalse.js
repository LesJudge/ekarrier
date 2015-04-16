function trueOrFalseFilterProcess(data) {
    if (data) {
        if (data.match) {
            this.find("select").val(data.match);
        }
    }
}