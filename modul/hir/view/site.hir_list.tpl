<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">	     
	{include file='page/all/view/page.message.tpl'}
	{foreach from=$Lista key=for_id item=lista name=hir_lista}	
	<div class="commentItem row">
		{if $lista.hir_kep_nev}
		<div class="col-lg-4">
			<a href="hirek/{$lista.hir_link}" class="newsList-frame">
				<img class="newsList-img" alt="{$lista.hir_cim}" src="{$DOMAIN}pic/{$APP_PATH}/{$lista.hir_kep_nev}_104x68" />
			</a>
		</div>
		{/if}
		<div class="col-lg-20 {if $lista.hir_kep_nev}col-lg-24{/if}">
			<div class="commentItem-name">{$lista.hir_cim}</div>
			<div class="commentItem-date">{$lista.hir_datum}</div>
			<div class="commentItem-text">
				<div class="pull-right">
					<a class="commentItem-next btn" href="hirek/{$lista.hir_link}">Részletek <i class="glyphicon glyphicon-chevron-right"></i></a>					
				</div>
				{$lista.hir_leiras}
				<div class="clear"></div>
			</div>
		</div>	
	</div>	                   
	{/foreach}		
	{include file='page/all/view/page.paging.tpl'} 	   
</form>
