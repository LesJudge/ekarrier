
<div>{$text}</div>
<div class="jobFindList-title-cont">
	<div class="jobFindList-title">Pozíció teszt eredménye <!--   {$result}  --></div> 	
	<div class="clear"></div>
</div>
<div class="jobFindList-cont">  
	<div class="row"> 	
		<div class="col-lg-8 col-lg-offset-1">
			<div class="connectedSortable  teszt-result">	
				<div class="designed-text-1">Pozíció/Vezetői teszt kitöltése utáni kompetenciák listája jelenik meg</div>	
				<div class="sortableItem-cont">              
					<div class="sortableItem sortableItem-2" style="cursor:default;">{$employee.nev}</div>										
					{if $result < 9}<div class="desc" style="text-align:justify;">{$employee.leiras|truncate:400:'...'}<br/><a href="{$DOMAIN}pozicio/vezeto/" class="next-link">Tovább a részletekhez</a></div>{/if}
				</div>	 
				<div class="sortableItem-cont">             
					<div class="sortableItem" style="cursor:default;">{$leader.nev}</div>										
					{if $result >= 9}<div class="desc"style="text-align:justify;">{$leader.leiras|truncate:400:'...'}<br/><a href="{$DOMAIN}pozicio/vezeto/" class="next-link">Tovább a részletekhez</a></div>{/if}
				</div>					 
			</div>
		</div>
		<div class="col-lg-7 col-lg-offset-2">
			<div class="teszt-result">
				<div class="connectedSortable">					 
					  {if $result >= 9}
							<div class="designed-text-1">Vezető pozíció kompetenciái</div>	
							{foreach from=$leaderComps item=comp}
							<div class="sortableItem-cont">        
								<a href="{$DOMAIN}kompetenciak/{$comp.link}" class="sortableItem" style="cursor:pointer;">{$comp.nev}</a>
							</div>
							{/foreach}
					  {/if}				  
					  {if $result < 9}
							<div class="designed-text-1"> Alkalmazott, beosztott pozíció kompetenciái</div>	
							{foreach from=$leaderComps item=comp}
							<div class="sortableItem-cont">        
								<a href="{$DOMAIN}kompetenciak/{$comp.link}" class="sortableItem" style="cursor:pointer;">{$comp.nev}</a>
							</div>
							{/foreach}
					  {/if}
				 </div>	
			</div>	   
		</div>
		<div class="col-lg-4 col-lg-offset-2">
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
			<div class="designed-text-1">Grafikon</div>	
			<div class="slider-vertical-cont">
				<div class="slider-vertical-flag slider-vertical-flag-1">Vezető</div>
				<div class="slider-vertical-flag slider-vertical-flag-2">Alkalmazott</div>
				<div id="slider-vertical"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>	
</div>

<!--a class="btn btn-sm btn-primary" href="{$DOMAIN}">Irány a következő lépéshez</a-->
{include file="page/all/view/partial/nextbutton_common.tpl"}




