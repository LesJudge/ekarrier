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
<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-info2'>&nbsp;</i></div>
	<div class="jobFindList-title">{$topinfo.infobox_nev}</div>	
	<div class="jobFindList-data">{$topinfo.infobox_tartalom}</div>	
	<div class="clear"></div>
</div>

<br/>
<br/>
<br/>
<br/>

<div class="jobDataForm-cont hiddenLabels">
	<div class="jobDataForm-top"><i class="icomoon icomoon-signup">&nbsp;</i></div>	
    <div class="jobFindList-data">{$leftinfo.infobox_tartalom}</div>	
	<div class="clear"></div>
</div>

<br/>
<br/>

<div class="btn-nav-row">
<a href="{$DOMAIN}szektorteszt/" class="btn btn-lg btn-primary">{$leftinfo.infobox_nev}</a>
</div>

<div class="btn-nav-row">
<a href="{$DOMAIN}pozicioteszt/" class="btn btn-lg btn-primary">{$rightinfo.infobox_nev}</a>
</div>

{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}