<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    {include file='page/all/view/page.message.tpl'}
    <div class="jobFindList-cont">
        <div class="jobFindList-top">
            <i class='icomoon icomoon-file3'>&nbsp;</i>
        </div>
        <div class="jobFindList-title">
            <a href="{$DOMAIN}{$routes.telephelyform}" class="bigBtn-link">Új telephely</a>
        </div>
        <br />
        {if $Lista}
			<table class="DTable">
				<tr class="DTable-head">
					<th class="textAlign-center">Ir.sz.</th>
					<th class="textAlign-center">Város</th>
					<th class="textAlign-center">Utca, Házszám</th>					
					<th class="textAlign-center">Megye</th>
					<th class="textAlign-center">Szerkeszt</th>
				</tr>				
				{foreach from=$Lista item=site name=site}			
				<tr class="DTable-tr DTable-tr-noBottomBorder">
					<td class="textHighlighting-1"> {$site.iranyitoszam}</td>
					<td class="textAlign-center"> {$site.varos}</td>					
					<td class="textAlign-center"> {$site.utca}, {$site.hazszam}</td>
					<td class="textAlign-center"> {$site.megye}</td>
					<td class="textAlign-center"><a href="{$DOMAIN}{$routes.telephelyform}{$site.ceg_telephely_id}" class="iconCont" title="Szerkesztés"><i class='icomoon icomoon-pencil'>&nbsp;</i></a></td>	
				</tr>							
				{/foreach}
			</table>	
		{/if}
        <div class="clear"></div>
    </div>
    {include file='page/all/view/page.paging.tpl'}
</form>