{include file="page/all/view/partial/jobTooltips.tpl"}
<style type="text/css">
.ek-job-main {
    clear: both;
    font-size: 16px;
    font-weight: bold;
    display: block;
    margin-bottom: 15px;
    margin-top: 10px;
}
.ek-job-sub {
    
}
</style>

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
<form action="" method="POST" name="{$FormName}" id="{$FormName}" enctype="multipart/form-data">
    <div class="jobDataForm-cont">
        
        <!--input type="text" name="{$TxtSearchByName.name}" value="{$TxtSearchByName.activ}"-->
        
        <div class="filter_row">
		<label for="{$FilterCsoport.name}">Csoport</label>
		{html_options name=$FilterCsoport.name options=$FilterCsoport.values selected=$FilterCsoport.activ}
		<div class="clear"></div> 
        </div>
                
        <div class="filter_row">
		<label for="{$FilterKor.name}">Kör</label>
		{html_options name=$FilterKor.name options=$FilterKor.values selected=$FilterKor.activ}
		<div class="clear"></div> 
        </div>
               
        <div class="filter_row">
		<label for="{$FilterSzektor.name}">Szektor</label>
		{html_options name=$FilterSzektor.name options=$FilterSzektor.values selected=$FilterSzektor.activ}
		<div class="clear"></div> 
        </div>
                
        <div class="filter_row">
		<label for="{$FilterPozicio.name}">Pozíció</label>
		{html_options name=$FilterPozicio.name options=$FilterPozicio.values selected=$FilterPozicio.activ}
		<div class="clear"></div> 
        </div>
                
        <input class="submit" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="Keresés">
        <input class="submit" type="submit" name="{$BtnFilterDEL}" value="Feltételek törlése">
        <div class="clear"></div>
    </div>
        
            
</form>
<div class="jobFindList-cont">
    <div class="jobFindList-top"><i class='icomoon icomoon-file3'>&nbsp;</i></div>
    <div class="jobFindList-title">Találati eredmények</div>
    {include file='page/all/view/page.message.tpl'}
    {if not empty($Lista)}
    {foreach from=$Lista item=munkakor}
    <div class="jobFindList-block">
        {$munkakor.munkakor_nev} - <font color="red">{$munkakor.korCim}</font> - <font color="blue">{$munkakor.csoportCim}</font> - {$munkakor.subCatID}
        <a href="{$DOMAIN}tevekenysegikor/{$munkakor.tevkorLink}">Részletek</a>
        <div class="clear"></div>
    </div>
    {/foreach}
    {/if}
    <div class="clear"></div>
    {include file='page/all/view/page.paging.tpl'}
</div>

{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}
