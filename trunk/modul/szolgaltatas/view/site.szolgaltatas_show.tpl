<script type="text/javascript">
  {if $loggedInAs == 'company'}  
    function selectAllInsideFolder(folder){
        $('#clientsCont1_'+folder+' :input[type=checkbox]').prop('checked',true);
        $(event.target).attr("onclick","un"+$(event.target).attr("onclick"));
        $(event.target).text('Kijelölés megszüntetése');
        event.preventDefault();
    }
    
    function selectAllInsideFolder2(folder){
        $('#clientsCont2_'+folder+' :input[type=checkbox]').prop('checked',true);
        $(event.target).attr("onclick","un"+$(event.target).attr("onclick"));
        $(event.target).text('Kijelölés megszüntetése');
        event.preventDefault();
    }
    
    function unselectAllInsideFolder(folder){
        $('#clientsCont1_'+folder+' :input[type=checkbox]').prop('checked', false);
        $(event.target).attr("onclick",$(event.target).attr("onclick").substr(2));
        $(event.target).text('Összes kijelölése');
        event.preventDefault();
    }
    
    function unselectAllInsideFolder2(folder){
        $('#clientsCont2_'+folder+' :input[type=checkbox]').prop('checked', false);
        $(event.target).attr("onclick",$(event.target).attr("onclick").substr(2));
        $(event.target).text('Összes kijelölése');
        event.preventDefault();
    }
    
    $(document).ready(function(){
        $('.folderCheckAll1').change(function(){
            if($(event.target).prop('checked') === true){
                $('#clientsCont1_'+$(event.target).attr('target')+' input[type=checkbox]').prop('checked',true);
            }
            if($(event.target).prop('checked') === false){
                $('#clientsCont1_'+$(event.target).attr('target')+' input[type=checkbox]').prop('checked',false);
            }
        });
        
        $('.folderCheckAll2').change(function(){
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
    <div onclick="$('#descCont_{$service.ID}').toggle();">{$service.nev}</div><br/>
    <div style="display: none" id="descCont_{$service.ID}">{$service.leiras}
        {if $loggedIn === '1'}
            {if $loggedInAs == 'company'}
                <form name="form_{$service.ID}" action="" method="post">
                    <input type="hidden" value="{$service.ID}" name="serviceID">
                        {foreach from=$folders item=folder key=key}
                            <input type="checkbox" target="{$key}_{$service.ID}" class="folderCheckAll1" style="float: left;">
                            <div id="folder1_{$key}_{$service.ID}" onclick="$('#clientsCont1_{$key}_{$service.ID}').toggle();" class="folderCont">{$folder.nev}</div>
                            <div class="clear"></div>
                            <div id="clientsCont1_{$key}_{$service.ID}" style="display:none">
                            {foreach from=$folder.ugyfelek item=ugyfel}
                                    {if $ugyfel}
                                        <input type='checkbox' name='{$service.ID}clients[]' value='{$ugyfel.uID}'><a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/" target="_blank">{$ugyfel.uID}/{$ugyfel.krID}</a>
                                        <br/>
                                    {/if}
                            {/foreach}
                            <button onclick="selectAllInsideFolder('{$key}_{$service.ID}')">Összes kijelölése</button>
                            </div>
                            <br/>

                        {/foreach}

                        {foreach from=$myJobs item=job key=key}
                            <input type="checkbox" target="{$key}_{$service.ID}" class="folderCheckAll2" style="float: left;">
                            <div id="folder2_{$key}_{$service.ID}" onclick="$('#clientsCont2_{$key}_{$service.ID}').toggle();">{$job.munkakor} - {$job.markerCnt} fő</div>
                            <div class="clear"></div>
                            <div id="clientsCont2_{$key}_{$service.ID}" style="display:none">
                            {foreach from=$job.ugyfelek item=ugyfel}
                                    {if $ugyfel}
                                        <input type='checkbox' name='{$service.ID}clientsMarkers[]' class="" value='{$ugyfel.uID}'><a target="_blank" href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/">{$ugyfel.uID}/{$ugyfel.krID}</a>
                                        <br/>
                                    {/if}
                            {/foreach}
                            <button onclick="selectAllInsideFolder2('{$key}_{$service.ID}')">Összes kijelölése</button>
                            </div>
                            <br/>
                        {/foreach}


                    {if $service.ID|in_array:$pendingOrders}    
                        <button type="submit" disabled='disabled'>Megrendelve</button>
                    {else}
                        <button type="submit" name="{$BtnOrderService}">Megrendelem a szolgáltatást</button>
                    {/if} 
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
