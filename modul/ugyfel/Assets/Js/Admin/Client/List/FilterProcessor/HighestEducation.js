function highestEducationFilterProcess(data) {
    if (data) {
        if (data.educationId) {
            this.find("select").val(data.educationId);
        }
    }
}