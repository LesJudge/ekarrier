<script type="text/javascript">
$(function() { 
    /*
	{$FormScript}
    {if $FormError}       
    {/if}
	$( "#login-Error" ).dialog({
			resizable: false,
            draggable: false,
			modal: true,
            title: "Hibás belépés!"			
	});
	*/
	
	
	 $(function() { 
	   {$FormScript} 
		  {if $FormError}
			$('#popUpLoginForm-modal').appendTo("BODY").modal('show');
		  {/if}  
	  });
	
});
</script>
{if $FormError}<div id="login-Error" class="info info-error" style="display:none;">{$FormError}</div>{/if}

<!--
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

-->


<div class="modal fade" id="popUpLoginForm-modal" tabindex="-1" role="dialog" aria-labelledby="popUpLoginForm" aria-hidden="true">
<div class="modal-dialog login-modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	  <h4 class="modal-title"><i class="icomoon icomoon-user"></i> Bejelentkezés</h4>
	</div>
	<form action="" method="post" name="{$FormName}" id="{$FormName}">
	<div class="modal-body">	
		{if $FormError}<div class="error">{$FormError}</div>{/if}  
		<div class="form-row">
		   <input type="text" id="{$TxtFnev.name}" name="{$TxtFnev.name}" value="{$TxtFnev.activ}" placeholder="Felhasználónév" autocomplete="off" class="form-control {if isset($TxtFnev.error)}ui-state-error{/if}" data-toggle="tooltip" data-placement="top"  title="Kérjük írja be felhasználónevét" />
		</div>
		
		<div class="form-row">
		   <input type="password" id="{$PassJelszo.name}" name="{$PassJelszo.name}" value="{$PassJelszo.activ}" placeholder="Jelszó" autocomplete="off" class="form-control {if isset($PassJelszo.error)}ui-state-error{/if}" data-toggle="tooltip" data-placement="top"  title="Írja be jelszavát"/>  
		</div>						
	</div>
			
	<div class="modal-footer">  
		<a href="{$DOMAIN}jelszoemlekezteto/"><button type="button" class="btn btn-default">Jelszóemlékeztető</button></a>		
		<a href="{$DOMAIN}regisztracio/"><button type="button" class="btn btn-default">Regisztráció</button></a>
		<button class="btn btn-primary" id="{$BtnLogin}" name="{$BtnLogin}" type="submit" value="Belépés"  >Belépés</button>	
    </div>
	</form>       
  </div>
</div>
</div>