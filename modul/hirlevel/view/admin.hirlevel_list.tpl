<script type="text/javascript">
$(function() { {$FormScript}
    $('select[name="{$FilterTipus.name}"]').change(function() { $('#{$BtnFilter}').click(); });
});
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
	<div class="box_top">
		<h2 class="icon pages">Hírlevelek</h2>
		<ul class="sorting">
			{include file='page/admin/view/admin.list_events_min.tpl'}
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
                    <td class="align_left"><a href="{$APP_LINK}/edit/{$lista.ID}" title="Módosítás">{$lista.elso}</a></td>
                    <td class="align_left center">{$lista.hirlevel_felado_nev}</td>
                    <td class="align_left center">{$lista.hirlevel_felado_email}</td>
                    <td class="align_left center">{$lista.hirlevel_cimzett_szum}</td>
                    <td class="align_left center">{$lista.hirlevel_kikuldve}</td>
                    <td class="align_left center">{$lista.hirlevel_megnyitva}</td>
                    <td class="align_left center">{$lista.hirlevel_kuldes_datum}</td>
                    <td class="align_left center">{$lista.kikuldetlen}</td>
               </tr>                             
            {/foreach}
        </table>
       {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>