            <div id="jobTabs">
                <ul>
                    <li><a href="#tab-job-base">Alap adatok</a></li>
                    <li><a href="#tab-tkor">Tevékenységi kör</a></li>
                    <li><a href="#tab-elvaras">Elvárások</a></li>
                    <!--
                    <li><a href="#tab-feladat">Feladatok</a></li>
                    <li><a href="#tab-amit-kinalunk">Amit kínálunk</a></li>
                    <li><a href="#tab-ismerteto">Ismertető</a></li>
                    <li><a href="#tab-jel-mod">Jelentkezés módja</a></li>
                    <li><a href="#tab-mvegz-helye">Munkavégzés helye</a></li>
                    -->
                </ul>
                <div id="tab-job-base">{include file="modul/allashirdetes/view/partial/site/tab_job_base.tpl"}</div>
                <div id="tab-tkor">{include file="modul/allashirdetes/view/partial/site/tab_tkor.tpl"}</div>
                <div id="tab-elvaras">{include file="modul/allashirdetes/view/partial/site/tab_elvaras.tpl"}</div>
            </div>
            
<link rel="stylesheet" type="text/css" href="{$DOMAIN}css/modul/sheepit-form.css" />
<script type="text/javascript" src="{$DOMAIN}js/jquery.sheepItPlugin.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() {
    $("#jobTabs").tabs();
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
        afterAdd: function(source, newForm) {
            newForm.find(".shpt-form-remove-current").button({
                icons: {
                    primary: "ui-icon-trash"
                },
                text: false
            });
        }
    },
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
            //newForm.find("input[id$=\"_elvaras\"]").autocomplete({
            //    source: elvarasOptions
            //});
        }
    });
});
/*]]>*/
</script>