
<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-drawer3'>&nbsp;</i></div>
	<div class="jobFindList-title">Találati eredmények</div>
	<div class="job-list-container">
		{foreach from=$Lista item=job name=job}
			<div class="job-list-row">
				<div class="job-list-col-name">
					<a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/">{$job.megnevezes}</a>
				</div>
				<div class="job-list-col-county">{$job.cim_megye_nev}</div>
				<div class="job-list-col-controlled">
				{if $job.ellenorzott}<i class="icomoon icomoon-checkmark-circle checked">&nbsp;</i>{else}<i class="icomoon icomoon-cancel-circle unchecked">&nbsp;</i>{/if}
				</div>
			</div>
		{/foreach}
	</div>
	<div class="clear"></div>
</div>
