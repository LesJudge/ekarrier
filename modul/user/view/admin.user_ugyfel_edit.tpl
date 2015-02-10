<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_24">
        <div class="box_top">
            <h2 class="icon time">Ügyfél - [{$mode}]</h2>
        </div>
        <div class="box_content padding">
            {include file='page/admin/view/admin.message.tpl'}
            <div class="form_muvelet">
                <button class="submit tip" name="{$BtnSave}" id="{$BtnSave}" value="{php}echo LANG_AdminEdit_mentes;{/php}" title="{php}echo LANG_AdminEdit_mentes;{/php}">
                    <img src="../images/admin/icons/save.png" alt="save" />
                </button>
                {if not $client->is_new_record()}
                <button class="submit tip" name="{$BtnExport}" id="{$BtnExport}" value="export" title="Export .docx-be!">
                    <img src="../images/admin/icons/file_export.png" alt="export" />
                </button>
                {/if}
                <a href="{$DOMAIN_ADMIN}{$APP_LINK}" id="{$FormName}_close">
                    <img class="tip" title="{php}echo LANG_AdminEdit_megse;{/php}" src="../images/admin/icons/cancel.png"/>
                </a>
            </div><!--/.form_muvelet-->
            {if not $initError}
            <div class="field">
                <div id="user-edit-tabs">
                    <ul>
                        <li>
                            <a href="#tab-ugyfel-informacio">Ügyfél információ</a>
                        </li>
                        <li>
                            <a href="#tab-szemelyes-adatok">Személyes adatok</a>
                        </li>
                        <li>
                            <a href="#tab-munkaeropiaci-helyzete">Munkaerőpiaci helyzete</a>
                        </li>
                        <li>
                            <a href="#tab-projektinformaciok">Projektinformációk</a>
                        </li>
                        <li>
                            <a href="#tab-munkakorokmunkarend">Munkakörök/munkarend</a>
                        </li>
                        <li>
                            <a href="#tab-nytszgp">Végzettségek/Nyelvtudás/Tanulmányok/Számítógépes ismeretek</a>
                        </li>
                        <li>
                            <a href="#tab-allaskeresesi-aktivitas">Álláskeresési aktivitás</a>
                        </li>
                        <li>
                            <a href="#tab-szolgaltatas">Szolgáltatás</a>
                        </li>
                        {if not $client->is_new_record()}
                        <li><a href="#tab-project">Projekt</a></li>
                        <li><a href="#tab-contact">Esetnapló</a></li>
                        <li><a href="#tab-documents">Dokumentumok</a></li>
                        {/if}
                        <li><a href="#tab-login">Belépés adatok</a></li>
                    </ul>
                    <div id="tab-ugyfel-informacio">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_ugyfel_informacio.tpl"}
                    </div><!--/#tab-ugyfel-informacio-->
                    <div id="tab-szemelyes-adatok">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_szemelyes_adatok.tpl"}
                    </div><!--/#tab-szemelyes-adatok-->
                    <div id="tab-munkaeropiaci-helyzete">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_munkaeropiaci_helyzete.tpl"}
                    </div><!--/#tab-munkaeropiaci-helyzete-->
                    <div id="tab-projektinformaciok">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_projektinformaciok.tpl"}
                    </div><!--/#tab-projektinformaciok-->
                    <div id="tab-munkakorokmunkarend">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_munkakorokmunkarend.tpl"}
                    </div><!--/#tab-munkakorokmunkarend-->
                    <div id="tab-nytszgp">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_nytszgp.tpl"}
                    </div><!--/#tab-nytszgp-->
                    <div id="tab-allaskeresesi-aktivitas">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_allaskeresesi_aktivitas.tpl"}
                    </div><!--/#tab-allaskeresesi-aktivitas-->
                    <div id="tab-szolgaltatas">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_services.tpl"}
                    </div><!--/#tab-szolgaltatas-->
                    {if not $client->is_new_record()}
                    <div id="tab-project">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_project.tpl"}
                    </div>
                    <div id="tab-contact">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_contact.tpl"}
                    </div>
                    <div id="tab-documents">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_documents.tpl"}
                    </div>
                    {/if}
                    <div id="tab-login">
                        {include file="modul/user/view/partial/ugyfel/edit/tab_login.tpl"}
                    </div><!--/#tab-login-->
                </div><!--/#user-edit-tabs-->
            </div><!--/.field-->
            {/if}
        </div><!--/.box_content.padding-->
    </div><!--/.grid_24-->
</form>
{assign var="isNewClient" value=$client->is_new_record()}
<script type="text/javascript">
/*<![CDATA[*/
var birthplace = {$birthplace},
    //cities = {$cities},
    cities = [],
    clientId = {if $isNewClient}0{else}{$client->ugyfel_id}{/if},
    clientLocation = {$location},
    domain = "{$DOMAIN}",
    domainAdmin = "{$DOMAIN_ADMIN}",
    formName = "{$FormName}",
    isNewClient = {if $isNewClient}true{else}false{/if},
    tabsSeen = [];
/*]]>*/
</script>
<link rel="stylesheet" type="text/css" href="{$DOMAIN}css/uniweb/modul/user/ugyfelkezelo.css" />
<link rel="stylesheet" type="text/css" href="{$DOMAIN}css/modul/sheepit-form.css" />
<link rel="stylesheet" type="text/css" href="{$DOMAIN}js/dropzone/css/dropzone.css" />
<script type="text/javascript" src="{$DOMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/jquery.sheepItPlugin.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/uniweb.prototype.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/helper/uniweb.helper.autocomplete.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/helper/uniweb.helper.location.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/helper/uniweb.helper.uniform.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/modul/user/uniweb.ugyfelkezelo.helper.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/modul/user/uniweb.ugyfelkezelo.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientBaseWidget.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.jobSelect.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientContact.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientDocument.js"></script>
<!--
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.locationFinder.js"></script>
-->
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    {* Ügyfél adatokra vonatkozó szabályok *}
    {assign var="clientNameLength" value=$client->getNameLength()}
    {assign var="clientEmailLength" value=$client->getEmailLength()}
    {assign var="clientTelephoneLength" value=$client->getTelephoneLength()}
    {* Végzettség adatokra vonatkozó szabályok *}
    {assign var="educationSchoolLength" value=$models.userEducation->getSchoolLength()}
    {assign var="educationDepLength" value=$models.userEducation->getDepLength()}
    {* Számítógépes ismeret adatokra vonatkozó validációs szabályok *}
    {assign var="ucknowledgeKnowledgeLength" value=$ucKnowledgeModel->getKnowledgeLength()}
    // Form validation.
    $("#{$FormName}").validate({
        //debug: true,
        errorClass: "ui-state-error",
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.css("margin-top", "10px");
            if (element.attr("type") == "radio" || element.parent(".form_row").length == 1) {
                error.css("width", "422px");
                error.insertAfter(element.parents(".form_row").next(".clear"));
            } else {
                if (/^programInformation[0-9]+Text$/.test(element.attr("id"))) {
                    error.css({
                        "margin-left": "25px",
                        "margin-top": "56px",
                        "width": "422px"
                    });
                }
                error.insertAfter(element);
            }
        },
        rules: {
            /*
            "client[vezeteknev]": {
                maxlength: {$clientNameLength[1]},
                minlength: {$clientNameLength[0]},
                required: true
            },
            "client[keresztnev]": {
                maxlength: {$clientNameLength[1]},
                minlength: {$clientNameLength[0]},
                required: true
            },
            */
            "client[user_email]": {
                email: true,
                maxlength: {$clientEmailLength[1]},
                minlength: {$clientEmailLength[0]}
            },
            //"client[telefonszam_vezetekes]": {
            //    regex: {literal}/^\36\d{8}$/{/literal}
            //},
            //"client[telefonszam_mobil1]": {
            //    regex: {literal}/^\36\d{9}$/{/literal}
            //},
            //"client[telefonszam_mobil2]": {
            //    regex: {literal}/^\36\d{9}$/{/literal}
            //},
            "client[szuletesi_ido]": {
                dateISO: true
            },
            "client[user_aktiv]": {
                required: true
            },
            "client[user_fnev]": {
                maxlength: 32,
                minlength: 6,
            },
            "models[labor_market][mikor_regisztralt]": {
                dateISO: true
            },
            "models[labor_market][gyes_gyed_lejar_datum]": {
                dateISO: true
            },
            "models[labor_market][kov_felulv_date]": {
                dateISO: true
            }
        },
        messages: {
            "client[telefonszam_vezetekes]": {
                regex: "A telefonszám nem megfelelő! (pl. +3650123456)"
            },
            "client[telefonszam_mobil1]": {
                regex: "A telefonszám nem megfelelő! (pl. +36110134567)"
            },
            "client[telefonszam_mobil2]": {
                regex: "A telefonszám nem megfelelő! (pl. +36110134567)"
            }
        }
    });
    {literal}
    educationsSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#educationFormAddBtn",
        controlsSelector: "#educationFormControls",
        formTemplateSelector: ".shpt-form-education",
        noFormsTemplateSelector: "#educationFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $UserEducation}
        data: {$UserEducation},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("select").change(uniformSelectChange);
            var $eduId = newForm.find("select[name*=\"vegzettseg_id\"]"),
                $school = newForm.find("input[type\"text\"][name*=\"_iskola\"]"),
                $start = newForm.find("input[type\"text\"][name*=\"_kezdet\"]"),
                $end = newForm.find("input[type\"text\"][name*=\"_vegzettseg_veg\"]"),
                $dep = newForm.find("input[type\"text\"][name*=\"_szak\"]");
            $eduId.rules("add", {
                required: true
            });
            $school.rules("add", {
                maxlength: {$educationSchoolLength[1]},
                minlength: {$educationSchoolLength[0]}
            });
            $start.rules("add", {
                digits: true,
                max: {date('Y') - $models.userEducation->getYearDiff()}
            });
            $end.rules("add", {
                digits: true,
                max: {date('Y')}
            });
            $dep.rules("add", {
                maxlength: {$educationDepLength[1]},
                minlength: {$educationDepLength[0]}
            });
        }
    }),
    selectedJobs = {$selectedJobs},
    {literal}
    jobsSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#jobFormAddBtn",
        controlsSelector: "#jobFormControls",
        formTemplateSelector: ".shpt-form-job",
        noFormsTemplateSelector: "#jobFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $sjFake}
        data: {$sjFake},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            var injectData = selectedJobs[newForm.getPosition() - 1];
            newForm.find(".job-select").jobSelect({
                baseUrl: "{$DOMAIN}",
                data: injectData !== undefined ? injectData : null
            });
        }
    }),
    {literal}
    knowledgesSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#knowledgeFormAddBtn",
        controlsSelector: "#knowledgeFormControls",
        formTemplateSelector: ".shpt-form-knowledge",
        noFormsTemplateSelector: "#knowledgeFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $UserKnowledge}
        data: {$UserKnowledge},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("select").change(uniformSelectChange);
            var $langId = newForm.find("select[name*=\"_nyelv_id\"]"),
                $levelId = newForm.find("select[name*=\"_szint_id\"]");
            $langId.rules("add", {
                required: true
            });
            $levelId.rules("add", {
                required: true
            });
        }
    }),
    {literal}
    cknowledgesSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#cKnowledgeFormAddBtn",
        controlsSelector: "#cKnowledgeFormControls",
        formTemplateSelector: ".shpt-form-cknowledge",
        noFormsTemplateSelector: "#cKnowledgeFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $UcKnowledge}
        data: {$UcKnowledge},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            var $knowledgeField = newForm.find("input[type=\"text\"][id$=\"_ismeret\"]");
            $knowledgeField.autocomplete({
                source: {json_encode(array_values($ucKnowledgeOptions))}
            });
            //$knowledgeField.rules("add", {
            //    maxlength: {$ucknowledgeKnowledgeLength[1]},
            //    minlength: {$ucknowledgeKnowledgeLength[0]},
            //    required: true
            //});
        }
    }),
    {literal}
    mediationsSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#mediationFormAddBtn",
        controlsSelector: "#mediationFormControls",
        formTemplateSelector: ".shpt-form-mediation",
        noFormsTemplateSelector: "#mediationFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $sheepItMediations}
        data: {$sheepItMediations},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("input[id$=\"_mikor\"]").datepicker();
            newForm.find("input[id$=\"_kozvetites\"]").autocomplete({
                source: {json_encode(array_values($mediationOptions))}
            });
        }
    });
    // Initialize sheepItForms.
    $("#educationForm").sheepIt(educationsSheepIt);
    $("#jobForm").sheepIt(jobsSheepIt);
    $("#knowledgeForm").sheepIt(knowledgesSheepIt);
    $("#cKnowledgeForm").sheepIt(cknowledgesSheepIt);
    $("#mediationForm").sheepIt(mediationsSheepIt);
    {if $UserEducation}
    $(".shpt-form-education select").trigger("change");
    {/if}
    {if $UserKnowledge}
    $(".shpt-form-knowledge select").trigger("change");
    {/if}
    $(".tab-ugyfel-informacio-btn-tab-edit").button({
        icons: {
            primary: "ui-icon-pencil"
        }
    });
});
/*]]>*/
</script>