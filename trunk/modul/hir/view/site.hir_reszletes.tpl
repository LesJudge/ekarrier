{foreach from=$data key=for_id item=item}
    <span class="content_author news-date clearfix">
		{$item.megjelenes}
		{if $item.hir_szerzo}<strong> &#149; <em>{$item.hir_szerzo}</em></strong>{/if}
	</span>
     <div class="content">
     	{$item.hir_tartalom}
    </div>
{/foreach}
{if $kapcsolodo}
	<div class="related-contents clearfix">
		<h2>Ezen hírek is érdekelhetik Önt</h2>
		{foreach from=$kapcsolodo key=for_id item=item}
			<div class="related-contents-item clearfix">
				<a href="{$DOMAIN}hirek/{$item.hir_link}" class="clearfix"> 
					{if $item.hir_kep_nev}
			           <span class="img">
						   <img class="form-pic" src="{$DOMAIN}pic/{$APP_PATH}/{$item.hir_kep_nev}_75x75" />
						</span>
			        {/if}
			        <span class="related_title"> {$item.hir_cim} </span>
				</a>
			</div>
		{/foreach}
	</div>
{/if} 