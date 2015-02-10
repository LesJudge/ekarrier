{if not $isArchive}
<div>
    <a href="{$DOMAIN}allaskereses/archivum/" class="bigBtn-link">Archívum</a>
</div>
<br />
{/if}
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    <div class="jobDataForm-cont hiddenLabels">
        <div class="jobDataForm-top"><i class='icomoon icomoon-search'>&nbsp;</i></div>
        <div class="form-cell-1">
            <div>
                <label>Szektor</label>
                {html_options name=$FilterSector.name id=$FilterSector.name options=$FilterSector.values selected=$FilterSector.activ}
            </div>
            <div>
                <label>Pozíció</label>
                {html_options name=$FilterPosition.name id=$FilterPosition.name options=$FilterPosition.values selected=$FilterPosition.activ}
            </div>
        </div>
        <div class="form-cell-1">
            <div>
                <label>Munkakör</label>
                {html_options name=$FilterJob.name id=$FilterJob.name options=$FilterJob.values selected=$FilterJob.activ}
            </div>
            <div>
                <label>Megye</label>
                {html_options name=$FilterCounty.name id=$FilterCounty.name options=$FilterCounty.values selected=$FilterCounty.activ}			
            </div>
        </div>
        <div class="form-cell-1">
            <div>
                <label for="{$FilterCity.name}">Város</label>    
                <input id="{$FilterCity.name}" name="{$FilterCity.name}" type="text" value="{$FilterCity.activ}" alt="" placeholder="Város" class="labelInField"  />
            </div>
        </div>
        <div class="form-cell-1">
            <div>
                {html_options name=$FilterEllenorzott.name id=$FilterEllenorzott.name options=$FilterEllenorzott.values selected=$FilterEllenorzott.activ}	
            </div>
        </div>
        <div class="form-cell-1">
            <input type="submit" value="Keres" class="submit btn-1" />			
        </div>
        <div class="form-cell-1">
            <input name="{$BtnFilterDEL}" class="submit btn-1" type="submit" value="Feltételek törlése" />
        </div>
        <div class="clear"></div>
    </div>
    {include file='page/all/view/page.message.tpl'}
    {include file='modul/allashirdetes/view/partial/site_allashirdetes_list.tpl'}
    {include file='page/all/view/page.paging.tpl'} 
</form>