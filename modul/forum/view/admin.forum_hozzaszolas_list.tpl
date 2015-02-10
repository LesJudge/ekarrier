<script type="text/javascript">
$(function() { {$FormScript}
    $('select[name="{$FilterNyelv.name}"]').change(function() { $('#{$BtnFilter}').click(); });
    $('select[name="{$FilterKapcsolodo.name}"]').change(function() { $('#{$BtnFilter}').click(); });
});
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
	<div class="box_top">
		<h2 class="icon pages">Fórum hozzászólások</h2>
		<ul class="sorting">
			<div class="form_muvelet">
			    <button class="submit tip" id="{$BtnMultiplePublish}" name="{$BtnMultiplePublish}" value="{php}echo LANG_AdminList_publikal;{/php}" title="{php}echo LANG_AdminList_publikal;{/php}" onclick="return confirmBox('{$BtnMultiplePublish}', '{php}echo LANG_AdminList_publikal;{/php}', '{php}echo LANG_AdminList_publikal_content;{/php}');" ><img src="../images/admin/icons/table_accept.png"/></button>
			    <button class="submit tip" id="{$BtnMultipleUnpublish}" name="{$BtnMultipleUnpublish}" value="{php}echo LANG_AdminList_visszavon;{/php}" title="{php}echo LANG_AdminList_visszavon;{/php}" onclick="return confirmBox('{$BtnMultipleUnpublish}', '{php}echo LANG_AdminList_visszavon;{/php}', '{php}echo LANG_AdminList_visszavon_content;{/php}');"><img src="../images/admin/icons/table_remove.png"/></button>
			    <button class="submit tip" id="{$BtnMultipleDelete}" name="{$BtnMultipleDelete}" value="{php}echo LANG_AdminList_torol;{/php}" title="{php}echo LANG_AdminList_torol;{/php}" onclick="return confirmBox('{$BtnMultipleDelete}', '{php}echo LANG_AdminList_torol;{/php}', '{php}echo LANG_AdminList_torol_content;{/php}');"><img src="../images/admin/icons/trash_can.png"/></button>
			</div>
		</ul>
	</div>
    <div class="box_content">    
        {include file='page/admin/view/admin.message.tpl'}
        {include file='page/admin/view/admin.list_filter.tpl'}
        <div class="top_filtering" >
            {html_options name=$FilterNyelv.name options=$FilterNyelv.values selected=$FilterNyelv.activ}
            {html_options name=$FilterKapcsolodo.name options=$FilterKapcsolodo.values selected=$FilterKapcsolodo.activ}
        	<div class="clear"></div>
        </div>
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
                <tr class="data_row">
                    <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
                    <td class="align_left"><a href="{$APP_LINK}/edit/{$lista.ID}" title="Módosítás">{$lista.elso}</a></td>
                    <td class="align_left center">{$lista.hozzaszolas_tartalom_min}</td>
					<td class="align_left center">{$lista.bekuldve}</td>
                    <td class="align_left center">
                        {if $lista.Aktiv}
                            <button id="statusz_{$for_id}" title="Visszavonás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan visszavonja a fórum hozzászólást', 'Visszavonja a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnUnpublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-locked">Visszavonás</span></button>
                        {else}
                            <button id="statusz_{$for_id}" title="Publikálás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan publikussá teszi a fórum hozzászólást', 'Publikussá teszi a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnPublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-unlocked">Publikálás</span></button>
                        {/if}
                    </td>
               </tr>                             
            {/foreach}
        </table>
       {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>