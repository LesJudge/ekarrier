<div class="content clearfix">
    {if $isAuthorized}    
	<div class="btn-nav-row">
		 <a href="{$DOMAIN}forum/bekuldes/"  class="btn btn-md btn-primary">Fórum téma beküldése</a>
	</div>	
	
    <br/>
    <form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
        <div class="news-list-content">    
            {include file='page/all/view/page.message.tpl'}
            {foreach from=$Lista key=for_id item=lista}      
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title"><i class="icomoon icomoon-user"></i>{$lista.forum_bekuldo} <span class="badge">{$lista.bekuldve}</span></h3></div>
				<div class="panel-body">
					<div class="clear">{$lista.forum_tartalom}</div>					
					<ul class="list-group" style="display:inline-block;">
						{if $lista.sum_hozzaszolas}
							<li class="list-group-item">Utolsó hozzászólás: &nbsp; <span class="badge"> {$lista.last_hozzasszolas_date}</span></li>
							<li class="list-group-item">Eddigi hozzászólások száma: &nbsp; <span class="badge"> {$lista.sum_hozzaszolas}</span> </li>
						{/if}							
							<li class="list-group-item"> <a href="{$DOMAIN}forum/{$lista.forum_id}/" class="btn btn-md btn-primary">Hozzászólások</a></li>
					</ul>
				</div>
			</div>			
			{/foreach}
            {include file='page/all/view/page.paging.tpl'} 
        </div>
    </form>
    {else}
        <div class="alert-box">A fórum használatához be kell jelentkeznie!</div>
    {/if}
</div>