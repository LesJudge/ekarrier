$(function() {
    $("#clientDynamicFilterDialog").uniwebDynamicFilter({
        activeFilters: activeFilters,
        afterRender: function() {
            this.find("select").uniform();
            this.find("button[data-button-role=\"delete\"]").button({
                icons: {
                    primary: "ui-icon-closethick"
                },
                text: false
            });
        },
        beforeInit: function() {
            this.find("div[data-role=\"filter-label\"] button").button({
                icons: {
                    primary: "ui-icon-plusthick"
                },
                text: false
            });
        },
        filterContainer: "#dynamicFiltersContainer",
        renderFunctions: {
            firstname: textFilterProcess,
            lastname: textFilterProcess,
            email: textFilterProcess,
            motherName: textFilterProcess,
            birthFirstname: textFilterProcess,
            birthLastname: textFilterProcess,
            phoneLandline: textFilterProcess,
            phoneMobile1: textFilterProcess,
            phoneMobile2: textFilterProcess,
            dolgozikCeg: textFilterProcess,
            dolgozikCim: textFilterProcess,
            dolgozikMunkakor: textFilterProcess,
            munkavegzestKorlatozoEgyebOkok: textFilterProcess,
            birthdate: dateFilterProcess,
            mikorRegisztralt: dateFilterProcess,
            gyesGyedLejaratiDatum: dateFilterProcess,
            kovetkezoFelulvizsgalatIdeje: dateFilterProcess,
            palyakezdo: trueOrFalseFilterProcess,
            regisztraltMunkanelkuli: trueOrFalseFilterProcess,
            gyesGyedVisszatero: trueOrFalseFilterProcess,
            megvaltozottMunkakepessegu: trueOrFalseFilterProcess,
            dolgozik: trueOrFalseFilterProcess,
            euProgram: trueOrFalseFilterProcess,
            hazaiProgram: trueOrFalseFilterProcess,
            mobilitastVallal: trueOrFalseFilterProcess,
            kozvetitioAdatbazisbaKivanKerulni: trueOrFalseFilterProcess,
            hozzajarulAMunkakozvetiteshez: trueOrFalseFilterProcess,
            egyMegallProg: trueOrFalseFilterProcess,
            egyMegallKepz: trueOrFalseFilterProcess,
            highestEducation: highestEducationFilterProcess,
            education: educationFilterProcess,
            service: serviceFilterProcess
        }
    });
});