
<div>{$text}</div>
<div class="jobFindList-title-cont">
	<div class="jobFindList-title">Eredmény: {$result} </div> 	
	<div class="clear"></div>
</div>
<div class="jobFindList-cont">  
	<div class="row"> 	
		<div class="col-lg-9 col-lg-offset-2">
			<div class="connectedSortable  teszt-result">		
				<div class="sortableItem-cont">             
					<div class="sortableItem" style="cursor:default;">{$leader.nev}</div>										
					{if $result >= 9}<div class="desc"style="text-align:justify;">{$leader.leiras|truncate:400:'...'}<br/><a href="{$DOMAIN}pozicio/vezeto/" class="btn btn-primary btn-sm">Tovább a részletekhez</a></div>{/if}
				</div>	
				<div class="sortableItem-cont">              
					<div class="sortableItem" style="cursor:default;">{$employee.nev}</div>										
					{if $result < 9}<div class="desc" style="text-align:justify;">{$employee.leiras|truncate:400:'...'}<br/><a href="{$DOMAIN}pozicio/vezeto/" class="btn btn-primary btn-sm">Tovább a részletekhez</a></div>{/if}
				</div>	  
			</div>
		</div>
		<div class="col-lg-9 col-lg-offset-2">
			<div class="teszt-result">
				<div class="resultComps">					 
					  {if $result >= 9}
							 <div class="teszt-result-data-title">Vezető pozíció kompetenciái:</div>	
							{foreach from=$leaderComps item=comp}
							<div class="teszt-result-data">
								<a href="{$DOMAIN}kompetenciak/{$comp.link}">{$comp.nev}</a>
							</div>
							{/foreach}
					  {/if}				  
					  {if $result < 9}
							<div class="teszt-result-data-title"> Alkalmazott, beosztott pozíció kompetenciái:</div>	
							{foreach from=$leaderComps item=comp}
							<div class="teszt-result-data">
								<a href="{$DOMAIN}kompetenciak/{$comp.link}">{$comp.nev}</a>
							</div>
							{/foreach}
					  {/if}
				 </div>	
			</div>	   
		</div>
		<div class="clear"></div>
	</div>	
</div>

<a class="btn btn-sm btn-primary" href="{$DOMAIN}">Irány a következő lépéshez</a>

<!--
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
<div id="slider-vertical" style="height:200px; float:left; margin-top: 25px;"></div>
-->
 

