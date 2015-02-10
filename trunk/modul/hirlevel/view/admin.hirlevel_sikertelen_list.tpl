<script type="text/javascript">
$(function() { {$FormScript}
    $('select[name="{$FilterHirlevel.name}"]').change(function() { $('#{$BtnFilter}').click(); });
});
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
	<div class="box_top">
		<h2 class="icon pages">Sikertelenül kiküldött levelek</h2>
		<ul class="sorting">
        	<div class="form_muvelet">
            	<button class="submit tip" id="{$BtnMultipleDelete}" name="{$BtnMultipleDelete}" value="{php}echo LANG_AdminList_torol;{/php}" title="{php}echo LANG_AdminList_torol;{/php}" onclick="return confirmBox('{$BtnMultipleDelete}', '{php}echo LANG_AdminList_torol;{/php}', '{php}echo LANG_AdminList_torol_content;{/php}');"><img src="../images/admin/icons/trash_can.png"/></button>
        	</div>
		</ul>
	</div>
    <div class="box_content">    
        {include file='page/admin/view/admin.message.tpl'}
        {include file='page/admin/view/admin.list_filter.tpl'}
        <div class="top_filtering" >
            {html_options name=$FilterHirlevel.name options=$FilterHirlevel.values selected=$FilterHirlevel.activ}
        	<div class="clear"></div>
        </div>
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
                <tr class="data_row">
                    <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
                    <td class="align_left">{$lista.nev}</td>
                    <td class="align_left center">{$lista.email}</td>
                    <td class="align_left center">{$lista.hirlevel_targy}</td>
                    <td class="align_left center">{$lista.hirlevel_kikuldendo_probalkozas}</td>
                    <td class="align_left center">{$lista.hirlevel_kikuldendo_send_date}</td>                    
               </tr>                             
            {/foreach}
        </table>
       {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>