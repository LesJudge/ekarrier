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
<table id="allashirdetes-table">
    <tr>
        <td>Megnevezés:</td>
        <td>{$pj.megnevezes}</td>
    </tr>
    <tr>
        <td>Hirdető:</td>
        <td>
            {if $pj.egyedi eq 1}
            {$pj.hirdeto}
            {else}
            {$pj.nev}
            {/if}
        </td>
    </tr>
    <!--tr>
        <td>Leírás:</td>
        <td>{strip_tags($pj.ismerteto)}</td>
    </tr-->
</table>
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
    {if !$isMarked}
    <select name="kRajzok">
                 <option value="">--Válasszon kompetenciarajzai közül!--</option>
                 {foreach from=$kompetenciaRajzok item=kr}
                 <option value="{$kr.ID}">{$kr.nev}</option>
                 {/foreach}
    </select>
    {/if}
    <input id="postingJobId" name="postingJobId" type="hidden" value="{$pjId}" />
    <button name="{if $isMarked}{$BtnUnmark}{else}{$BtnMark}{/if}" class="submit btn" type="submit" value="1">{$markItText}</button>
    <button name="{if $isFavourited}{$BtnUnfavourite}{else}{$BtnFavourite}{/if}" class="submit btn" type="submit" value="1">{$favouriteItText}</button>
    <a class="btn btn-sm btn-primary" href="{$DOMAIN}fooldal/">Irány a következő lépéshez</a>
    <!--a class="btn btn-sm btn-primary" href="" onclick="history.go(-1);">Vissza</a-->
    
</form>
{/if}
<style type="text/css">
#allashirdetes-table {
    margin-bottom: 40px !important;
    margin-top: 26px !important;
}
#allashirdetes-table td:first-child {
    font-weight: bold;
    width: 10%;
}
#allashirdetes-table td {
    text-align: left;
}
#allashirdetes-table,
#allashirdetes-cols {
    margin: 0 auto;
    width: 90%;
}
#allashirdetes-cols .allashirdetes-col {
    float: left;
    width: 50%;
}
p.allashirdetes-label {
    font-size: 14px;
    font-style: italic;
    font-weight: bold;
    margin: 0px;
    padding-bottom: 1em;
}
p.allashirdetes-content {
    margin: 0px;
    padding-bottom: 32px;
}
ul.allashirdetes-ul {
    padding-bottom: 14px;
    padding-left: 36px;
}
</style>