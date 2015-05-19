{if not empty($Lista)}
<div class="jobFindList-title-cont"><div class="jobFindList-title">Találati eredmények</div></div>
<div class="jobFindList-cont">   
	<div id="paging_container1">		
		{foreach from=$Lista item=job name=job}
		<div class="jobFindList-block">
			<span class="jobFindList-item-type-1">{$job.munkakor}</span> - {$job.tevKor} - {$job.tevCsoport}
			<a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/" class="btn btn-primary btn-sm">Részletek</a>
			<div class="clear"></div>
		</div>
		{/foreach}
		<div class="page_navigation"></div>
	</div>
</div>	
{/if}

{if not empty($cegek)}
<div class="jobFindList-title-cont"><div class="jobFindList-title">Találati eredmények</div></div>
<div class="jobFindList-cont">   
	<div id="paging_container2">		
		{foreach from=$cegek item=ceg}
		<div class="jobFindList-block">
			<span class="jobFindList-item-type-1">{$ceg.cegnev}
			<a href="{$DOMAIN}munkaltato/{$ceg.link}" class="btn btn-primary btn-sm">Részletek</a>
			<div class="clear"></div>
		</div>
		{/foreach}
		<div class="page_navigation"></div>
	</div>
</div>	
{/if}


