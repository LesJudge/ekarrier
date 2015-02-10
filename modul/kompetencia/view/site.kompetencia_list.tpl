<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-star3'>&nbsp;</i></div>
	<div class="jobFindList-title">{$topinfo.infobox_nev}</div>	
	<div class="jobFindList-data">{$topinfo.infobox_tartalom}</div>	
	<div class="clear"></div>
</div>
<br />

<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
		{include file='page/all/view/page.message.tpl'}

		{if $Lista}
		<table class="DTable">
			<tr class="DTable-head">
				<th>Kompetenciák</th>
				<th class="textAlign-right">Megtekintés &nbsp;&nbsp;&nbsp;&nbsp;</th>								
			</tr>				
			{foreach from=$Lista key=for_id item=competence}		
			<tr class="DTable-tr {if $competence.kompetencia_tartalom} DTable-tr-noBottomBorder {/if}">
				<td class="textHighlighting-1"> {$competence.kompetencia_nev}</td>									
				<td class="textAlign-right"> <a href="{$DOMAIN}kompetenciak/{$competence.kompetencia_link}" class="btn btn-sm btn-default" title="Megtekintés"><i class='icomoon icomoon-paste2'>&nbsp;</i> &nbsp;&nbsp; Kompetencia </a></td>
			</tr>	
			{if $competence.kompetencia_tartalom}		
			<tr class="DTable-tr">
				<td colspan="2"> {$competence.kompetencia_tartalom} </td>
			</tr>	
			{/if}			
			{/foreach}
		</table>
		{include file='page/all/view/page.paging.tpl'} 
		{/if}
</form>

