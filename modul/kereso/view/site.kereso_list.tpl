<div class="content clearfix">
	<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
		<h2>{$keresoszo}</h2>
	    <div class="news-list-content">    
	        {include file='page/all/view/page.message.tpl'}
	                {foreach from=$Lista key=for_id item=lista}
	                    <div class="datalist-row clearfix">
	                    	<a href="{$lista.link}" style="float:none;">
								<h2>{$lista.cim}</h2>
							</a>
	                        {if $lista.kep_nev}
	                            <a href="{$lista.link}" style="float:none;">
									<span class="img">    
		                                <img src="{$DOMAIN}pic/{$lista.kep_nev}_75x75" />
		                            </span>
         						</a>
	                        {/if}
	                        <span class="news-content">{$lista.leiras}</span>
	                        <a href="{$lista.link}">Tovább</a>
	                   </div>  
	                {/foreach}
	       {include file='page/all/view/page.paging.tpl'} 
	    </div>
	</form>
</div>