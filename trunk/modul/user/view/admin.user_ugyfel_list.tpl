{extends file='modul/user/view/parent/admin.user_list_parent.tpl'}
{block name="BlockIncludes"}
<link type="text/css" rel="stylesheet" href="{$DOMAIN}css/uwDynamicFilters.css" />
<script type="text/javascript" src="{$DOMAIN}js/jquery.uw-dynamic-filters.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientBaseWidget.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.projectCreator.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientExport.js"></script>
<script id="cknowledgeView" type="text/html">
<div class="uw-df-cknowledge-filter">
    <input name="{$ugyfelDfSzIsmeret.name}[]" type="text" />
    <button type="button" style="position: absolute; height: 26px; width: 26px; top: 3px; left: 253px"></button>
    <select name="{$ugyfelDfSzIsmeretLike.name}[]">
        <option value="{$opLikeAnywhere}">bárhol</option>
        <option value="{$opLikePre}">elején</option>
        <option value="{$opLikeEqual}">teljes egyezés</option>
        <option value="{$opLikePost}">végén</option>
    </select>
    <div class="clear"></div>
</div>
</script>
{include file="modul/user/view/partial/ugyfel/list/client_export.tpl"}
{/block}
{block name="BlockTitle"}Ügyfélkezelő{/block}
{block name="EventBtns"}
    <button id="client-export" type="button">
        <img class="tip" title="Ügyfél export" src="../images/admin/icons/file_export.png" />
    </button>
    <button type="button">
        <img class="tip" title="Ügyfél import" src="../images/admin/icons/file_import.png" />
    </button>
    <button id="project-creator" type="button">
        <img class="tip" title="Új projekt" src="../images/admin/icons/note_add.png" />
    </button>
    <input id="{$BtnExport}" name="{$BtnExport}" type="submit" value="1" style="display: none;" />
{/block}
{block name="BlockFilter"}
<style type="text/css">
#dialog-export .single-attrs {
    float: left;
    width: 33.33%;
}
#project-creator-form-name {
    width: 94%;
}
</style>
<div id="project-creator-dialog" title="Új projekt létrehozása">
    <ul id="project-creator-form-error" class="ui-state-error" style="display: none;">
        <li>dummy-message</li>
    </ul>
    <form id="project-creator-form" method="post" action="/action">
        <div class="form_row">
            <label>Projekt név</label>
            <input id="project-creator-form-name" name="nev" type="text" />
        </div>
    </form>
</div>
<div id="project-creator-feedback-success" class="notice success" style="display: none; margin: 0 auto; width: 90%;">
    <p>Message</p>
</div>
<div id="client-export-attrs" style="display: none;"></div>
<div id="dynamicFilters" class="uw-df-filters">
    {**$activeDynamicFilters**}
    <div class="uw-df-filter">    
        <label for="{$FilterSzuro.name}">{php}echo LANG_AdminFilter_szuro;{/php}:</label>
        <input type="text" id="{$FilterSzuro.name}" name="{$FilterSzuro.name}"  value="{$FilterSzuro.activ}" />
    </div><!--/.uw-dynamic-filter-filter-->
    <div id="dynamicFiltersContainer" class="uw-df-filters-container"></div><!--/#dynamicFiltersContainer-->
    <div class="uw-df-filters-btns">
        <button id="addFilterBtn" class="uw-df-filters-btn-dialog-open" type="button">Szűrő hozzáadása</button><!--/#addFilterBtn-->
        <button id="{$BtnFilter}" name="{$BtnFilter}" class="submit" type="submit" value="1">Keresés</button>
        <button id="{$BtnFilterDEL}" name="{$BtnFilterDEL}" class="submit" type="submit" value="1">Alaphelyzet</button>
    </div><!--/.uw-dynamic-filters-btns-->
    <div id="filterDialog" class="uw-df-dialog" title="Szűrő hozzáadása"></div><!--/#filterDialog-->
    {*include file="modul/user/view/partial/ugyfel/list/dynamic_filters.tpl"*}
</div><!--/#dynamicFilters-->
{/block}
{block name="BlockJs"}
// Ügyfél export.
$("#client-export").clientExport({
    dialogSelector: "#client-export-dialog",
    errorSelector: "#client-export-dialog-error",
    formSelector: "#client-export-attrs",
    useNames: false,
    submitSelector: "#{$BtnExport}"
});
// Projekt létrehozás.
$("#project-creator").projectCreator({
    baseUrl: "{$DOMAIN_ADMIN}",
    action: "{$BtnProject}",
    projectUrl: "user/ugyfel",
    dialogSettings: {
        autoOpen: false,
        height: 250,
        modal: true,
        width: 400                
    },
    selectors: {
        dialog: "#project-creator-dialog",
        feedbackSuccess: "#project-creator-feedback-success",
        filters: "#UgyfelList #dynamicFilters *",
        formError: "#project-creator-form-error",
        projectNameInput: "#project-creator-form-name"
    }
});
var addDatepicker = function($filter) {
        $filter.find("input").datepicker();
    },
    dpAfterAdd = [
        "ugyfelDfBirthdate", "ugyfelDfMikorReg", "ugyfelDfGyesGyedLejarDatum", "ugyfelDfKovFelulvDatum"
    ],
    fcs = {};
for (i in dpAfterAdd) {
    fcs[dpAfterAdd[i]] = {
        afterAdd: function($filter) {
            addDatepicker($filter);
        }
    }
}
$("#dynamicFilters").uwDynamicFilters({
    activeFilters: {$activeDynamicFilters},
    dialogSettings: {
        autoOpen: false,
        height: 600,
        modal: true,
        width: 1200
    },
    /*filterCallbacks: $.extend({}, fcs, {
        
    })*/
    filterCallbacks: {
        ugyfelDfBirthdate: {
            afterAdd: function($filter) {
                $useDp = $filter.find(".uw-df-filter-text-date-use-dp");
                if ($useDp.length == 1) {
                    $useDp.uniform();
                    $useDp.click(function() {
                        $textInputs = $filter.find("input[type=\"text\"]");
                        if ($(this).attr("checked")) {
                            $textInputs.datepicker();
                        } else {
                            $textInputs.datepicker("destroy");
                        }
                    });
                    $useDp.trigger("click");
                }
                $filter.find("select").change(function() {
                    if (this.value === "{$opSqlBetween}") {
                        $filter.find(".uw-df-filter-text-date-to").show();
                    } else {
                        $filter.find(".uw-df-filter-text-date-to").hide();
                    }
                });
            }
        },
        ugyfelDfCimVaros: {
            afterAdd: function($filter) {
                //$filter.find("select").multiselect();
                //$filter.find("select").multiselect({
                //    multiple: false,
                //    selectedList: 1
                //}).multiselectfilter();
            }
        },
        ugyfelDfSzIsmeret: {
            afterAdd: function($filter) {
                $("#cknowledge-btn-add").button({
                    create: function(event, ui) {
                        $(this).click(function() {
                            var $view = $($("#cknowledgeView").get(0).innerHTML);
                            $view.find("button").button({
                                create: function(event, ui) {
                                    $(this).click(function() {
                                        $(this).parent().remove();
                                    });
                                },
                                icons: {
                                    primary: "ui-icon-closethick"
                                },
                                text: false
                            });
                            $view.find("input[type=\"text\"]").autocomplete({
                                minLength: 2,
                                source: {$cknowledgesAc}
                            });
                            $view.insertBefore($("#cknowledge-btn-add"));
                            
                        });
                    },
                    icons: {
                        primary: "ui-icon-plusthick"
                    }
                });
                {if is_array($ugyfelDfSzIsmeret.activ)}
                var knowledges = {json_encode($ugyfelDfSzIsmeret.activ)},
                    likes = {json_encode($ugyfelDfSzIsmeretLike.activ)};
                for (i in knowledges) {
                    $("#cknowledge-btn-add").trigger("click")
                    var $lastCk = $(".uw-df-cknowledge-filter:last");
                    $lastCk.find("input").val(knowledges[i]);
                    $lastCk.find("option[value=\"" + likes[i] + "\"]").attr("selected", true);
                }
                {else}
                $("#cknowledge-btn-add").trigger("click");
                {/if}
                $filter.find(":checkbox").uniform();
            }
        }
    }
});
var groupLabels = new Array();
groupLabels['ugyfelDfFirstname'] = 'Alap adatok';
groupLabels['ugyfelDfPhone'] = 'Ügyfél adatok';
groupLabels['ugyfelDfPalyakezdo'] = 'Munkaerőpiaci helyzeti adatok';
groupLabels['ugyfelDfEuProgElmKetEv'] = 'Projekt információs adatok';
//groupLabels['ugyfelDfMunkarend'] = 'Munkarend';
//groupLabels['ugyfelDfProgramInformacio'] = 'Program információ';
groupLabels['ugyfelDfNyelvtudasNyelv'] = 'Nyelvtudás';
groupLabels['ugyfelDfVegzettsegIskola'] = 'Végzettség';
groupLabels['ugyfelDfSzIsmeret'] = 'Számítógépes ismeret';
for (i in groupLabels) {
    $("<li class=\"uw-df-li\">" + groupLabels[i] + "</li>").insertBefore(
        $("#filterDialog").find("button[data-uw-dynamic-filter-view=\"" + i + "\"]").parent("li")
    ).addClass("uw-df-li-separator");
}
{/block}