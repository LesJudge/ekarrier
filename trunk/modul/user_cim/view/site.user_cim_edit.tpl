<script type="text/javascript">
$(function() { {$FormScript}
});
</script>
<div class="content clearfix">
	<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    	{include file='page/all/view/page.message.tpl'} 
		<div class="form-row">
        	<label for="{$SelTipus.name}">Típus <span class="require">*</span></label>
            {html_options name=$SelTipus.name options=$SelTipus.values selected=$SelTipus.activ} 
            {if isset($SelTipus.error)}<div class="ui-state-error">{$SelTipus.error}</div>{/if} 
        </div>
		<div class="form-row">
		  	<label for="{$TxtNev.name}">Név / Cégnév <span class="require">*</span></label>
		  	<input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
		  	{if isset($TxtNev.error)}<div class="ui-state-error">{$TxtNev.error}</div>{/if} 
		</div>
		<div class="form-row">
        	<label for="{$TxtEmail.name}">E-mail cím <span class="require">*</span></label>
            <input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}" value="{$TxtEmail.activ}"/>
            {if isset($TxtEmail.error)}<div class="ui-state-error">{$TxtEmail.error}</div>{/if} 
        </div>
        <div class="form-row">
            <label for="{$TxtTelefon.name}">Telefonszám <span class="require">*</span></label>
            <input type="text" id="{$TxtTelefon.name}" name="{$TxtTelefon.name}" value="{$TxtTelefon.activ}"/>
            {if isset($TxtTelefon.error)}<div class="ui-state-error">{$TxtTelefon.error}</div>{/if} 
        </div>
        <div class="form-row">
            <label for="{$TxtFax.name}">Fax</label>
            <input type="text" id="{$TxtFax.name}" name="{$TxtFax.name}" value="{$TxtFax.activ}"/>
            {if isset($TxtFax.error)}<div class="ui-state-error">{$TxtFax.error}</div>{/if} 
        </div>
        <div class="form-row">
            <label for="{$SelOrszag.name}">Ország <span class="require">*</span></label>
            {html_options name=$SelOrszag.name options=$SelOrszag.values selected=$SelOrszag.activ} 
            {if isset($SelOrszag.error)}<div class="ui-state-error">{$SelOrszag.error}</div>{/if} 
        </div>
        <div class="form-row">
            <label for="{$TxtIrszag.name}">Irányítószám <span class="require">*</span></label>
            <input type="text" id="{$TxtIrszag.name}" name="{$TxtIrszag.name}" value="{$TxtIrszag.activ}"/>
            {if isset($TxtIrszag.error)}<div class="ui-state-error">{$TxtIrszag.error}</div>{/if} 
        </div>
        <div class="form-row">
            <label for="{$TxtVaros.name}">Város <span class="require">*</span></label>
            <input type="text" id="{$TxtVaros.name}" name="{$TxtVaros.name}" value="{$TxtVaros.activ}"/>
            {if isset($TxtVaros.error)}<div class="ui-state-error">{$TxtVaros.error}</div>{/if} 
        </div>
        <div class="form-row">
            <label for="{$TxtUtcaHaz.name}">Utca, ház <span class="require">*</span></label>
            <input type="text" id="{$TxtUtcaHaz.name}" name="{$TxtUtcaHaz.name}" value="{$TxtUtcaHaz.activ}"/>
            {if isset($TxtUtcaHaz.error)}<div class="ui-state-error">{$TxtUtcaHaz.error}</div>{/if} 
        </div>
        <div class="form-row clearfix">
            <div class="left rightmargin">
			     <a class="submit" href="{$DOMAIN}{$APP_LINK}/" id="{$FormName}_close" title="Bezár">Mégsem</a>
            </div>
            <div class="left leftmargin">
                <button class="submit rightmargin" name="{$BtnSave}" id="{$BtnSave}" value="mentes" type="submit">Mentés</button>
            </div>
		</div>
	</form>
</div>