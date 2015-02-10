{foreach from=$data key=for_id item=item}
    {if $item.tartalom_szerzo}
        <span class="content_author">{$1_szerzo} <strong><em>{$item.tartalom_szerzo}</em></strong> </span>
    {/if}
    <div class="content clearfix">
    	{$item.tartalom_tartalom}
	</div>
{/foreach}

{if $kapcsolodo}
<div class="related-contents clearfix">
	<h2>Ezen oldalak is érdekelhetik Önt</h2>
	{foreach from=$kapcsolodo key=for_id item=item}
		<div class="related-contents-item clearfix">
			<a href="{$DOMAIN}{$item.tartalom_link}"> 
				{if $item.tartalom_kep_nev}
		           <span class="img">
					   <img class="form-pic" src="{$DOMAIN}pic/{$APP_PATH}/{$item.tartalom_kep_nev}_75x75" />
					</span>
		        {/if}
		        <span class="related_title"> {$item.tartalom_cim} </span>
			</a>
		</div>
	{/foreach}
</div>
{/if} 