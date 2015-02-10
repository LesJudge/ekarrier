var locationIdPrefix = "clientDataLakcim",
    locationNamePrefix = "lakcim",
    birthplaceIdPrefix = "clientDataSzhely",
    birthplaceNamePrefix = "szhely",
    // sheepItForm base configuration.
    sheepItBase = {
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
        afterAdd: function(source, newForm) {
            newForm.find(".shpt-form-remove-current").button({
                icons: {
                    primary: "ui-icon-trash"
                },
                text: false
            });
        }
    },
    // jQueryUI Autocomplete base configuration.
    acBase = {
        change: acBaseChange,
        focus: uiAutoCompleteFocus,
        select: uiAutoCompleteSelect
    };

$(function() {
    $("#lakcim-varos-nev, #szhely-varos-nev").autocomplete({
        minLength: 2,
        setValue: function(value, event, ui) {
            var elementId = $(this).attr("id"),
                isLocation = elementId == "lakcim-varos-nev",
                idPrefix = isLocation ? locationIdPrefix : birthplaceIdPrefix,
                namePrefix = isLocation ? locationNamePrefix : birthplaceNamePrefix,
                location = {
                    city_id: null,
                    city_name: null,
                    county_id: null,
                    county_name: null,
                    zip_code: null,
                    zip_code_id: null
                };
            if ($.isPlainObject(ui.item)) {
                location = {
                    city_id: value,
                    city_name: ui.item.label,
                    county_id: ui.item.county_id,
                    county_name: ui.item.county_name,
                    zip_code: ui.item.zip_code,
                    zip_code_id: ui.item.zip_code_id
                };
            }
            setLocationValues(idPrefix, namePrefix, location);
        },
        change: uiAutoCompleteChange,
        focus: uiAutoCompleteFocus,
        select: uiAutoCompleteSelect,
        source: cities
    });
    // Ha létezik az ügyfél.
    if (!isNewClient) {
        // Dropzone AutoDiscover letiltása.
        Dropzone.autoDiscover = false;
        // Esetnapló inicializálása.
        $("#client-contact").clientContact({
            baseUrl: domainAdmin,
            contactsUrl: "ugyfel/esetnaplo",
            clientId: clientId,
            dataContactId: "contact-id",
            dialogCreate: {
                autoOpen: false,
                height: 600,
                modal: true,
                width: 800
            },
            dialogDelete: {
                autoOpen: false,
                modal: true
            },
            useTinyMCE: true,
            selectors: {
                addButton: "#client-contact-add-btn",
                createDialog: "#client-contact-dialog-create",
                deleteDialog: "#client-contact-dialog-delete",
                fatalError: "#client-contact-fatal-error",
                feedbackError: "#client-contact-error",
                feedbackSuccess: "#client-contact-success",
                formError: "#contact-dialog-dialog-create-error",
                inputContactDate: "#cc-create-felvetel-ideje",
                inputComment: "#cc-create-megjegyzes",
                inputTypeId: "#cc-create-esetnaplo-tipus-id",
                table: "#client-contact-table"
            }
        });
        // Dokumentumkezelő inicializálása.
        $("#client-document").clientDocument({
            baseUrl: domainAdmin,
            clientId: clientId,
            documentsUrl: "ugyfel/dokumentum",
            dataDocumentId: "document-id",
            dialogDelete: {
                autoOpen: false,
                height: 200,
                modal: true,
                width: 450
            },
            selectors: {
                btnUpload: "#client-document-btn-upload",
                dialogDelete: "#client-document-dialog-delete",
                dropzone: "#client-document-dropzone",
                fatalError: "#client-document-fatal-error",
                feedbackError: "#client-document-feedback-error",
                feedbackInfo: "#client-document-feedback-info",
                feedbackSuccess: "#client-document-feedback-success",
                table: "#client-document-table"
            }
        });
        // Ez azért kell ide, hogy hiba nélkül lefusson a kliens oldali validáció. A validate plugin nem szereti, ha
        // <form>-ban <form> van, ami ugye nem is helyes, de jelen esetben nem igazán volt más járható út.
        $("#client-document-dropzone").validate({
            rules: {
                "method": {
                    "required": false
                }
            }
        });
        // TinyMCE beállítások felülírása.
        tinyMCE.init({
            mode : "exact",
            elements : this.id,
            theme : "advanced",
            skin : "o2k7",
            skin_variant : "silver",
            language : "hu",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            gecko_spellcheck : "true",
            plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
            theme_advanced_buttons1 : "undo,redo,|,fullscreen,|,print,|,preview,|,search,replace,|,pasteword,|,template,mymenubutton,|,code,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,styleprops,|,pagebreak",
            theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect,|,bullist,numlist,|,outdent,indent,blockquote",
            theme_advanced_buttons3 : "link,unlink,anchor,|,insertdate,inserttime,|,forecolor,backcolor,|,cleanup",
            theme_advanced_buttons4 : "", 
            theme_advanced_resizing : true,
            relative_urls : false,
            document_base_url : domain,
            width : "400",  
            height : "550", 
            paste_auto_cleanup_on_paste : true, 
            plugin_preview_width : "500", 
            theme_advanced_resize_horizontal : false,
            theme_advanced_path : false,
            theme_advanced_statusbar_location : 0,
            content_css : "/js/tinymce/jscripts/tiny_mce/themes/advanced/skins/o2k7/user.css",	
            style_formats : [
                {title : 'Content Táblázat'}, 							
                {title : 'contentTable', selector : 'TABLE', classes : 'contentTable'},               
                {title : 'contentTable-header', selector : 'TD', classes : 'contentTable-header'}
            ]
        });
        if (tinyMCE && $.isFunction(tinyMCE.execCommand)) {
            tinyMCE.execCommand('mceAddEditor', false, 'cc-create-megjegyzes');
        }
        // Datepicker a felvétel ideje mezőre.
        $("#cc-create-felvetel-ideje").datepicker();
    } else {
        
    }
    // Cím adatok visszatöltése.
    if ($.isPlainObject(clientLocation) && !$.isEmptyObject(clientLocation)) {
        setLocationValues(locationIdPrefix, locationNamePrefix, clientLocation);
    }
    if ($.isPlainObject(birthplace) && !$.isEmptyObject(birthplace)) {
        setLocationValues(birthplaceIdPrefix, birthplaceNamePrefix, birthplace);
    }
    // Datepicker
    var $birthDate = $("#clientBirthDataSzuletesiIdo").datepicker({
        maxDate: "-18y",
        onClose: function() {
            setClientAgeByDate(this.value);
        }
    });
    $(
        "#labor-market-mikor-regisztralt, #labor-market-gyes-gyed-lejar-datum, #labor-market-kov-felulv-date"
    ).datepicker();
    setClientAgeByDate($birthDate.val());
    // Initialize jQueryUI Tabs.
    $("#user-edit-tabs").tabs({
        select: function ( event, ui ) {
            var hash = ui.tab.hash,
                isSeen = function(tab) {
                    return tabsSeen[tab] === true;
                },
                markAsSeen = function(tab) {
                    tabsSeen[tab] = true;
                };
            switch (hash) {
                case '#tab-contact':
                    if (!isSeen("contact")) {
                        $("#client-contact-table").trigger("refresh");
                        markAsSeen("contact");
                    }
                    break;
                case '#tab-documents':
                    if (!isSeen("documents")) {
                        $("#client-document").trigger("refresh");
                        markAsSeen("documents");
                    }
                    break;
                default:
                    break;
            }
        }
    });
    // Creates a jQueryUI button.
    $(".shpt-form-control-add").button({
        icons: {
            primary: "ui-icon-plusthick"
        }
    });
    // Szolgáltatás.
    $(".uw-ugyfelkezelo-service-option-checkbox").click(function() {
        var disabled = false,
            $serviceOption = $(this).parents(".uw-ugyfelkezelo-service-option"),
            chklength = $serviceOption.find("input:checkbox:checked").length,
            $self = $(this);
        if (!$self.attr("disabled")) {
            $self.val(1);
        }
        if (chklength == 0) {
            disabled = true;
        }
        $serviceOption.find(".uw-ugyfelkezelo-service-option-service-id").attr("disabled", disabled);
    });
    // Program information checkbox click event.
    $(
        "input[type=\"checkbox\"][id^=\"project-information-program-information\"], input[type=\"checkbox\"][id^=\"project-information-client-work-schedules\"]"
    ).click(function() {
        var $inputText = $(this).parents("label").next("input");
        if ($inputText.length == 1) {
            $inputText.attr("disabled", !this.checked);
            if (this.checked) {
                $inputText.rules("add", {
                    required: true
                });
            } else {
                $inputText.removeClass("ui-state-error");
                $inputText.rules("remove");
                $inputText.next(".ui-state-error").remove();
            }
        }
    });
    /*
    var piChecked = $("input[type=\"checkbox\"][id^=\"programInformation\"]:checked");
    $.each(piChecked, function(index, item) {
        var $inputText = $(item).parents("label").next("input");
        if ($inputText.length == 1) {
            console.log($inputText.data());
            $inputText.rules("add", {
                required: true
            });
        }
    });
    */
    // Hides dummy error messages.
    $(".shpt-form-error:contains('shpt-form-error-dummy')").hide();
    // Show error messages.
    $.each($(".shpt-form-row"), function(index, item) {
        var $item = $(item).find("input[id$=\"_error\"][type=\"hidden\"]"),
            errorMessage = $item.val();
        if (errorMessage !== undefined && errorMessage.length > 0) {
            $item.next(".shpt-form-error").html(errorMessage).show();
        }
    });
    // Uniform eltűntetése a kiválasztott elemekről.
    uniformRestore("#tab-jobs select");
});