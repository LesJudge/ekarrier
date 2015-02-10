
<div class="jobDataForm-cont">
	<div class="jobDataForm-top"><i id='jobSearchForm_icon--document_1--50--50--S1.5:1.5:0:0--fff--fff' class='svgIcon'>&nbsp;</i></div>	
	<div class="jobDataForm-content">{$companyData.tartalom}</div>		
	<div class="clear"></div>	
</div>

 {if $jobs}
<div class="jobFindList-cont">
	<div class="jobFindList-top"><i id='jobFindList_icon--factory--48--48--S1.4:1.4:0:0--fff--fff' class='svgIcon'>&nbsp;</i></div>	
	<br />
	{foreach from=$jobs item=job name=job}
	<div class="jobFindList-block">
		<div class="jobFindList-name">
			<a class="dataLink" href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/">{$job.megnevezes} - {$job.letrehozas_timestamp}</a>
                        <a class="dataLink" href="{$DOMAIN}munkakorok/{$job.munkakor_link}">{$job.munkakor_nev}</a>
			<a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/" class="iconCont" title="Megtekintés">
				<i id='jobFindListEditBtn_{$smarty.foreach.job.index}--document_1--24--24--S0.7:0.7:0:0--000--000' class='svgIcon'>&nbsp;</i>
			</a>
			<div class="clear"></div>
		</div>
		<div class="jobFindList-content">{$job.ismerteto}</div>			
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
        {/foreach}
	
</div>
{else}
 <p class="formMessage">Nincs megjeleníthető állásajánlat!</p>
{/if}
<br />
<a href="{$DOMAIN}munkaltato/" class="bigBtn-link">Vissza a munkáltatókhoz!</a>