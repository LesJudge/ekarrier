
<div><a href="{$DOMAIN}allaskereses/archivum/" class="bigBtn-link">Archívum</a></div><br />
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    {include file='modul/allaskereses/view/partial/site.allashirdetes_kereso.tpl'}
    {include file='page/all/view/page.message.tpl'}
    {include file='modul/allaskereses/view/partial/site.allashirdetes_list.tpl'}
    {include file='page/all/view/page.paging.tpl'} 
</form>


<!--
<form id="jobSearchForm" name="jobSearchForm" method="post" action="">
<div class="jobDataForm-cont">
	<div class="jobDataForm-top"><i class='icomoon icomoon-search'>&nbsp;</i></div>
	{foreach from=$categories item=category}
	<div class="jobDataForm-block">
		<input id="job{$category.id}" name="Job[{$category.id}]" type="checkbox" value="{$category.id}" />
		<label for="job{$category.id}">{$category.menu_nev} ({$category.cnt_munkakor})</label>
	</div>
	{/foreach}
	<div class="clear"></div>
	<input type="submit" value="Keres" class="submit" />	
</div>
	
	
	
{if $foundJobs}
<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-file3'>&nbsp;</i></div>
	<div class="jobFindList-title">Találati eredmények</div>
	{foreach from=$foundJobs item=job}
	<div class="jobFindList-block">
		{$job.munkakor_nev}
		<a href="{$DOMAIN}munkakorok/{$job.munkakor_link}">Részletek</a>
		<div class="clear"></div>
	</div>
	{/foreach}
	<div class="clear"></div>
</div>
{/if}
</form>
-->