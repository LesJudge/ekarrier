
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="h1-table">
	<tbody>
	<tr>
	<td class="h1-td">&nbsp;</td>
	<td class="h1-td-center"><h1>{$companyData.nev}</h1></td>
	<td class="h1-td">&nbsp;</td>
	</tr>
	</tbody>
</table>

<div class="content clearfix">

	{if $FormError}
	 <div class="info info-error">
		<p><img src="images/site/form-error.png" style="float:left; margin:5px;"/>{$FormError}</p>
	</div> 
	<div class="clear"></div>
	{/if}
	{if $FormMessage}
	<div id="form_info" class="info info-success">
		<p>{$FormMessage}</p>
	</div>
	<div class="clear"></div>
	{/if}
    {if $companyData.ceg_kep}
        <img src="{$DOMAIN}pic/enceg/{$companyData.ceg_kep}_380x265_2" class="pull-left" style="margin:0em 1em 0.5em 0em; width:25%;" />
    {/if}
    {$companyData.tartalom}
	
	<div class="clear"></div>
	
    <!--
        <div class="jobDataForm-content">{$companyData.nev} - {$companyData.szhely}</div>	
        {if not empty($sites)}
        Telephelyek
        {foreach from=$sites item=site}
        <div class="jobDataForm-content">{$site.thely}</div>	
        {/foreach}
        {/if}
        <div class="jobDataForm-content">{$companyData.tartalom}</div>		
		<div class="clear"></div>	
    -->
</div>

 {if $jobs}

	{foreach from=$jobs item=job name=job}	
	<div class="row box-block-1">
		<div class="col-lg-20">
			<div class="designedText-1">{$job.munkakor} - {$job.subCat} - {$job.mainCat}</div>
           <div class="data-">{$job.ismerteto}</div>		 
			<!--
				<a class="dataLink" href="{$DOMAIN}munkakorok/{$job.munkakor_link}">{$job.munkakor_nev}</a>
				<a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/" class="iconCont" title="Megtekintés"></a>
			-->
			<div class="clear"></div>
		</div>
		<div class="col-lg-4"><a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.ahID}/" class="btn btn-primary btn-sm pull-right">Megtekintés</a><div class="clear"></div></div>
		<div class="clear"></div>		
	</div>	
   {/foreach}
	
</div>
{else}
 <p class="formMessage">Nincs megjeleníthető állásajánlat!</p>
{/if}
<br />
<!--a href="{$DOMAIN}munkaltato/" class="bigBtn-link">Vissza a munkáltatókhoz!</a-->
{if $loggedInAs === 'client'}
    <a class="btn btn-md btn-default btn-pull-left " href="{$DOMAIN}allaskereses/">Vissza a keresőhöz</a>
{/if}

{if $loggedInAs === 'company'}
    <a class="btn btn-md btn-default btn-pull-left " href="{$DOMAIN}enprofil/">Szerkeszt</a>
{/if}
<br/><br/>
<div class="clear"></div>