<style type="text/css">
.document-generated {
    background: rgba(30, 255, 0, 0.2);
    color: #000;
    text-shadow: none;
}
/*button[name="{$BtnGenDoc}"] { */
.sorting button {
    height: 29px;
    width: 45px;
}
#preview-dialog-container {
    background: url('{$DOMAIN}');
    margin: 0 auto;
    width: 90%;
}
</style>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    $("select").change(function(){
        $("#{$BtnFilter}").click();
    });
    $("button[name=\"{$BtnGenDoc}\"], button[name=\"{$BtnGenPdf}\"], button[name=\"preview\"]").click(function(event) {
        event.stopPropagation();
    });
    $("button[name=\"{$BtnGenDoc}\"]").button({
        icons: {
            primary: "ui-icon-document"
        },
        text: false
    });
    $("button[name=\"preview\"]").button({
        create: function(event, ui) {
            $(this).click(function(event) {
                var jobId = this.value;
                $.ajax({
                    dataType: "html",
                    method: "GET",
                    url: "{$DOMAIN}allashirdetes/ajax/job-preview/" + jobId + "/",
                    beforeSend: function() {
                        $("#preview-dialog").html("<p>Előnézet generálás folyamatban...</p>");
                        $("#preview-dialog").dialog("open");
                    },
                    success: function(data) {
                        $("#preview-dialog").html(data).hide();
                        $("#preview-dialog").find("img").css({
                            display: "block",
                            margin: "0 auto",
                            width: "100%"
                        });
                        $("#preview-dialog").fadeIn(500);
                    }
                });
            });
        },
        icons: {
            primary: "ui-icon-zoomin"
        },
        text: false
    });
    $("#preview-dialog").dialog({
        autoOpen: false,
        close: function(event, ui) {
            $(this).html(null);
        },
        height: 600,
        modal: true,
        width: 800
    });
});
/*]]>*/
</script>
<div id="preview-dialog" title="Álláshirdetés előnézete">
    
</div>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    <div class="box_top">
        <h2 class="icon pages">Álláshirdetések</h2>
        <ul class="sorting">
            {include file='page/admin/view/admin.list_events.tpl'} 
        </ul>
    </div>

    <div class="box_content">    
        {include file='page/admin/view/admin.message.tpl'}
        {include file='page/admin/view/admin.list_filter.tpl'}
        <div class="top_filtering">
            {html_options name=$FilterStatus.name options=$FilterStatus.values selected=$FilterStatus.activ}
            {html_options name=$FilterCeg.name options=$FilterCeg.values selected=$FilterCeg.activ}
            {html_options name=$FilterEllenorzott.name options=$FilterEllenorzott.values selected=$FilterEllenorzott.activ}
            {html_options name=$FilterEgyedi.name options=$FilterEgyedi.values selected=$FilterEgyedi.activ}
            {html_options name=$FilterMasHirdetes.name options=$FilterMasHirdetes.values selected=$FilterMasHirdetes.activ}
            <div class="clear"></div>
        </div>
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
            <tr class="data_row{if $lista.generated} document-generated{/if}">
                <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
                <td class="align_left"><a href="{$APP_LINK}/edit/{$lista.ID}{$LANG_PARAM}" title="Módosítás">{$lista.elso}</a></td>
                <td class="align_left center">{if $lista.egyedi}Egyedi{else}Céges{/if}</td>
                <td class="align_left center">{if $lista.ellenorzott}Igen{else}Nem{/if}</td>
                <td class="align_left center">{if $lista.egyedi}{$lista.hirdeto}{else}{$lista.ceg_nev}{/if}</td>
                <td class="align_left center">{$lista.szektor_nev}</td>
                <td class="align_left center">{$lista.pozicio_nev}</td>
                <td class="align_left center">{$lista.letrehozas_timestamp}</td>
                <td class="align_left center">
                    {if ($lista.modositas_timestamp eq 0) and ($lista.modositas_szama eq 0)}
                    Nem lett módosítva!
                    {else}
                    {$lista.modositas_timestamp}
                    {/if}
                </td>
                <td class="align_left center">{$lista.num_megtekintve}</td>
                <td class="align_left center">
                    {if $lista.generated eq 1}Igen{else}Nem{/if}
                    <button name="{$BtnGenDoc}" value="{$lista.ID}"></button>
                    <button name="{$BtnGenPdf}" value="{$lista.ID}"></button>
                    <!--<button name="preview" type="button" value="{$lista.ID}"></button>-->
                </td>
                <td class="align_left center">
                {if $lista.Aktiv}
                <button id="statusz_{$for_id}" title="Visszavonás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan visszavonja a kompetenciát', 'Visszavonja a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnUnpublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-locked">Visszavonás</span></button>
                {else}
                <button id="statusz_{$for_id}" title="Publikálás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan publikussá teszi a kompetenciát', 'Publikussá teszi a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnPublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-unlocked">Publikálás</span></button>
                {/if}
                </td>
            </tr>                             
            {/foreach}
        </table>
        {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>