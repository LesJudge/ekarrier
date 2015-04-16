
<h1 class="pageName">{$pageName}</h1>
{if $FormError}
 <div class="info info-error">
    <p>{$FormError}</p>
</div> 
<div class="clear"></div>
{/if}

{if $FormMessage}
<div id="form_info" class="info info-success">
    <p>{$FormMessage}</p>
</div>
<div class="clear"></div>
{/if}

{if $marked == "marked"}
   <button type="button" class="btn btn-default btn-md" onClick="$('#{$BtnRemoveTevekenysegikor}').click();">Mégsem szeretnék ebben a tevékenységi körben dolgozni!</button> 
{elseif $marked == "unmarked"}
   <button type="button" class="btn btn-default btn-md" onClick="$('#{$BtnAddTevekenysegikor}').click();">Én is dolgozni szeretnék ebben a tevékenységi körben!</button>
{/if} 

<br /><br />
<div>{$text}</div>

<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Tevékenységi kör leírása</div><i class="write-icon"></i></div>
<div class="jobFindList-cont">    
    <div class="jobFindList-data-1">{$jobData.Leiras}</div>
	{if $descriptionDetails != '1'}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}?descriptiondetails">Részletek</a>
	{else}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}">Kevesebb</a>	
		{include file="modul/tevekenysegikor/view/partial/tevkor_details.tpl"}
	{/if}
</div>

<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Tevékenységi körhöz tartozó munkakörök listája</div><i class="write-icon"></i></div>
<div class="jobFindList-cont">        
	{if not empty($munkakorok)}
	<div class="jobFindList-data-1">
		<ul class="list-group">
		  {foreach from=$munkakorok item=munkakor}<li class="list-group-item">{$munkakor.Nev}</li>{/foreach}
		</ul>	
	</div>		
	{else}
		<div class="no-content">Nincs megjeleníthető munkakör!</div>
	{/if}
</div>

<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Feladatok</div><i class="write-icon"></i></div>
<div class="jobFindList-cont">     
	{if not empty($feladatok)}
	<div class="jobFindList-data-1">
		<ul class="list-group">
		  {foreach from=$feladatok item=feladat}<li class="list-group-item">{$feladat.feladat}</li>{/foreach}
		</ul>	
	</div>			
	{else}
		<div class="no-content">Nincs megjeleníthető feladat!</div>
	{/if}
	{if $tasksDetails != '1'}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}?tasksdetails">Részletek</a>
	{else}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}">Kevesebb</a>	
		{include file="modul/tevekenysegikor/view/partial/tevkor_tasks_comments.tpl"}
	{/if}	
</div>

<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Elvárások</div><i class="write-icon"></i></div>
<div class="jobFindList-cont">      
	{if not empty($elvarasok)}
	<div class="jobFindList-data-1">
		<ul class="list-group">
		  {foreach from=$elvarasok item=elvaras}<li class="list-group-item">{$elvaras.elvaras}</li>{/foreach}
		</ul>
	</div>				
	{else}
		<div class="no-content">Nincs megjeleníthető elvárás!</div>
	{/if}
	{if $expDetails != '1'}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}?expdetails">Részletek</a>
	{else}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}">Kevesebb</a>	
		{include file="modul/tevekenysegikor/view/partial/tevkor_exp_comments.tpl"}
	{/if}	
</div>

<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Tevékenységi körhöz kapcsolódó kompetenciák</div><i class="write-icon"></i></div>
<div class="jobFindList-cont">    
	{if not empty($kompetenciak)}
	<div class="jobFindList-data-1">
		<ul class="list-group">
		  {foreach from=$kompetenciak item=kompetencia}<li class="list-group-item">{$kompetencia.nev}</li>{/foreach}
		</ul>
	</div>				
	{else}
		<div class="no-content">Nincs megjeleníthető kompetencia!</div>
	{/if}
	{if $compDetails != '1'}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}?compdetails">Részletek</a>
	{else}
		<a class="btn-default btn-sm" href="{$DOMAIN}tevekenysegikor/{$jobData.Link}">Kevesebb</a>	
		{include file="modul/tevekenysegikor/view/partial/tevkor_comp_comments.tpl"}
	{/if}		
</div>


<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Álláshírdetések</div></div>
<div class="jobFindList-cont">    
	<div class="row">
		<div class="col-lg-12">
			<div class="jobFindList-data-2">Kiválasztott tevékenységi körhöz tartozó álláshirdetések.</div>
			{foreach from=$offers item=offer}
				<a href="{$DOMAIN}allashirdetes/{$offer.link}/{$offer.allashirdetes_id}/" class="btn btn-default btn-block">{$offer.megnevezes} - {$offer.munkakorNev}</a>					
			{foreachelse}
				<div class="no-content">Nincs megjeleníthető álláshirdetés.</div>
			{/foreach}
		</div>
		<div class="col-lg-12">
			<div class="jobFindList-data-2">Erre a tevékenységi körre jelentkezettek:</div>
			{foreach from=$markers item=marker}
				<a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$marker.krID}/" class="btn btn-default btn-block">{$marker.uID}/{$marker.krID}</a>					
			{foreachelse}
				<div class="no-content">Még senki nem jelölte meg ezt a tevékenységi kört.</div>
			{/foreach}
			<div class="clear"></div>
			
			{if $marked == "marked"}
				<div class="jobOffersList">
				<form action="" method="post" name="{$FormName}" id="{$FormName}">
					Megjelölve ( {$markedWithCompRajz} )
					<button  class="submit btn ek-dolgozni-szeretnek-btn" name="{$BtnRemoveTevekenysegikor}" id="{$BtnRemoveTevekenysegikor}" type="submit" >Mégsem szeretnék ebben a tevékenységi körben dolgozni!</button>
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
						<button class="submit btn ek-dolgozni-szeretnek-btn" name="{$BtnAddTevekenysegikor}" id="{$BtnAddTevekenysegikor}" type="submit">Én is dolgozni szeretnék ebben a tevékenységi körben!</button>
					</form>
				</div>
			{/if}			
		</div>
	</div>
</div>

<!--	                

<div class="jobOffers-cont">
{foreach from=$offers item=offer}
    <div class="jobOffers">
        <div class="jobOffers-title">
            <a href="{$DOMAIN}allashirdetes/{$offer.link}/{$offer.allashirdetes_id}/">{$offer.megnevezes} - {$offer.munkakorNev}</a>
        </div>
    </div>
{foreachelse}
		<div class="no-content">Nincs megjeleníthető álláshirdetés.</div>
{/foreach}

</div>

{foreach from=$markers item=marker}
    <div class="jobOffers">
        <div class="jobOffers-title">
            <a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$marker.krID}/">{$marker.uID}/{$marker.krID}</a>
        </div>
    </div>
{foreachelse}
		<div class="no-content">Még senki nem jelölte meg ezt a tevékenységi kört.</div>
{/foreach}

-->
<a class="btn btn-sm btn-primary" href="{$DOMAIN}fooldal/">Irány a következő lépéshez</a>
<a class="btn btn-sm btn-primary" href="{$DOMAIN}tevekenysegikor-kereso/">Vissza a keresőhöz</a>
  
  
<div class="clear"></div>

