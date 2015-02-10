<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
	<div class="box_top">
		<h2 class="icon pages">Hírlevél személy csoportok</h2>
		<ul class="sorting">{include file='page/admin/view/admin.list_events_min.tpl'} </ul>
	</div>
    <div class="box_content">
        {include file='page/admin/view/admin.message.tpl'}
        {include file='page/admin/view/admin.list_filter.tpl'}
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
                <tr class="data_row">
                    <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
                    <td class="align_left">
                        <a class="tip" href="{$APP_LINK}/edit/{$lista.ID}" title="Módosítás">{$lista.elso}</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="tip" title="Csoportba tartozó személyek kezelése" href="{$DOMAIN_ADMIN}{$APP_PATH}/usercsoport/rendezes/{$lista.ID}"><<--Csoport rendezés-->></a>
                    </td>
                    <td class="align_left center">{$lista.nyelv_nev}</td>
               </tr>                             
            {/foreach}
        </table>
       {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>