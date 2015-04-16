function educationFilterProcess(data) {
    if (data) {
        var $education = this.find("select[name=\"filter[education][educationId]\"]"),
            $denomination = this.find("input[name=\"filter[education][denomination]\"]"),
            $match = this.find("select[name=\"filter[education][match]\"]")
        if (data.educationId) {
            $education.val(data.educationId);
        }
        if (data.denomination) {
            $denomination.val(data.denomination);
        }
        if (data.match) {
            $match.val(data.match);
        }
    }
}