{if $Error}
{$Error}
{else}
<div>{$text}</div>

<div class="jobFindList-title-cont">
	<div class="jobFindList-title">Szektor teszt eredménye</div> 	
	<div class="clear"></div>
</div>
<div class="jobFindList-cont">  
	<div class="row"> 	
		<div class="col-lg-9 col-lg-offset-2">
			<div class="teszt-result-data-title">Szektor teszt kitöltése utáni szektor sorrend</div>	
			<div class="connectedSortable teszt-result">				
				{foreach from=$Scores key=key item=val}     
				<div class="sortableItem-cont">             
					<div class="sortableItem" onClick="
					$(this).next('div').toggle(); 
					$('#comps').html('');
					$(this).parent().find('.resultComps').clone().prependTo($('#comps')); 
					">{$Scores[$key]['eredmeny']}</div>										
					{if $val@iteration == 1}
						<div class="desc">{$Scores[$key]['leiras']|truncate:400:'...'}<br/><a href="{$DOMAIN}szektor/{$Scores[$key]['szektor_id']}" class="btn btn-primary btn-sm">Tovább a részletekhez</a></div>
					{else}
						<div style="display:none;" class="desc">{$Scores[$key]['leiras']|truncate:400:'...'}<br/><a href="{$DOMAIN}szektor/{$Scores[$key]['szektor_id']}" class="btn btn-primary btn-sm">Tovább a részletekhez</a></div>
					{/if}
					<div style="display:none;">
						<div class="resultComps">
							<div class="teszt-result-data-title">{$Scores[$key]['eredmeny']}</div>
							{foreach from=$Scores[$key]['kompetencia'] item=val}
								<div class="teszt-result-data">{$val}</div>
							{/foreach}
						</div>
					</div>  
				</div>	                                     
				{/foreach}
			</div>			
		</div>
		<div class="col-lg-9 col-lg-offset-2">
			<form id="resultForm" action="{$DOMAIN}kompetenciak/kompetenciarajz/" method="post">
			<div id="comps" class="teszt-result" >				
				<div class="resultComps">					
					{foreach from=$Scores[0]['kompetencia'] item=val}
						<div class="teszt-result-data">{$val}</div>
					{/foreach}						
				</div>
			</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>	
</div>

<a class="btn btn-sm btn-primary" href="{$DOMAIN}">Irány a következő lépéshez</a>

<!--br/><br/><br/><br/><br/>

<div class="jobDataForm-cont hiddenLabels">
	<div class="jobDataForm-top"><i class="icomoon icomoon-signup">&nbsp;</i></div>	
	<div class="jobFindList-title">Legjellemzőbb: {$Scores[0]['eredmeny']}</div>	
    <div class="jobFindList-data">{$Scores[0]['leiras']}</div>	
	<div class="clear"></div>
</div>

<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-info2'>&nbsp;</i></div>
	<div class="jobFindList-title">{$topinfo.infobox_nev}</div>	
	<div class="jobFindList-data">{$topinfo.infobox_tartalom}</div>	
	<div class="clear"></div>
</div>

<br/><br/-->

<!--div id="tabs">
    <ul>
    {foreach from=$MainResKat key=key item=val}
        <li><a href="#tabs{$key}">{$val['szektor_nev']}</a></li>
    {/foreach}
    </ul>
    {foreach from=$MainResKat key=key item=val}
        <div id="tabs{$key}">
            <p>{$val['szektor_leiras']}</p>
            <p><span>Kompetenciák: </span></p>
            {foreach from=$Kompetenciak key=key2 item=val2}
                {if $val['szektor_id']==$val2['szektorid']}
                    <div class='compDialog' id='dial_opener{$key2}' title='{$val2['nev']}'>{$val2['tartalom']}</div>
                    <div id='opener{$key2}' class='opener'>{$val2['nev']}</div>
                    <div id='opener{$key2}_nev' class="hidden">{$val2['nev']}</div>
                    <div id='opener{$key2}_tartalom' class="hidden">{$val2['tartalom']}</div>
                {/if}
            {/foreach}
  </div>
    {/foreach}
</div-->
<!--div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-info2'>&nbsp;</i></div>
	<div class="jobFindList-title">{$bottominfo.infobox_nev}</div>	
	<div class="jobFindList-data"> {$bottominfo.infobox_tartalom}</div>	
	<div class="clear"></div>
</div-->

<br />

<!--div class="btn-nav-row">
	<button onClick="$('#resultForm').submit();" class="btn btn-lg btn-primary">Elkészítem</button>
</div-->

<div id="compDetailsDialog"></div>

<script type="text/javascript">
$(document).ready(function() {

        $("#compDetailsDialog").dialog({ autoOpen: false, modal:true });
        
        $("body").on("click",".opener", function(){
            $("#compDetailsDialog").html("");
            $("#compDetailsDialog").dialog('option', 'title', $('#'+this.id+'_nev').html());
            $("#compDetailsDialog").append($('#'+this.id+'_tartalom').html());
            $("#compDetailsDialog").dialog( "open" );
        });
        
  });
  
</script>   
{/if}