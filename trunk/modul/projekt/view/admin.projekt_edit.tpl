<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientExport.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() {
    {$FormScript}
    $("textarea[name^=\"{$TxtMegjegyzes.name}\"]").hide().next("a").hide();
    $(".project-client a:first").click(function(event) {
        event.preventDefault();
        $(this).hide().next("textarea").show().next("a").show().click(function(event) {
            event.preventDefault();
            $("#{$BtnSave}").trigger("click");
        });
    });
    // Ügyfél export.
    $("#client-export").clientExport({
        dialogSelector: "#client-export-dialog",
        errorSelector: "#client-export-dialog-error",
        formSelector: "#client-export-attrs",
        useNames: true,
        //submitSelector: "#{$BtnExport}"
        submitSelector: "#export"
    });
});
/*]]>*/
</script>

<div id="client-export-attrs" style="display: none;"></div>
<div id="client-export-dialog" title="Ügyfél export">
    
</div>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
        <div class="box_top">
            <h2 class="icon time">Projekt - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
        </div>
        <div class="box_content padding">
            {include file='page/admin/view/admin.message.tpl'}
            {if not $fatalError}
            {include file='page/admin/view/admin.edit_events.tpl'}
            <button id="client-export" type="button">
                <img class="tip" title="Ügyfél export" src="../images/admin/icons/file_export.png" />
            </button>
            <div class="field">
                <div class="form_row">
                    <label for="{$TxtNev.name}">Név <span class="require">*</span></label>
                    <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
                    {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if}
                </div>
                <div class="clear"></div>
            </div>
            {if $clients}
            <div class="field">
                {foreach from=$clients item=client}
                <div class="project-client" style="min-height: 30px;">
                    <p>
                        {$client.vezeteknev} {$client.keresztnev}
                        ({$client.email}{if $client.user_fnev} - {$client.user_fnev}{/if})
                    </p>
                    <a href="#">Szerkesztés</a>
                    <textarea name="{$TxtMegjegyzes.name}[{$client.ugyfel_id}]" type="text">{$client.megjegyzes}</textarea>
                    <a href="#">Mentés</a>
                </div>
                {/foreach}
            </div>
            {/if}
            <div class="clear"></div>
            <div class="field">
                <div class="form_row">
                    <label>Publikus <span class="require">*</span></label>
                    {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                    {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                </div>
                <div class="clear"></div>
            </div>
            {/if}
        </div>
    </div>
    {if isset($recordStatus) and $recordStatus eq true}
    {include file="page/admin/view/admin.record_status.tpl"}
    {/if}
</form>
<style type="text/css">
.project-client {
    clear: both;
    display: block;
}
.project-client p {
    margin: 0px;
}
.project-client input[type="text"] {
    margin-bottom: 10px;
}
</style>