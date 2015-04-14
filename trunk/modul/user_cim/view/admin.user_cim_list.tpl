<script type="text/javascript">
$(function() { {$FormScript}
	$('select[name="{$FilterTipus.name}"]').change(function() { $('#{$BtnFilter}').click(); });
});
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
	<div class="box_top">
		<h2 class="icon pages">Felhasználó címek - {$user_nev}</h2>
		<ul class="sorting">
    		<div class="form_muvelet">
			    <a href="{$DOMAIN_ADMIN}{$APP_LINK}/edit{$LANG_PARAM}?user_id={$user_id}" ><span class="ui-button-text"><img class="tip" src="../images/admin/icons/add_data.png"  title="{php}echo LANG_AdminList_uj;{/php}"></span></a>
			    <button class="submit tip" id="{$BtnMultipleDelete}" name="{$BtnMultipleDelete}" value="{php}echo LANG_AdminList_torol;{/php}" title="{php}echo LANG_AdminList_torol;{/php}" onclick="return confirmBox('{$BtnMultipleDelete}', '{php}echo LANG_AdminList_torol;{/php}', '{php}echo LANG_AdminList_torol_content;{/php}');"><img src="../images/admin/icons/trash_can.png"/></button>
			</div> 
		</ul>
	</div>
    <div class="box_content">    
        {include file='page/admin/view/admin.message.tpl'}
        {include file='page/admin/view/admin.list_filter.tpl'}
        <div class="top_filtering" >
            {html_options name=$FilterTipus.name options=$FilterTipus.values selected=$FilterTipus.activ}
            <div class="clear"></div>
        </div>
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
                <tr class="data_row">
                    <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
                    <td class="align_left"><a href="{$APP_LINK}/edit/{$lista.ID}?user_id={$user_id}" title="Módosítás">{$lista.elso}</a></td>
                    <td class="align_left center">{$tipusok[$lista.user_attr_cim_tipus]}</td>
                    <td class="align_left center">{$lista.user_attr_cim_email}</td>
                    <td class="align_left center">{$lista.user_attr_cim_tel}</td>
                    <td class="align_left center">{$lista.user_attr_cim_fax}</td>
               </tr>                             
            {/foreach}
        </table>
       {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>