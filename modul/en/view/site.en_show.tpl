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

<style>
.fromTest{

float:left;
}
.IMG{
background-image: url('images/site/tests-icon.png');
background-size: contain;
width: 30px;
height: 30px;
float:left;
}

</style>

<br />
<br />
Megjelölt tevékenységi körök
<br />
{if not empty($myTevkorok)}
{foreach from=$myTevkorok item=tevkor}    
<div style="background-color: lightgray; margin-top: 2px;">
    <a href="{$DOMAIN}tevekenysegikor/{$tevkor.link}">{$tevkor.nev} - {$tevkor.datum}</a>
    
</div>
{/foreach}
{else}
Még nincs megjelölt tevékenységi kör!
{/if}

<br />
Megjelölt álláshirdetések
<br />
{if not empty($myMarkedJobs)}
{foreach from=$myMarkedJobs item=job}    
<div style="background-color: lightgray; margin-top: 2px;">
    <a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.ID}/">{$job.mkNev} - {$job.cegNev}- {$job.datum}</a>
    
</div>
{/foreach}
{else}
Még nincs megjelölt álláshirdetés!
{/if}



<br />
Kedvencként megjelölt álláshirdetések
<br />
{if not empty($myFavouriteJobs)}
{foreach from=$myFavouriteJobs item=job}    
<div style="background-color: lightgray; margin-top: 2px;">
    <a href="{$DOMAIN}allashirdetes/{$job.allasLink}/{$job.allasID}/">{$job.allasNev} - {$job.cegNev} - {$job.datum}</a>
    
</div>
{/foreach}

{else}
Még nincs kedvencként megjelölt álláshirdetés!
{/if}


<br />
Kompetenciarajzaim
<br />
{if not empty($myCompDraws)}
{foreach from=$myCompDraws item=draw}    
<div style="background-color: lightgray; margin-top: 2px;">
    
    <a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$draw.ID}/">{$draw.nev}</a>
    
</div>
{/foreach}

{else}
Még nincs elkészítve kompetenciarajz!
{/if}




<br />
Kompetenciáim
<br />
{if not empty($myComps)}
{foreach from=$myComps item=comp}    
<div style="background-color: lightgray; margin-top: 2px;">
    <div class="myComp-bg" style="background:{$comp['kompetencia_szinkod']}">&nbsp;</div>
    <a href="{$DOMAIN}kompetenciak/{$comp.kompetencia_link}">{$comp.kompetencia_nev}{if $comp.ugyfel_attr_kompetencia_tesztbol=="1"}<div class='myComp-test'><font color="red">Tesztből</font></div>{/if}</a>
    
</div>
{/foreach}

{else}
Még nincs felvéve kompetencia!
{/if}

<br />
Szektorteszt eredmény
<br />
{if not empty($mySectorTestResult)}
{foreach from=$mySectorTestResult item=result}    
<div style="background-color: lightgray; margin-top: 2px;">
    
    {$result.szektorNev}
    <form method="post" action="{$DOMAIN}szektorteszt/">
        <input type="hidden" name="view" value="1">
        <input type="hidden" name="finalResults" value="{$result.eredmeny}">
        <button type="submit">Eredmény megtekintése</button>
    </form>
</div>
{/foreach}

{else}
Még nincs elkészítve kompetenciarajz!
{/if}

<div>
Statisztikáim  
<br/>
{if $compRajzViewsAll > 0}
    Összesen {$compRajzViewsAll} tekintette meg kompetenciarajzaimat!<br/><br/>
{else}
{/if}

 {if not empty($compRajzViews)}
{foreach from=$compRajzViews key=key item=view}    
    {$key} Munkáltató tekintette meg a "{$view}" nevű kompetenciarajzomat<br/>
    

{/foreach}

{else}
Még nincs felvéve kompetenciarajz!
{/if}   

<br/>
{if not empty($tevkorStats)}
{foreach from=$tevkorStats key=key item=stat}    
    A(z) {$stat.nev} tevékenységi körhöz {$stat.ahDB} db álláshirdetés tartozik {if $stat.ahDB > $prevStat[$stat.ID]}
                                                                                ({$stat.ahDB - $prevStat[$stat.ID]} új)
                                                                                  {/if}<br/>
    

{/foreach}

{else}
Nincs megjeleníthető statisztika!
{/if} 


</div>


{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}