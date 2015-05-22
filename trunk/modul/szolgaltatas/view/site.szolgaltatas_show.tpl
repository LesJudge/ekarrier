<script type="text/javascript">
  {if $loggedInAs == 'company'}  
    function selectAllInsideFolder(folder,thisItem){
        $('#clientsCont1_'+folder+' :input[type=checkbox]').prop('checked',true);
        thisItem.attr("onclick","un"+thisItem.attr("onclick"));
        thisItem.text('Kijelölés megszüntetése');        
    }
    
    function selectAllInsideFolder2(folder,thisItem){
        $('#clientsCont2_'+folder+' :input[type=checkbox]').prop('checked',true);
        thisItem.attr("onclick","un"+thisItem.attr("onclick"));
        thisItem.text('Kijelölés megszüntetése');       
    }
    
    function unselectAllInsideFolder(folder,thisItem){
        $('#clientsCont1_'+folder+' :input[type=checkbox]').prop('checked', false);
        thisItem.attr("onclick",thisItem.attr("onclick").substr(2));
        thisItem.text('Összes kijelölése');       
    }
    
    function unselectAllInsideFolder2(folder,thisItem){
        $('#clientsCont2_'+folder+' :input[type=checkbox]').prop('checked', false);
        thisItem.attr("onclick",thisItem.attr("onclick").substr(2));
        thisItem.text('Összes kijelölése');        
    }
    
    $(document).ready(function(){
        $('.folderCheckAll1').change(function(event){
            if($(event.target).prop('checked') === true){
                $('#clientsCont1_'+$(event.target).attr('target')+' input[type=checkbox]').prop('checked',true);
            }
            if($(event.target).prop('checked') === false){
                $('#clientsCont1_'+$(event.target).attr('target')+' input[type=checkbox]').prop('checked',false);
            }
        });
        
        $('.folderCheckAll2').change(function(event){
            if($(event.target).prop('checked') === true){
                $('#clientsCont2_'+$(event.target).attr('target')+' input[type=checkbox]').prop('checked',true);
            }
            if($(event.target).prop('checked') === false){
                $('#clientsCont2_'+$(event.target).attr('target')+' input[type=checkbox]').prop('checked',false);
            }
        });
    });
    {/if}
</script>


<table width="100%" cellspacing="0" cellpadding="0" border="0" class="h1-table">
	<tbody>
	<tr>
	<td class="h1-td">&nbsp;</td>
	<td class="h1-td-center"><h1>Szolgáltatások</h1></td>
	<td class="h1-td">&nbsp;</td>
	</tr>
	</tbody>
</table>

{if $FormError}
 <div class="info info-error">
    <p><img src="images/site/form-error.png" style="float:left; margin:5px;"/>{$FormError}</p>
</div> 
<div class="clear"></div>
{/if}
{if $FormMessage}
<div id="form_info" class="info info-success">
    <p>{$FormMessage}</p>
</div>
<div class="clear"></div>
{/if}

{if $textCompany}
    <div>{$textCompany}</div>
{elseif $textClient}
    <div>{$textClient}</div>
{/if}


{foreach from=$services item=service}
    <div onclick="$('#descCont_{$service.ID}').toggle();" class="accordionItem-title accordionItem-title-1">{$service.nev}</div>
    <div style="display:none;" id="descCont_{$service.ID}" class="accordionItem-main">
		 <div class="accordionItem-lead">{$service.leiras}</div>
		 
        {if $loggedIn === '1'}
            {if $loggedInAs == 'company'}
                <form name="form_{$service.ID}" action="" method="post">
                    <input type="hidden" value="{$service.ID}" name="serviceID">
                       
					   <div class="row">
							<div class="col-lg-4"></div>
							<div class="col-lg-6"><a class="btn btn-block btn-default btn-md" href="javascript:;" onClick="$('#mentettKereseseim-content').appendTo('BODY').modal('show');">Mentett kereséseim</a></div>
							<div class="col-lg-4"></div>
							<div class="col-lg-6"><a class="btn btn-block btn-default btn-md" href="javascript:;" onClick="$('#mentettMappaim-content').appendTo('BODY').modal('show');">Mentett mappáim</a></div>
							<div class="col-lg-4"></div>
						</div>	
												
						<div class="modal fade" id="mentettKereseseim-content" tabindex="-1" role="dialog" aria-labelledby="popUpLoginForm" aria-hidden="true">
							<div class="modal-dialog default-modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>			
									  <h4>Mappáim</h4>						 
									</div>											
									<div class="modal-body">	
										{foreach from=$folders item=folder key=key}
											<div class="folderItem">
												<input type="checkbox" target="{$key}_{$service.ID}" class="folderCheckAll1 folderItem-chk">							
												<div id="folder1_{$key}_{$service.ID}" class="folderItem-label">{$folder.nev}</div>		
												<div class="clear"></div>									
												<div id="clientsCont1_{$key}_{$service.ID}" class="folderItem-content">											
													{foreach from=$folder.ugyfelek item=ugyfel}
															{if $ugyfel}
															<div class="folderItem-sub">
																<input type='checkbox' name='{$service.ID}clients[]' value='{$ugyfel.uID}' class="folderItem-sub-chk">
																<a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/" target="_blank" class="folderItem-sub-map">{$ugyfel.uID}/{$ugyfel.krID}</a>
															</div>
															{/if}
													{/foreach}
													<div class="clear"></div>			
													{if $folder.ugyfelek}<button onclick="selectAllInsideFolder('{$key}_{$service.ID}',$(this))" class="btn btn-default btn-md">Összes kijelölése</button>{/if}	
												</div>
											</div>	
										{/foreach}	
										<div class="clear"></div>
										<div class="folderItem-controls">
											{if $service.ID|in_array:$pendingOrders}    
												<button type="submit" disabled='disabled' class="btn btn-primary btn-md">Megrendelve</button>
											{else}
												<button type="submit" name="{$BtnOrderService}" class="btn btn-primary btn-md">Megrendelem a szolgáltatást</button>
											{/if} 
										</div>
									</div>										
								</div>
							</div>
						</div>
					
						<div class="modal fade" id="mentettMappaim-content" tabindex="-1" role="dialog" aria-labelledby="popUpLoginForm" aria-hidden="true">
							<div class="modal-dialog default-modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>			
									  <h4>Mappáim</h4>						 
									</div>											
									<div class="modal-body">	
										{foreach from=$myJobs item=job key=key}
											<div class="folderItem">
												<input type="checkbox" target="{$key}_{$service.ID}" class="folderCheckAll2 folderItem-chk" />				
												<div id="folder2_{$key}_{$service.ID}" class="folderItem-label">{$job.munkakor} - {$job.markerCnt} fő</div>	
												<div class="clear"></div>										
												<div id="clientsCont2_{$key}_{$service.ID}" class="folderItem-content">											
													{foreach from=$job.ugyfelek item=ugyfel}
															{if $ugyfel}
															<div class="folderItem-sub">
																<input type='checkbox' name='{$service.ID}clientsMarkers[]' class="folderItem-sub-chk" value='{$ugyfel.uID}'>
																<a target="_blank" href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/" class="folderItem-sub-map">{$ugyfel.uID}/{$ugyfel.krID}</a>		
															</div>															
															{/if}
													{/foreach}	
													<div class="clear"></div>													
													{if $job.ugyfelek}<button onclick="selectAllInsideFolder2('{$key}_{$service.ID}',$(this))" class="btn btn-default btn-md">Összes kijelölése</button>	{/if}
												</div>
											</div>		
										{/foreach}	
										<div class="clear"></div>
										<div class="folderItem-controls">
											{if $service.ID|in_array:$pendingOrders}    
												<button type="submit" disabled='disabled' class="btn btn-primary btn-md">Megrendelve</button>
											{else}
												<button type="submit" name="{$BtnOrderService}" class="btn btn-primary btn-md">Megrendelem a szolgáltatást</button>
											{/if} 
										</div>	
									</div>										
								</div>
							</div>
						</div>                    
                </form>
             {/if}
             {if $loggedInAs == 'client'}
                <form name="form_{$service.ID}" action="" method="post">
                    <input type="hidden" value="{$service.ID}" name="clientServiceID">
                    {if $service.ID|in_array:$pendingOrders}    
                        <button type="submit" disabled='disabled'>Megrendelve</button>
                    {else}
                        <button type="submit" name="{$BtnOrderClientService}">Megrendelem a szolgáltatást</button>
                    {/if}
                </form>
             {/if}
        {else}
                <a href='{$DOMAIN}{$regLink}' title='Regisztráció szükséges'>Megrendelem a szolgáltatást</a>
        {/if}
    </div>
{/foreach}
