<script type="text/javascript">
   $(function() {
   	$('.lapozas-num-on-page').click(function() {
   		$('select[name="{$SelPagingLimit.name}"]').val($(this).attr("name"));
   		$('#NumOnPage').click(); 
   	});
   });
</script>

    {if $Lapozas}
            <div class="row">
                <ul class="pagination pagination-sm pagination-sm" style="margin-top:2em;">
                {if $Lapozas.prev_item}			
                    <li><a href="{$Lapozas.url}{if $Lapozas.prev_item neq 1}{$Lapozas.urlvar}={$Lapozas.prev_item}{/if}">&laquo;</a></li>
                {else}
                    <li class="disabled"><a href="javascript:;">&laquo;</a></li>
                {/if}		
                {foreach from=$Lapozas.page key=id item=lap}
                    {if $lap.activ}	
                    <li class="active" ><a href="javascript:;" >{$lap.value}</a></li>
                    {else}
                    <li ><a href="{$Lapozas.url}{if $lap.value neq 1}{$Lapozas.urlvar}={$lap.value}{/if}">{$lap.value}</a></li>			
                    {/if}	
                {/foreach}	
                {if $Lapozas.next_item}
                    <li><a href="{$Lapozas.url}{$Lapozas.urlvar}={$Lapozas.next_item}">&raquo;</a></li>
                {else}
                    <li class="disabled"><a href="javascript:;">&raquo;</a></li>
                {/if}			
                </ul>
                <div class="lapozas_sep">A lista folytatódik a következő oldalon!</div>
            </div>    
        {/if}
   <div class="clearfix"></div>
   <ul class="pagination pagination-xs pagination-sm">
      {if !isset($No_SelTetel)}
		  {foreach from=$SelPagingLimit.values key=id item=lapozas}
			<li ><a href="javascript:;" class="{if $lapozas eq $SelPagingLimit.activ} active{/if}" name="{$lapozas}">{$lapozas}</a></li>
		  {/foreach}
		  	<li class="disabled">
				<span>elem/oldal</span>
				<div style="display:none;">
					 {html_options name=$SelPagingLimit.name options=$SelPagingLimit.values selected=$SelPagingLimit.activ}
					 <input class="submit" id="NumOnPage" type="submit" name="{$BtnNumOnPage}" value="elem" />
				</div>
			</li>		  
      {/if}
   </ul>

<p style="display:none;">
   <input class="submit" id="BtnRendez" type="submit" name="{$BtnRendez}" value="{$LANG["Rendez"]}"/>
   <input class="text" id="TxtSort" type="text" name="{$TxtSort.name}" value="{$TxtSort.activ}"/>
</p>
<div class="clear"></div>