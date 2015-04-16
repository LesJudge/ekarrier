function textFilterProcess(data) {
    if (data) {
        if (data.text) {
            this.find("input").val(data.text);
        }
        if (data.match) {
            this.find("select").val(data.match);
        }
    }
}