<div>{$text}</div>
<div>
	Eredmény: {$result}
</div>
<script type="text/javascript">
$(document).ready(function(){
    {if $result}
        var result = {$result};
        $( "#slider-vertical" ).slider({
          orientation: "vertical",
          range: false,
          disabled: true,
          min: 0,
          max: 18,
          value: result
        });
    {/if}
});

</script>

<br/>


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

<div id="slider-vertical" style="height:200px; float:left; margin-top: 25px;"></div>
 

