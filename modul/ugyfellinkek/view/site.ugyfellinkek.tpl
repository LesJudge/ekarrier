{if $linkMode}
<style type="text/css">
	.default-modal-dialog { width:380px; }
</style>
<script type="text/javascript">
$(function(){
	$(".addUsefullLinks").click(function(){ $('#hasznosLinkek-content').appendTo('BODY').modal('show') });
});
</script>
<div class="modal fade" id="hasznosLinkek-content" tabindex="-1" role="dialog" aria-labelledby="popUpLoginForm" aria-hidden="true">
	<div class="modal-dialog default-modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>			
			  <h4>Hasznos link hozzáadása</h4>						 
			</div>											
			<div class="modal-body">					
				{if $addLinkOption}					
					<div id="linkFormCont">
						<form name="{$FormName}" method="post" action="">							
							<input type="text" id="linkName" name="linkName" maxlength="50" autocomplete="off" placeholder="Név*" class="form-control"/>							
							<input type="text" id="linkUrl" name="linkUrl" maxlength="200" autocomplete="off" placeholder="URL*" class="form-control"/>
							<div class="clear"></div>
							<button class="btn btn-primary btn-md btn-block" name="{$BtnAddLink}" id="{$BtnAddLink}" type="submit">Hozzáadás </button>
						</form>
					</div>
				{/if}
				<div class="clear"></div>				
			</div>										
		</div>
	</div>
</div>          

{/if}
	