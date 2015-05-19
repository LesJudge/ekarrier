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


<div class="jobFindList-title-cont"><div class="jobFindList-title">{$pj.megnevezes}</div></div>
<div class="jobDataForm-cont">        
	<div class="row">
		<h3>	
		Hirdető:
		<span class="badge">
		{if $pj.egyedi eq 1}
			{$pj.hirdeto}
		{else}
			{$pj.nev}
		{/if}
		</span>
		</h3>
		<div class="clear"></div> 			
	</div>		
</div>

<br/>

<div id="allashirdetes-cols">
    <div class="allashirdetes-col">
        {if not empty($elvarasok)}
        <p class="allashirdetes-label">Elvárások:</p>
        <ul class="allashirdetes-ul">
            {foreach from=$elvarasok item=elvaras}
            <li>{$elvaras.elvaras}</li>
            {/foreach}
        </ul>
        {/if}
        {if not empty($munkakorok)}
        <p class="allashirdetes-label">Munkakörök:</p>
        <ul class="allashirdetes-ul">
            {foreach from=$munkakorok item=munkakor}
            <li>{$munkakor.munkakor_nev}</li>
            {/foreach}
        </ul>
        {/if}
        {if not empty($feladatok)}
        <p class="allashirdetes-label">Feladatok:</p>
        <ul class="allashirdetes-ul">
            {foreach from=$feladatok item=feladat}
            <li>{$feladat.feladat}</li>
            {/foreach}
        </ul>
        {/if}
        {if not empty($kompetenciak)}
        <p class="allashirdetes-label">Kompetenciák:</p>
        <ul class="allashirdetes-ul">
            {foreach from=$kompetenciak item=kompetencia}
            <li>{$kompetencia.nev}</li>
            {/foreach}
        </ul>
        {/if}
        {if not empty($amitKinalunk)}
        <p class="allashirdetes-label">Amit kínálunk:</p>
        <ul class="allashirdetes-ul">
            {foreach from=$amitKinalunk item=ak}
            <li>{$ak.amit_kinalunk}</li>
            {/foreach}
        </ul>
        {/if}
        {if not empty($munkakorok)}
        <p class="allashirdetes-label">Munkakörök:</p>
        <ul class="allashirdetes-ul">
            {foreach from=$munkakorok item=mk}
            <li>{$mk.munkakor_nev}</li>
            {/foreach}
        </ul>
        {/if}
        
        {if not empty($pj.munkavegzes_jellege)}
            <p class="allashirdetes-label">Munkavégzés jellege</p>
            <p class="allashirdetes-content">{$pj.munkavegzes_jellege}</p>
        {/if}
        {if not empty($pj.szektor_nev)}
            <p class="allashirdetes-label">Szektor:</p>
            <p class="allashirdetes-content">{$pj.szektor_nev}</p>
        {/if}
        {if not empty($pj.pozicio_nev)}
            <p class="allashirdetes-label">Pozíció:</p>
            <p class="allashirdetes-content">{$pj.pozicio_nev}</p>
        {/if}
    </div>
    <div class="allashirdetes-col">
        {if not empty($pj.cim_varos_nev) && not empty($pj.cim_megye_nev)}
            <p class="allashirdetes-label">Munkavégzés helye:</p>
            <p class="allashirdetes-content">{$pj.cim_megye_nev}</p>
            <p class="allashirdetes-content">{$pj.cim_varos_nev}</p>
        {/if}
        {if not empty($pj.jelentkezes_modja)}
            <p class="allashirdetes-label">Jelentkezés módja:</p>
            <p class="allashirdetes-content">{strip_tags($pj.jelentkezes_modja)}</p>
        {/if}
        {if $pj.jelentkezes_hatarideje != '0000-00-00'}
            <p class="allashirdetes-label">Jelentkezés határideje:</p>
            <p class="allashirdetes-content">{$pj.jelentkezes_hatarideje}</p>
        {/if}
        {if not empty($pj.munkaber)}
            <p class="allashirdetes-label">Munkabér:</p>
            <p class="allashirdetes-content">{$pj.munkaber}</p>
        {/if}
        {if not empty($pj.probaido)}
            <p class="allashirdetes-label">Próbaidő:</p>
            <p class="allashirdetes-content">{$pj.probaido}</p>
        {/if}
        {if $pj.munkakezdes_ideje != '0000-00-00'}
            <p class="allashirdetes-label">Munkakezdés ideje:</p>
            <p class="allashirdetes-content">{$pj.munkakezdes_ideje}</p>
        {/if}
        {if not empty($pj.egyeb)}
            <p class="allashirdetes-label">Egyéb:</p>
            <p class="allashirdetes-content">{$pj.egyeb}</p>
        {/if}
        {if $pj.letrehozas_timestamp != '0000-00-00'}
            <p class="allashirdetes-label">Hirdetés feladásának dátuma:</p>
            <p class="allashirdetes-content">{$pj.letrehozas_timestamp}</p>
        {/if}
        
    </div>
    <div class="clear"></div>
</div>
<!--div>{$pj.elvarasok}</div-->
<!--div>{$pj.tevekenyseg}</div-->

{if $markable}
<form name="{$FormName}" action="" method="post" enctype="multipart/form-data">
<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Kompetenciarajz választó</div></div>
<div class="jobDataForm-cont">
         <input id="postingJobId" name="postingJobId" type="hidden" value="{$pjId}" />
		<div class="row">
			<div class="col-lg-10">					
				{if !$isMarked}
				<select name="kRajzok" class='select-type-1'>
					 <option value="">--Válasszon kompetenciarajzai közül!--</option>
					 {foreach from=$kompetenciaRajzok item=kr}
					 <option value="{$kr.ID}">{$kr.nev}</option>
					 {/foreach}
				</select>
				{/if}			
				<div class="clear"></div> 					
    		</div> 
			<div class="col-lg-6 col-lg-offset-1">
				<button name="{if $isMarked}{$BtnUnmark}{else}{$BtnMark}{/if}" class="btn btn-primary btn-block" type="submit" value="1" style="margin:0.5em 0;">{$markItText}</button>
			</div>
			<div class="col-lg-6 col-lg-offset-1">
				<button name="{if $isFavourited}{$BtnUnfavourite}{else}{$BtnFavourite}{/if}" class="btn btn-primary btn-block" type="submit" value="1"  style="margin:0.5em 0; ">{$favouriteItText}</button>
			</div>
		</div>		
    </div>
</div>
</form>

<p><br/></p>	 
<a class="btn btn-lg btn-default pull-right" href="{$DOMAIN}" style="margin-right:-10px;">Irány a következő lépéshez<span class="btn-next-icon"><img src="images/site/next-bub-icon-1.png" alt="" /></span></a>
<div class="clear"></div>	
<p><br/><br/></p>
{/if}
