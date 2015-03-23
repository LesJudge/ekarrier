<div class="jobFindList-cont">
	Eredmény: {$result}
</div>

<script type="text/javascript">
$(document).ready(function(){
    var result = {$result};
    
    if(result >= 0 && result <= 18){
        var base = parseInt($('#marker').css('margin-top'));
        result = result/18;
        $('#marker').css('margin-top',base-(base*result)+'px');
        $('#marker').css('display','inline');
    }

});

</script>
<style>

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
<br/>


<!--div class="jobFindList-title">{$topinfo.infobox_nev}</div-->	
<div class="jobFindList-data">{$topinfo.infobox_tartalom}</div>

<ul class="">
    
    <li onClick="$(this).children(':first-child').next().toggle();" class="position" id="leader">
      <div>{$leader.nev}</div>
      <div class="descCont" style="{if $result < 9}display: none;{/if}">{$leader.leiras|truncate:400:'...'}<a href="{$DOMAIN}pozicio/vezeto/">Tovább a részletekhez</a></div>
    </li>
    <li onClick="$(this).children(':first-child').next().toggle();" class="position" id="employee">
      <div>{$employee.nev}</div>
      <div style="{if $result >= 9}display: none;{/if}">{$employee.leiras|truncate:400:'...'}<a href="{$DOMAIN}pozicio/alkalmazott/">Tovább a részletekhez</a></div>
    </li>

</ul>

<div id="compsCont">
    <div id="leaderComps" class="comps" style="{if $result < 9}display: none;{/if}">
        Vezető pozíció kompetenciái: <br/>
        {foreach from=$leaderComps item=comp}
            <a href="{$DOMAIN}kompetenciak/{$comp.link}">{$comp.nev}</a><br/>
        {/foreach}
    </div>
    <div id="employeeComps" class="comps" style="{if $result >= 9}display: none;{/if}">
        Alkalmazott, beosztott pozíció kompetenciái: <br/>
        {foreach from=$employeeComps item=comp}
            <a href="{$DOMAIN}kompetenciak/{$comp.link}">{$comp.nev}</a><br/>
        {/foreach}
    </div>
</div>

<script type="text/javascript">
$('body').on('click','.position', function(){
    $('.comps').hide();
    $('#'+$(this).attr('id')+'Comps').show();

});

</script>



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
 

