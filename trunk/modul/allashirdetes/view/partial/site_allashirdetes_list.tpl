{if not empty($Lista)}
    <div class="jobFindList-cont">
        <div class="jobFindList-top"><i class='icomoon icomoon-drawer3'>&nbsp;</i></div>
        <div class="jobFindList-title">Találati eredmények</div>
        <div class="job-list-container">
            {foreach from=$Lista item=job name=job}
            <div class="job-list-row">
                <div class="job-list-col-name">
                    <a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/">{$job.munkakor} - {$job.tevKor} - {$job.tevCsoport}</a>
                </div>
            </div>
            {/foreach}
        </div>
        <div class="clear"></div>
    </div> 
{/if}

{if not empty($cegek)}
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

        <div class="clear"></div>
    </div>
{/if}