<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    $("#{$TxtNev.name}").removeAccents({ target: $("#{$TxtLink.name}"), bind:"change" });
    $("#{$TxtLink.name}").removeAccents();
    $("#{$TxtKulcsszo.name}").autoSuggest("",{ neverSubmit: true, showResultList:false, asHtmlID:'{$TxtKulcsszo.name}', preFill: '{$TxtKulcsszo.activ}', selectionRemoved: function(elem){ elem.remove();if($("li.as-selection-item").length == 0){ $("input[type='hidden']").attr("value", ""); }; } });
    $(".as-selection-item").addClass("ui-widget-content");
    $(".as-selections").addClass("ui-widget-content");
    $('select[name="{$SelKapcsolodo.name}[]"]').multiselect().multiselectfilter();
    $('select[name="{$SelKategoria.name}[]"]').multiselect().multiselectfilter();
    $("#ceg-tabs").tabs();
});
/*]]>*/
</script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<style type="text/css">
.field {
    margin-top: 0px !important;
}
.field h2 {
    margin: 0px;
    padding-bottom: 5px;
}
</style>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
        <div class="box_top">
            <h2 class="icon time">Cég - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
        </div>
        <div class="box_content padding">
            {include file='page/admin/view/admin.message.tpl'}
            {include file='page/admin/view/admin.edit_events.tpl'}
            <div id="ceg-tabs" style="width: 90%;">
                <ul>
                    <li>
                        <a href="#alap-adatok">Alap adatok</a>
                    </li>
                    <li>
                        <a href="#ceg-adatok">Cég adatok</a>
                    </li>
                </ul>
                <div id="alap-adatok">{include file="modul/ceg/view/partial/admin/edit/admin.ceg_edit_tab_ceg_alap_adatok.tpl"}</div>
                <div id="ceg-adatok">{include file="modul/ceg/view/partial/admin/edit/admin.ceg_edit_tab_ceg_adatok.tpl"}</div>
            </div>
        </div>
    </div>
    {if $letrehozas_timestamp}
    <div class="grid_6"> 
        <div class="box_top">
            <h2 class="icon time">Információ</h2>
        </div>
        <div class="box_content padding">
            <div class="form_row">
                <strong>Megtekintve:</strong> {$megtekintve} 
                <input class="submit" style="margin-left: 10px; padding: 1px;" type="submit" name="{$BtnDeleteMegtekintes}" value="Törlés"/>
            </div>
            <div class="clear"></div>
            <div class="form_row"> <strong>Javítások száma:</strong> {$modositas_szama} </div><div class="clear"></div>
            <div class="form_row"> <strong>Létrehozva:</strong> {$letrehozas_timestamp} </div><div class="clear"></div>
            <div class="form_row">
                <strong>Létrehozó:</strong>
                <a href="{$DOMAIN_ADMIN}user/edit/{$letrehozo_id}" target="_blank">{$letrehozo_fnev} ({$letrehozo_vnev} {$letrehozo_knev})</a>
            </div>
            <div class="clear"></div>
            <div class="form_row"> <strong>Utoljára módosítva:</strong> {$modositas_timestamp} </div><div class="clear"></div>
            <div class="form_row">
                <strong>Utolsó módosító:</strong>
                <a href="{$DOMAIN_ADMIN}user/edit/{$modosito_id}" target="_blank">{$modosito_fnev} ({$modosito_vnev} {$modosito_knev})</a>
            </div>
            <div class="clear"></div>
            <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$ceg_allapot} </div><div class="clear"></div>
        </div>
    </div>
    {/if}
</form>