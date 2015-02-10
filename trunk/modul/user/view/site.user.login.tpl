<script type="text/javascript">
$(function() { 
    {$FormScript}
    {if $FormError}       
    {/if}
	$( "#login-Error" ).dialog({
			resizable: false,
            draggable: false,
			modal: true,
            title: "Hibás belépés!"			
	});
});
</script>
{if $FormError}<div id="login-Error" class="info info-error" style="display:none;">{$FormError}</div>{/if}

<h3 class="boxForm-form-title">Bejelentkezés</h3> 
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="boxForm-form" {if $FormError}{/if}>	
	<div class="form-row">        
        <input type="text" id="{$TxtFnev.name}" name="{$TxtFnev.name}" placeholder="felhasználónév..." autocomplete="off" class="password tip{if isset($TxtFnev.error)}ui-state-error{/if}" title="Kérjük írja be felhasználónevét" />
		<div class="clear"></div>
    </div>
    <div class="form-row">       
        <input type="password" id="{$PassJelszo.name}" name="{$PassJelszo.name}" placeholder="jelszó..." autocomplete="off" class="password tip{if isset($PassJelszo.error)}ui-state-error{/if}" title="Írja be jelszavát"/> 
		<div class="clear"></div> 
	</div>
    <div class="form-row">
    	<div class="loginformLinks">			
			<a class="lostpwd" href="{$DOMAIN}jelszoemlekezteto/">Jelszóemlékeztető</a>
                        <a href="{$DOMAIN}munkavallalo/regisztracio/" class="regBtn">Regisztráció</a>
                        </div>		
		<div class="clear"></div>   
	</div>
	<div class="form-row form-row-submit">
		<button class="submit" id="{$BtnLogin}" name="{$BtnLogin}" type="submit" value="Belépés">Belépés</button>
		<div class="clear"></div>   
	</div>		
	<div class="clear"></div>
</form>