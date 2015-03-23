<script type="text/javascript">
$(document).ready(function(){
    var result = {$myPositionTestResult[0].pont};
    
    if(result >= 0 && result <= 18){
        var base = parseInt($('#marker').css('margin-top'));
        result = result/18;
        $('#marker').css('margin-top',base-(base*result)+'px');
        $('#marker').css('display','inline');
    }

});

</script>
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

#graphCont{
    width: 110px;
    height: 350px;
    //border: 1px solid blue;
}


#graph{
    width: 50px;
    height: 300px;
    border: 1px solid black;
    float: left;
    position: relative;
    margin-top: 25px;
    
    background: #46ba46; /* Old browsers */
    background: -moz-linear-gradient(top, #46ba46 0%, #f17432 44%, #f17432 44%, #ea5507 52%, #feccb1 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#46ba46), color-stop(44%,#f17432), color-stop(44%,#f17432), color-stop(52%,#ea5507), color-stop(100%,#feccb1)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, #46ba46 0%,#f17432 44%,#f17432 44%,#ea5507 52%,#feccb1 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, #46ba46 0%,#f17432 44%,#f17432 44%,#ea5507 52%,#feccb1 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top, #46ba46 0%,#f17432 44%,#f17432 44%,#ea5507 52%,#feccb1 100%); /* IE10+ */
    background: linear-gradient(to bottom, #46ba46 0%,#f17432 44%,#f17432 44%,#ea5507 52%,#feccb1 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#46ba46', endColorstr='#feccb1',GradientType=0 ); /* IE6-9 */
}

#marker{
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 25px 50px 25px 0;
    border-color: transparent #007bff transparent transparent;
    float: right;
    position: relative;
    margin-top: 300px;
    display: none;
}

#half {
  border-top: 1px dotted #f00;
  color: #fff;
  background-color: #fff;
  height: 1px;
  width:100%;
  position: absolute;
  top: 50%;
}

#half2 {
  border-top: 1px dotted #f00;
  color: #fff;
  background-color: #fff;
  height: 1px;
  width:100%;
  position: absolute;
  top: 25%;
}

#half3 {
  border-top: 1px dotted #f00;
  color: #fff;
  background-color: #fff;
  height: 1px;
  width:100%;
  position: absolute;
  top: 75%;
}

</style>


<a class="btn btn-sm btn-primary" href="{$DOMAIN}uzeneteim/">Üzeneteim {if $newMessage > 0}({$newMessage} új){/if}</a>
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
Nincs pozícióteszt eredmény!
{/if}

<br />
Pozíció eredmény
<br />
{if not empty($myPositionTestResult)}

 {if $myPositionTestResult[0].pont >= 9 && $myPositionTestResult[0].pont <= 18}
 Vezető
 {elseif $myPositionTestResult[0].pont < 9 && $myPositionTestResult[0].pont >= 0}
Alkalmazott
 {/if}
    <form method="post" action="{$DOMAIN}pozicioteszt/">
        <input type="hidden" name="view" value="1">
        <input type="hidden" name="result" value='{$myPositionTestResult[0].eredmeny}'>
        <button type="submit">Eredmény megtekintése</button>
    </form>

<div id="graphCont">
    <div id="graph">
        <div id="half">
        </div>
        <div id="half2">
        </div>
        <div id="half3">
        </div>
    </div>
    <div id="marker">
    </div>
    
</div>

{else}
Nincs pozícióteszt eredmény!
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
    {$view} Munkáltató tekintette meg a "{$key}" nevű kompetenciarajzomat<br/>
    

{/foreach}

{else}
Nincs megjeleníthető statisztika!
{/if}   

<br/>
{if not empty($tevkorStats)}
{foreach from=$tevkorStats key=key item=stat}    
    A(z) {$stat.nev} tevékenységi körhöz {$stat.ahDB} db álláshirdetés tartozik {if $stat.uj > 0}
                                                                                ({$stat.uj} új)
                                                                                  {/if}<br/>
    

{/foreach}

{else}
Nincs megjeleníthető statisztika!
{/if} 


</div>


