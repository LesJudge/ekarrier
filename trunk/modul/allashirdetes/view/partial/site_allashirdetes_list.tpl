{if not empty($Lista)}
<div class="jobFindList-cont">
    <div class="jobFindList-top"><i class='icomoon icomoon-drawer3'>&nbsp;</i></div>
    <div class="jobFindList-title">Találati eredmények</div>
    <div class="job-list-container">
        {foreach from=$Lista item=job name=job}
        <div class="job-list-row">
            <div class="job-list-col-name">
                <a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/">{$job.megnevezes} - {$job.tevKor}({$job.tevKorID}) - {$job.tevCsoport}({$job.tevCsoportID})</a>
            </div>
            <div class="job-list-col-county">
                {if $job.cim_megye_nev != null}
                {$job.cim_megye_nev}
                {else}
                -
                {/if}
            </div>
            <div class="job-list-col-controlled">
            {if $job.ellenorzott}<i class="icomoon icomoon-checkmark-circle checked">&nbsp;</i>{else}<i class="icomoon icomoon-cancel-circle unchecked">&nbsp;</i>{/if}
            </div>
        </div>
        {/foreach}
    </div>
    <div class="clear"></div>
</div>
 
{/if}

<div class="jobFindList-cont">
    <div class="jobFindList-top"><i class='icomoon icomoon-drawer3'>&nbsp;</i></div>
    <div class="jobFindList-title">Találati eredmények</div>
    {foreach from=$cegek item=ceg}
        <div class="job-list-row">
                <div class="job-list-col-name">
                    <a href="{$DOMAIN}munkaltato/{$ceg.link}">{$ceg.cegnev}</a>
                </div>


            </div>
    {/foreach}
    
    
    
    <!--div class="job-list-container">
        {$id = 0}
        {foreach from=$Lista item=job name=job}
            
            {if $id != $job.cegID}
            <div class="job-list-row">
                <div class="job-list-col-name">
                    <a href="{$DOMAIN}munkaltato/{$job.cegLink}">{$job.cegNev}</a>
                </div>


            </div>
            {$id = $job.cegID}
            {/if}  
        {/foreach}
    </div-->
    <div class="clear"></div>
</div>