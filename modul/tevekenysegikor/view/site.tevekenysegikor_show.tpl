{include file="page/all/view/partial/jobTooltips.tpl"}
<h1 class="pageName">Ismerd meg a tevékenységi kört</h1>
<br /><br /><br />
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

<div class="jobDataForm-cont">
	<div class="jobDataForm-top"><i id='jobSearchForm_icon--profil_1--50--50--S1.5:1.5:0:0--fff--fff' class='svgIcon'>&nbsp;</i></div>	
	<p class="jobDataForm-head">{$jobData.Cim}</p>
	<div class="jobDataForm-content">{$jobData.Leiras}</div>
        {if $details != '1'}
            <a class="jobDataForm-btn" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}?details">Részletek</a>
        {else}
            <a class="jobDataForm-btn" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}">Kevesebb</a>
            {include file="modul/tevekenysegikor/view/partial/tevkor_details.tpl"}

        {/if}
	<div class="clear"></div>
        <p class="jobDataForm-head">Munkakörök</p>
        <div class="jobDataForm-content">
            {if not empty($munkakorok)}
            <ul>
            {foreach from=$munkakorok item=munkakor}
                <li>{$munkakor.Nev}</li>
            {/foreach}
            </ul>
            {else}
            Nincs megjeleníthető munkakör!
            {/if}
        </div>
        
        
        
        
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
        <p class="jobDataForm-head">Kompetenciák</p>
        <div class="jobDataForm-content">
            {if not empty($kompetenciak)}
            <ul>
            {foreach from=$kompetenciak item=kompetencia}
                <li>{$kompetencia.nev}</li>
            {/foreach}
            </ul>
            {else}
            Nincs megjeleníthető kompetencia!
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

	                

<div class="jobOffers-cont">
{foreach from=$offers item=offer}
    <div class="jobOffers">
        <div class="jobOffers-title">
            <a href="{$DOMAIN}allashirdetes/{$offer.link}/{$offer.allashirdetes_id}/">{$offer.megnevezes} - {$offer.munkakorNev}</a>
        </div>
    </div>
{foreachelse}
		<p>Nincs megjeleníthető álláshirdetés.</p>
{/foreach}

</div>

{foreach from=$markers item=marker}
    <div class="jobOffers">
        <div class="jobOffers-title">
            <a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$marker.krID}/">{$marker.uID}</a>
        </div>
    </div>
{foreachelse}
		<p>Még senki nem jelölte meg ezt a tevékenységi kört.</p>
{/foreach}




{if $marked == "marked"}
<div class="jobOffersList">
<form action="" method="post" name="{$FormName}" id="{$FormName}">
    Megjelölve ( {$markedWithCompRajz} )
    <button  class="submit btn ek-dolgozni-szeretnek-btn" name="{$BtnRemoveTevekenysegikor}" type="submit" style="width: 390px !important;">Mégsem szeretnék ebben a tevékenységi körben dolgozni!</button>
</form>
</div>    
{elseif $marked == "unmarked"}
<div class="jobOffersList">
	
            <form action="" method="post" name="{$FormName}" id="{$FormName}">
                <select name="kRajzok">
                 <option value="">--Válasszon kompetenciarajzai közül!--</option>
                 {foreach from=$kompetenciaRajzok item=kr}
                 <option value="{$kr.ID}">{$kr.nev}</option>
                 {/foreach}
                 </select>
		<button class="submit btn ek-dolgozni-szeretnek-btn" name="{$BtnAddTevekenysegikor}" type="submit" style="width: 390px !important;">Én is dolgozni szeretnék ebben a tevékenységi körben!</button>
            </form>
		
	
</div>
  {/if}          

            
<div class="clear"></div>
<style type="text/css">
.ek-dolgozni-szeretnek-btn {
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

{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}