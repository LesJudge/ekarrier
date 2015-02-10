<div class="content clearfix">
    <div class="btn-nav-row">
		 <a href="{$DOMAIN}forum/{$kapcs_id}/bekuldes/"  class="btn btn-md btn-primary">Hozzászólás beküldése</a>
	</div>		
	
	<br >
	{foreach from=$data key=for_id item=item}
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title"><i class="icomoon icomoon-user"></i>{$item.bekuldo} <span class="badge">{$item.bekuldve_date}</span></h3></div>
		<div class="panel-body">
			<div class="clear">{$item.tartalom}</div>			
		</div>
	</div>		
	 {/foreach}
    
    <form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data"> 
        {include file='page/all/view/page.message.tpl'}
        {$Lista}
        {include file='page/all/view/page.paging.tpl'} 
    </form>
</div>