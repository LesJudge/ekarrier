<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    $("select").change(function(){
            $("#{$BtnFilter}").click();
    });
});
/*]]>*/
</script>

<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    <div class="box_top">
        <h2 class="icon pages">Megrendelt szolgáltatások</h2>
        <ul class="sorting">
            {include file='page/admin/view/admin.list_events.tpl'} 
        </ul>
    </div>  
    <div class="box_content">    
        {include file='page/admin/view/admin.message.tpl'}
        {include file='page/admin/view/admin.list_filter.tpl'}
        <div class="top_filtering">
            {html_options name=$FilterOrderStatusz.name options=$FilterOrderStatusz.values selected=$FilterOrderStatusz.activ}
            {html_options name=$FilterStatus.name options=$FilterStatus.values selected=$FilterStatus.activ}
            <div class="clear"></div>
        </div>
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
            <tr class="data_row">
                <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
                <td class="align_left"><a href="{$APP_LINK}/clientorderedit/{$lista.ID}{$LANG_PARAM}" title="Módosítás">{$lista.elso}</a></td>
                <td class="align_left center">{$lista.statusz}</td>
                <td class="align_left center">{$lista.letrehozva}</td>
                <td class="align_left center">{$lista.modosito}</td>
                <td class="align_left center">{$lista.modositva}</td>
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