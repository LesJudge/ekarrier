{if not empty($Lista)}
    <div class="jobFindList-top"><i class='icomoon icomoon-drawer3'>&nbsp;</i></div>
    <div class="jobFindList-title">Találati eredmények</div>
    <div class="job-list-container">
        <div class="jobFindList-cont">
            <div id="paging_container1">
                <div class="page_navigation"></div>
                <ul class="content">
                    {foreach from=$Lista item=job name=job}
                        <li>
                            <div class="job-list-row">
                                <div class="job-list-col-name">
                                    <a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.allashirdetes_id}/">{$job.munkakor} - {$job.tevKor} - {$job.tevCsoport}</a>
                                </div>
                            </div>
                        </li>
                    {/foreach}
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
{/if}

{if not empty($cegek)}
    <div class="jobFindList-top"><i class='icomoon icomoon-drawer3'>&nbsp;</i></div>
    <div class="jobFindList-title">Találati eredmények</div>
    <div class="job-list-container">
        <div class="jobFindList-cont">
            <div id="paging_container2">
                <div class="page_navigation"></div>
                <ul class="content">
                    {foreach from=$cegek item=ceg}
                        <li>
                            <div class="job-list-row">
                                <div class="job-list-col-name">
                                    <a href="{$DOMAIN}munkaltato/{$ceg.link}">{$ceg.cegnev}</a>
                                </div>
                            </div>
                        </li>
                    {/foreach}
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
{/if}