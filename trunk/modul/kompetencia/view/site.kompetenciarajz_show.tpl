<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>
<br />
<h2>{$compRajzAuthor}</h2>

<h2>{$compRajzTitle}</h2>

<div class="jobFindList-cont">
	<div class="jobFindList-data">	
		<div class="jobFindList-title textAlign-center">Kompetenciáim</div>	
		<ul id="myComps" class='sortable2 sortedUL'>
			{foreach from=$compRajzCompetences item=val}
			<li class='fixed'>
				<div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
				<div class='myComp'>{$val['kompetencia_nev']}</div>			
				<div class="clear"></div>
				<div>
                                {$val['valasz']}
				</div>				
			</li>
			{/foreach}
		</ul>	
	</div>
	<div class="clear"></div>
</div> 




                
<script type='text/javascript'>
$(document).ready(function(){
   
});
</script>
