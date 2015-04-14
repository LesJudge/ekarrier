<script type="text/javascript">
$(function() { 
	{$FormScript}
	$("tr:even").addClass('even'); $("tr:odd").addClass('odd');
	$("tr").mouseover(function(){ $(this).addClass('activ_row'); }).mouseout(function(){ $(this).removeClass('activ_row'); });
    /*LIST FORM check row AND check all row*/
    $('.check_all_input').click(function(){  if($(this).attr('checked')) { var checked = $(':checkbox', $('tr.data_row')).removeAttr('checked');  $('tr.data_row').removeClass('highlight_table_row');  }  else{  var checked = $(':checkbox', $('tr.data_row')).attr('checked','checked');  $('tr.data_row').addClass('highlight_table_row');  }  $('tr.data_row').trigger('click'); });
    $('tr.data_row ').filter(':has(:checkbox:checked)').end().click(function(event) { $(this).toggleClass('highlight_table_row'); if (event.target.type !== 'checkbox'){ $(':checkbox', this).attr('checked', function() {   return !this.checked; });} });
});
</script>
<div class="content">
	<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form" enctype="multipart/form-data">
	    {include file='page/all/view/page.message.tpl'}
	    <div class="form-row clearfix">
		    <div class="left rightmargin">
                <a class="submit topmargin" href="{$DOMAIN}{$APP_LINK}/edit{$LANG_PARAM}" style="float:none;">
    				Új rögzítése
    			</a>
            </div>
            <div class="left leftmargin">
			     <button class="submit" id="{$BtnMultipleDelete}" name="{$BtnMultipleDelete}" value="" title="Kijelöltek törlése"  type="submit">Kijelöltek törlése</button>
            </div>
		</div>
        <table  class="data-table" align="center">
            {include file='page/all/view/page.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
                <tr class="data_row">
                    <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
                    <td class="align_left"><a href="{$APP_LINK}/edit/{$lista.ID}" title="Módosítás">{$lista.elso}</a></td>
                    <td class="align_left center">{$tipusok[$lista.user_attr_cim_tipus]}</td>
                    <td class="align_left center">{$lista.user_attr_cim_email}</td>
                    <td class="align_left center">{$lista.user_attr_cim_tel}</td>
                    <td class="align_left center">{$lista.user_attr_cim_fax}</td>
               </tr>                             
            {/foreach}
        </table>
       {include file='page/all/view/page.paging.tpl'} 
	</form>
</div>