<script type="text/javascript">
$(function() { {$FormScript}
    $('select[name="{$FilterStatus.name}"]').change(function() { $('#{$BtnFilter}').click(); });
    $('select[name="{$FilterOldal.name}"]').change(function() { $('#{$BtnFilter}').click(); });
    $('select[name="{$FilterPozicio.name}"]').change(function() { $('#{$BtnFilter}').click(); });
    $('#{$FilterDatumTol.name},#{$FilterDatumIg.name}').datetimepicker();
});
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
	<div class="box_top">
		<h2 class="icon pages">Bannerek</h2>
		<ul class="sorting">
        	{include file='page/admin/view/admin.list_events.tpl'} 
		</ul>
	</div>
    <div class="box_content">    
        {include file='page/admin/view/admin.message.tpl'}
        <div class="form_filter">
            <label for="{$FilterSzuro.name}">{php}echo LANG_AdminFilter_szuro;{/php}:</label>
            <input type="text" id="{$FilterSzuro.name}" name="{$FilterSzuro.name}"  value="{$FilterSzuro.activ}" style="width:162px;" class="filter-input"/>
            <input type="text" id="{$FilterDatumTol.name}" name="{$FilterDatumTol.name}"  value="{$FilterDatumTol.activ}" readonly="readonly" style="width:120px;" class="tip" readonly="readonly" title="Dátum (-tól)"/>
            <input type="text" id="{$FilterDatumIg.name}" name="{$FilterDatumIg.name}"  value="{$FilterDatumIg.activ}" readonly="readonly" style="width:120px;" class="tip" readonly="readonly" title="Dátum (-ig)"/>            
            <input class="submit" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="{php}echo LANG_AdminFilter_kereses;{/php}"/>
            <input class="submit" type="submit" name="{$BtnFilterDEL}" value="{php}echo LANG_AdminFilter_alaphelyzet;{/php}"/>
        </div>
        <div class="top_filtering">
            {html_options name=$FilterStatus.name options=$FilterStatus.values selected=$FilterStatus.activ}
            {html_options name=$FilterOldal.name options=$FilterOldal.values selected=$FilterOldal.activ}
            {html_options name=$FilterPozicio.name options=$FilterPozicio.values selected=$FilterPozicio.activ}
        	<div class="clear"></div>
        </div>
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
	            <tr class="data_row">
	                <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"/></th>
	                <td class="align_left"><a href="{$APP_LINK}/edit/{$lista.ID}{$LANG_PARAM}" title="Módosítás">{$lista.elso}</a></td>
	                <td class="align_left center">
						{if $lista.banner_kep_nev}
	                        <img class="form-pic" src="{$DOMAIN}pic/{$APP_PATH}/{$lista.banner_kep_nev}_100x100"/>
	                    {else}
	                    	 {$lista.banner_kod}
	                    {/if}
	                </td>
	                <td class="align_left center">{$lista.banner_link}</td>                        
	                <td class="align_left center">{$POZICIO_AZ_OLDALON[$lista.banner_pozicio]}</td>
	                <td class="align_left center">{$lista.megjelenes}</td>
	                <td class="align_left center">{$lista.lejarat}</td>
	                <td class="align_left center">
	                    {if $lista.Aktiv}
	                        <button id="statusz_{$for_id}" title="Visszavonás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan visszavonja a bannert', 'Visszavonja a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnUnpublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-locked">Visszavonás</span></button>
	                    {else}
	                        <button id="statusz_{$for_id}" title="Publikálás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan publikussá teszi a bannert', 'Publikussá teszi a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnPublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-unlocked">Publikálás</span></button>
	                    {/if}
	                </td>
	           </tr>                             
            {/foreach}
        </table>
       {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>