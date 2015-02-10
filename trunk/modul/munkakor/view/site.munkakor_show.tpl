{include file="page/all/view/partial/jobTooltips.tpl"}
<h1 class="pageName">Ismerd meg a munkakört</h1>
<br /><br /><br />
<div class="jobDataForm-cont">
	<div class="jobDataForm-top"><i id='jobSearchForm_icon--profil_1--50--50--S1.5:1.5:0:0--fff--fff' class='svgIcon'>&nbsp;</i></div>	
	<p class="jobDataForm-head">{$jobData.munkakor_nev}</p>
	<div class="jobDataForm-content">{$jobData.munkakor_tartalom}</div>
	<a class="jobDataForm-btn" href="{$DOMAIN}munkakorok/{$jobData.munkakor_link}/kiegeszit/tartalom">Egészítsd ki Te is</a>	
	<div class="clear"></div>
        <p class="jobDataForm-head">Elvárások</p>
        <div class="jobDataForm-content">
            {if not empty($elvarasok)}
            <ul>
            {foreach from=$elvarasok item=elvaras}
                <li>{$elvaras.elvaras}</li>
            {/foreach}
            </ul>
            {else}
            Nincs megjeleníthető elvárás!
            {/if}
        </div>
        <p class="jobDataForm-head">Feladatok</p>
        <div class="jobDataForm-content">
            {if not empty($feladatok)}
            <ul>
            {foreach from=$feladatok item=feladat}
                <li>{$feladat.feladat}</li>
            {/foreach}
            </ul>
            {else}
            Nincs megjeleníthető feladat!
            {/if}
        </div>
	<!--
	<p class="jobDataForm-head">Elvárások</p>
	<div class="jobDataForm-content">{$jobData.munkakor_tartalom}</div>
	<a class="jobDataForm-btn" href="{$DOMAIN}munkakorok/{$jobData.munkakor_link}/kiegeszit/elvarasok">Egészítsd ki Te is</a>
	<div class="clear"></div>		
	-->
</div>
<div class="clear"></div>               
<a class="bigBtn-link bigBtn-link-1" href="{$DOMAIN}kompetenciak/tesztek">Kompetencia felmérő</a>
<a class="bigBtn-link bigBtn-link-2" href="{$DOMAIN}kompetenciak/kompetenciarajz/">Kompetencia rajz készítő</a>
<div class="clear"></div>
	                

<div class="jobOffers-cont">
{foreach from=$offers item=offer}
    <div class="jobOffers">
        <div class="jobOffers-title">
            <a href="{$DOMAIN}allashirdetes/{$offer.link}/{$offer.allashirdetes_id}/">{$offer.megnevezes}</a>
        </div>
        <div class="jobOffers-lead">{$offer.cim_megye_nev}</div>
    </div>
{foreachelse}
		<p>Nincs megjeleníthető álláshirdetés.</p>
{/foreach}
<a href="{$DOMAIN}allaskereses/" class="jobOffers-cont-go-to-job-ads bigBtn-link">Tovább az álláshirdetéskre!</a>
</div>
<div class="jobOffersList">
	<ul>
            <form action="" method="post" name="{$FormName}" id="{$FormName}">
		<button id="ek-dolgozni-szeretnek-btn" class="submit btn" name="{$BtnAddMunkakor}" type="submit">Én is dolgozni szeretnék ebben a munkakörben</button>
            </form>
		<!--<li>Item</li>
		<li>Item</li>
		<li>Item</li>-->
	</ul>
</div>
<div class="clear"></div>
<style type="text/css">
#ek-dolgozni-szeretnek-btn {
    margin: 0 auto;
    position: relative;
    top: 36px;
    width: 330px;
}
.jobOffers-cont .jobOffers-cont-go-to-job-ads {
    font-size: 1em;
    margin-top: 16px;
}
</style>
