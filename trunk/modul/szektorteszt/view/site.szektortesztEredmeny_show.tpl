{if $Error}
{$Error}
{else}
 
<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-numbered-list'>&nbsp;</i></div>	
	<div class="jobFindList-data">
	
		<div class="connectedSortable-cont">  			
			<ul class="connectedSortable teszt-result">
				<li class="active">Legjellemzőbb szektor:</li>	
				{foreach from=$Scores key=key item=val}
                                        <div>
					<li onClick="$(this).next('div').toggle(); $('#comps').html('');$(this).parent().find('.resultComps').clone().prependTo($('#comps')); ">{$Scores[$key]['eredmeny']}</li>
                                            
                                                {if $val@iteration == 1}
                                                <div style="" class="desc">{$Scores[$key]['leiras']|truncate:400:'...'}<a href="{$DOMAIN}szektor/{$Scores[$key]['szektor_id']}">Tovább a részletekhez</a></div>
                                                {else}
                                                <div style="display:none;" class="desc">{$Scores[$key]['leiras']|truncate:400:'...'}<a href="{$DOMAIN}szektor/{$Scores[$key]['szektor_id']}">Tovább a részletekhez</a></div>
                                                {/if}
                                                <div style="display:none;">
                                                <div class="resultComps">
                                                    {$Scores[$key]['eredmeny']}
                                                    {foreach from=$Scores[$key]['kompetencia'] item=val}
                                                        <li class="teszt-result-data">{$val}</li>
                                                    {/foreach}
                                                </div>
                                                </div>
                                        </div>
                                        
				{/foreach}
			</ul>	
			<form id="resultForm" action="{$DOMAIN}kompetenciak/kompetenciarajz/" method="post">
			<ul class="connectedSortable teszt-result">
				<div id="comps">
                                    {$Scores[0]['eredmeny']}
                                    {foreach from=$Scores[0]['kompetencia'] item=val}
                                        <li class="teszt-result-data">{$val}</li>
                                    {/foreach}
                                    
                                </div>
			</ul>
			</form>
			<div class="clear"></div>
		</div> 
	
	</div>	
	<div class="clear"></div>
</div>
 
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