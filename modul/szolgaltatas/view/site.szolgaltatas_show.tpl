<script type="text/javascript">
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

{foreach from=$services item=service}
    <div onclick="$('#descCont_{$service.ID}').toggle();">{$service.nev}</div><br/>
    <div style="display: none" id="descCont_{$service.ID}">{$service.leiras}
        {if $loggedInAs == 'company'}
            <form name="form_{$service.ID}" action="" method="post">
                <input type="hidden" value="{$service.ID}" name="serviceID">
                    {foreach from=$folders item=folder}
                        <input type='checkbox' name='folders[]' value='{$folder.ID}'>{$folder.nev}
                    {/foreach}
                {if $service.ID|in_array:$pendingOrders}    
                    <button type="submit" disabled='disabled'>Megrendelve</button>
                {else}
                    <button type="submit" name="{$BtnOrderService}">Megrendelem a szolgáltatást</button>
                {/if} 
            </form>
        {else}
                <button type="button" title='Regisztráció szükséges'><a href='{$DOMAIN}ceg/regisztracio/'>Megrendelem a szolgáltatást</a></button>
        {/if}
    </div>
{/foreach}


