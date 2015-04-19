<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
        <div class="box_top">
            <h2 class="icon time">Álláshirdetés - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
        </div>
        <div class="box_content padding">
            {include file='page/admin/view/admin.message.tpl'}
            {include file='page/admin/view/admin.edit_events.tpl'}
            <div id="jobTabs">
                <ul>
                    <li><a href="#tab-job-base">Alap adatok</a></li>
                    <li><a href="#tab-tkor">Tevékenységi kör</a></li>
                    <li><a href="#tab-elvaras">Elvárások</a></li>
                    <li><a href="#tab-feladat">Feladatok</a></li>
                    <li><a href="#tab-kompetencia">Kompetenciák</a></li>
                    <li><a href="#tab-amit-kinalunk">Amit kínálunk</a></li>
                    <!--li><a href="#tab-ismerteto">Ismertető</a></li-->
                    <li><a href="#tab-jel-mod">Jelentkezés módja</a></li>
                    <li><a href="#tab-mvegz-helye">Munkavégzés helye</a></li>
                </ul>
                <div id="tab-job-base">{include file="modul/allashirdetes/view/partial/tab_job_base.tpl"}</div>
                <div id="tab-tkor">{include file="modul/allashirdetes/view/partial/tab_tkor.tpl"}</div>
                <div id="tab-elvaras">{include file="modul/allashirdetes/view/partial/tab_elvaras.tpl"}</div>
                <div id="tab-feladat">{include file="modul/allashirdetes/view/partial/tab_feladat.tpl"}</div>
                <div id="tab-kompetencia">{include file="modul/allashirdetes/view/partial/tab_kompetenciak.tpl"}</div>
                <div id="tab-amit-kinalunk">{include file="modul/allashirdetes/view/partial/tab_amit_kinalunk.tpl"}</div>
                <div id="tab-ismerteto">
                    <!--div class="field tabField">
                        <div class="form_row">
                            <label for="{$TxtIsmerteto.name}">Ismertető <span class="require">*</span></label>
                            <textarea class="tinymce" id="{$TxtIsmerteto.name}" name="{$TxtIsmerteto.name}">{$TxtIsmerteto.activ}</textarea>
                            {if isset($TxtIsmerteto.error)}<p class="error small">{$TxtIsmerteto.error}</p>{/if}
                        </div>
                        <div class="clear"></div>
                    </div-->
                </div>
                <div id="tab-jel-mod">
                    <div class="field tabField">
                        <div class="form_row">
                            <label for="{$TxtJelMod.name}">Jelentkezés módja <span class="require">*</span></label>
                            <textarea class="tinymce" id="{$TxtJelMod.name}" name="{$TxtJelMod.name}">{$TxtJelMod.activ}</textarea>
                            {if isset($TxtJelMod.error)}<p class="error small">{$TxtJelMod.error}</p>{/if}
                        </div>
                        <div class="clear"></div>
                        <div class="form_row">
                            <label for="{$DateJelentkezesHatarideje.name}">Jelentkezés határideje <span class="require">*</span></label>
                            <input id="{$DateJelentkezesHatarideje.name}" name="{$DateJelentkezesHatarideje.name}" type="text" value="{$DateJelentkezesHatarideje.activ}" />
                            {if isset($DateJelentkezesHatarideje.error)}<p class="error small">{$DateJelentkezesHatarideje.error}</p>{/if}
                        </div>
                        <div class="clear"></div>
                        
                        
                    </div>
                </div>
                <div id="tab-mvegz-helye">{include file="modul/allashirdetes/view/partial/tab_mvegz_helye.tpl"}</div>
            </div>
        </div>
    </div>
    {if isset($recordStatus) and $recordStatus eq true}
    {include file="page/admin/view/admin.record_status.tpl"}
    {/if}
</form>
<style type="text/css">
#jobTabs {
    width: 90%;
}
.tabField {
    margin-top: 0px !important;
}
.tabField .form_row:first-child label {
    margin-bottom: 12px !important;
    margin-top: 4px !important;
}
{if $ChkEgyedi.activ === "1"}
#companyRow {
    display: none;
}
{elseif $ChkEgyedi.activ === "0"}
#advertiserRow {
    display: none;
}
{else}
#advertiserRow, #companyRow {
    display: none;
}
{/if}
{if $ChkMasHirdetese.activ === 1}
#notOurLinkRow {
    display: block;
}
{else}
#notOurLinkRow {
    display: none;
}
{/if}
</style>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientBaseWidget.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.jobSelect.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/modul/allashirdetes/uniweb.allashirdetes.helper.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/helper/uniweb.helper.uniform.js"></script>
<link rel="stylesheet" type="text/css" href="{$DOMAIN}css/uniweb/sheepit-form.css" />
<script type="text/javascript" src="{$DOMAIN}js/jquery.sheepItPlugin.js"></script>
<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
var domain = "{$DOMAIN}";
var elvarasOptions = new Array, feladatOptions = new Array;
$(function() {
    // SEO URL
    $("#{$TxtNev.name}").removeAccents({ target: $("#{$TxtLink.name}"), bind:"change" });
    $("#{$TxtLink.name}").removeAccents();
    
    $(".as-selection-item").addClass("ui-widget-content");
    $(".as-selections").addClass("ui-widget-content");
    // A hirdetés típusához tartozó kötelező mező megjelenítése.
    $("input[name=\"{$ChkEgyedi.name}\"]").click(function() {
        if (this.value == 1) {
            $("#advertiserRow").show();
            $("#companyRow").hide();
        } else {
            $("#advertiserRow").hide();
            $("#companyRow").show();
        }
    });
    // Más hirdetése link mező megjelenítése vagy elrejtése.
    $("input[name=\"{$ChkMasHirdetese.name}\"]").click(function() {
        if (this.value == 1) {
            $("#notOurLinkRow").show();
        } else {
            $("#notOurLinkRow").hide();
        }
    });
    // Datepicker a lejárati dátum mezőre.
    $("#{$DateLejar.name}, #{$DateKezdes.name}, #{$DateMunkakezdesIdeje.name}, #{$DateJelentkezesHatarideje.name}").datepicker();
    
    function onExists( mainId, subId ) {
        var $mainSelect = this.find(".job-select-main");
        this.find(".job-select-main").val(mainId).change();
        var $subSelect = this.find(".job-select-sub"), 
            $mainOption = $mainSelect.find("option[value=\"" + mainId + "\"]"),
            $subOption = $subSelect.find("option[value=\"" + subId + "\"]");
        $mainOption.attr("selected", true);
        $subOption.attr("selected", true);
        $mainSelect.prev("span").text($mainOption.text());
        $subSelect.prev("span").text($subOption.text());
    }
    
    function onNotExists() {
        this.find(".job-select-main, .job-select-sub").change(function() {
            var $self = $(this);
            $self.prev("span").text($self.find("option:selected").text());
        });
    }
    
    // Initialize jQueryUI Tabs.
    $("#jobTabs").tabs();
    var tks = new tevekenysegiKor( {if $tkorok}{$tkorok}{else}{literal}{}{/literal}{/if}, 0 ),
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
    //elvarasOptions = ["Elvárás 1", "Elvárás 2"],
    //feladatOptions = ["Feladat 1", "Feladat 2"],
    {literal}
    tkorSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#tkorFormAddBtn",
        controlsSelector: "#tkorFormControls",
        formTemplateSelector: ".shpt-form-tkor",
        noFormsTemplateSelector: "#tkorFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $tkorok}
        data: {$tkorok},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            sheepItJobsAfterAdd(
                newForm, 
                tks,
                onExists,
                onNotExists, 
                "input[id$=\"_elvaras\"]", 
                "input[id$=\"_feladat\"]", 
                "a"
            );
           //newForm.find(".job-select").jobSelect();
           //console.log(newForm.find(".job-select-name").data());
           //newForm.find(".job-select-name").on("autocompletechange", function() {
           //});
        }
    }),
    {literal}
    elvarasokSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#elvarasFormAddBtn",
        controlsSelector: "#elvarasFormControls",
        formTemplateSelector: ".shpt-form-elvaras",
        noFormsTemplateSelector: "#elvarasFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $elvarasok}
        data: {$elvarasok},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("input[id$=\"_elvaras\"]").autocomplete({
                source: elvarasOptions
            });
        }
    }),
    {literal}
    feladatokSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#feladatFormAddBtn",
        controlsSelector: "#feladatFormControls",
        formTemplateSelector: ".shpt-form-feladat",
        noFormsTemplateSelector: "#feladatFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $feladatok}
        data: {$feladatok},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            //console.log(feladatOptions);
            newForm.find("input[id$=\"_feladat\"]").autocomplete({
                source: feladatOptions
            });
        }
    }),
    {literal}
    kompetenciaSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#kompetenciaFormAddBtn",
        controlsSelector: "#kompetenciaFormControls",
        formTemplateSelector: ".shpt-form-kompetencia",
        noFormsTemplateSelector: "#kompetenciaFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $kompetenciak}
        data: {$kompetenciak},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("select").change(uniformSelectChange);
        }
    }),
    {literal}
    amitKinalunkSheepIt = $.extend({}, sheepItBase, {
    {/literal}
        addSelector: "#amitKinalunkFormAddBtn",
        controlsSelector: "#amitKinalunkFormControls",
        formTemplateSelector: ".shpt-form-amitKinalunk",
        noFormsTemplateSelector: "#amitKinalunkFormNoTemplate",
        removeCurrentSelector: ".shpt-form-remove-current",
        {if $amitKinalunk}
        data: {$amitKinalunk},
        {/if}
        afterAdd: function(source, newForm) {
            sheepItBase.afterAdd(source, newForm);
            newForm.find("input[id$=\"_amit_kinalunk\"]").autocomplete({
                source: {$amitKinalunkOptions}
            });
        }
    });
    
     {if $kompetenciak}
        // Ez mi ?! :D
        /*
        for(i = 0; i<{$kompetenciak}.length; i++)
        {
            var $myDiv = $('#kompetenciaForm_'+i+'_kompetencia_id');
                if ( $myDiv.length){
                    alert('megvan');
                }
     }
     */
    {/if}
        
    $("#tkorForm").sheepIt(tkorSheepIt);
    $("#elvarasForm").sheepIt(elvarasokSheepIt);
    $("#feladatForm").sheepIt(feladatokSheepIt);
    $("#kompetenciaForm").sheepIt(kompetenciaSheepIt);
    $("#amitKinalunkForm").sheepIt(amitKinalunkSheepIt);
    // Initialize sheepItForm add buttons.
    $(".shpt-form-control-add").button({
        icons: {
            primary: "ui-icon-plusthick"
        }
    });
    $("#kompetenciaForm").find("select").trigger("change");
    {if isset($recordStatus) and $recordStatus}
    var updateJobIdsBy = findJobIds("input[id$=\"munkakor_id\"]");
    updateExpectationsAndTasks(updateJobIdsBy, "input[id$=\"elvaras\"]", "input[id$=\"feladat\"]")
    {/if}
});
/*]]>*/
</script>