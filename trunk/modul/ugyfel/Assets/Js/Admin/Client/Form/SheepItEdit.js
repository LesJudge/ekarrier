$(function() {
    // Alap sheepItForm.
    var sheepItBase = {
        separator: "",
        // Selectors.
        addSelector: ".shpt-form-control-add",
        controlsSelector: ".shpt-form-controls",
        noFormsTemplateSelector: ".shpt-form-no-template",
        removeCurrentSelector: ".shpt-form-remove-current",
        // Form options.
        allowRemoveLast: false,
        allowRemoveCurrent: true,
        allowRemoveAll: false,
        allowAdd: true,
        allowAddN: false,
        maxFormsCount: 0,
        minFormsCount: 0,
        iniFormsCount: 0,
        removeCurrentConfirmation: true,
        afterAdd: function(source, newForm) {
            newForm.find(".shpt-form-remove-current").button({
                icons: {
                    primary: "ui-icon-trash"
                },
                text: false
            });
        }
    },
    // Végzettségek sheepItForm.
    educationsSheepIt = $.extend({}, sheepItBase, {
        addSelector: "#educationFormAddBtn",
        controlsSelector: "#educationFormControls",
        formTemplateSelector: ".shpt-form-education",
        noFormsTemplateSelector: "#educationFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        removeCurrentConfirmationMsg: 'Biztos törölni szeretné a végzettséget ?',
        data: educations,
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("select").change(uniformSelectChange);
        }
    }),
    // Nyelvtudás sheepItForm.
    knowledgesSheepIt = $.extend({}, sheepItBase, {
        addSelector: "#knowledgeFormAddBtn",
        controlsSelector: "#knowledgeFormControls",
        formTemplateSelector: ".shpt-form-knowledge",
        noFormsTemplateSelector: "#knowledgeFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        removeCurrentConfirmationMsg: 'Biztos törölni szeretné a nyelvtudást ?',
        data: knowledges,
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("select").change(uniformSelectChange);
        }
    }),
    cknowledgesSheepIt = $.extend({}, sheepItBase, {
        addSelector: "#cKnowledgeFormAddBtn",
        controlsSelector: "#cKnowledgeFormControls",
        formTemplateSelector: ".shpt-form-cknowledge",
        noFormsTemplateSelector: "#cKnowledgeFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        removeCurrentConfirmationMsg: 'Biztos törölni szeretné a számítógépes ismeretet ?',
        data: computerKnowledges,
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
        }
    }),
    addressSheepIt = $.extend({}, sheepItBase, {
        addSelector: "#addressFormAddBtn",
        controlsSelector: "#addressFormControls",
        formTemplateSelector: ".shpt-form-address",
        noFormsTemplateSelector: "#addressFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        removeCurrentConfirmationMsg: 'Biztos törölni szeretné a címet ?',
        data: addresses,
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("select").change(uniformSelectChange);
            newForm.find(".shpt-address-edit-current").button({
                icons: {
                    primary: "ui-icon-pencil"
                },
                text: true
            });
            newForm.find(".shpt-address-edit-current").click(function() {

            });
        }
    }),
    jobSheepIt = $.extend({}, sheepItBase, {
        addSelector: "#jobFormAddBtn",
        controlsSelector: "#jobFormControls",
        formTemplateSelector: ".shpt-form-job",
        noFormsTemplateSelector: "#jobFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        removeCurrentConfirmationMsg: 'Biztos törölni szeretné a munkakört ?',
        data: jobs,
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
        }
    });
    // Végzettségek form.
    $("#educationForm").sheepIt(educationsSheepIt);
    // Nyelvtudás form.
    $("#knowledgeForm").sheepIt(knowledgesSheepIt);
    // Számítógépes ismeretek form.
    $("#cKnowledgeForm").sheepIt(cknowledgesSheepIt);
    // Címek form.
    $("#addressForm").sheepIt(addressSheepIt);
    // Munkakörök.
    $("#jobForm").sheepIt(jobSheepIt);
    // Végzettség adatok helyes megjelenítése.
    if (educations.length > 0) {
        $(".shpt-form-education select").trigger("change");
    }
    // Nyelvtudás adatok helyes megjelenítése.
    if (knowledges.length > 0) {
        $(".shpt-form-knowledge select").trigger("change");
    }
    // Cím adatok helyes megjelenítése.
    if (addresses.length > 0) {
        $(".shpt-form-address select").trigger("change");
    }
    // sheepIt hozzáadása gombok.
    $(".shpt-form-control-add").button({
        icons: {
            primary: "ui-icon-plusthick"
        }
    });
    // Ügyfél információ szerkesztés gombok.
    $(".tab-ugyfel-informacio-btn-tab-edit").button({
        icons: {
            primary: "ui-icon-pencil"
        }
    });
});