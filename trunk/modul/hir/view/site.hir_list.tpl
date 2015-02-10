<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">	     
	{include file='page/all/view/page.message.tpl'}
	{foreach from=$Lista key=for_id item=lista name=hir_lista}
	<div class="newsList">						
		<a href="hirek/{$lista.hir_link}" class="newsList-frame"><img class="newsList-img" alt="{$lista.hir_cim}" src="{if $lista.hir_kep_nev}{$DOMAIN}pic/{$APP_PATH}/{$lista.hir_kep_nev}_104x68{else}images/site/no_image.jpg{/if}" /></a>
		<div class="newsList-data">
			<a href="hirek/{$lista.hir_link}" class="newsList-title">{$lista.hir_cim}</a>
			<div class="newsList-lead">{$lista.hir_leiras}</div>
			<a href="hirek/{$lista.hir_link}" class="newsList-next">Részletek</a>
		</div>
		<div class="clear"></div>
	</div>                         
	{/foreach}		
	{include file='page/all/view/page.paging.tpl'} 	   
</form>
