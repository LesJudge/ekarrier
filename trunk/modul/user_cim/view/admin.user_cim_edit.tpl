<script type="text/javascript">
$(function() { {$FormScript}
});
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_24">
    	<div class="box_top">
            <h2 class="icon time">Felhasználó cím - {$user_nev} [{$edit_mode}]</h2>
        </div>
        <div class="box_content padding"> 
			{include file='page/admin/view/admin.message.tpl'} 
			<div class="form_muvelet">
			    <button class="submit tip" name="{$BtnSave}" id="{$BtnSave}" value="{php}echo LANG_AdminEdit_mentes;{/php}" title="{php}echo LANG_AdminEdit_mentes;{/php}"><img src="../images/admin/icons/save.png" /></button>
			    <a href="{$DOMAIN_ADMIN}{$APP_LINK}?user_id={$user_id}" id="{$FormName}_close" class="submit ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text"><img class="tip" title="{php}echo LANG_AdminEdit_megse;{/php}" src="../images/admin/icons/cancel.png"/></span></a>
			</div>
	  		<div class="form_row">
            	<label for="{$SelTipus.name}">Típus <span class="require">*</span></label>
                {html_options name=$SelTipus.name options=$SelTipus.values selected=$SelTipus.activ} 
                {if isset($SelTipus.error)}<p class="error small">{$SelTipus.error}</p>{/if} 
            </div><div class="clear"></div>	
            <div class="form_row">
                <label for="{$TxtNev.name}">Név / Cégnév <span class="require">*</span></label>
                <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
                {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if} 
            </div><div class="clear"></div>
			<div class="form_row">
                <label for="{$TxtEmail.name}">E-mail cím <span class="require">*</span></label>
                <input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}" value="{$TxtEmail.activ}"/>
                {if isset($TxtEmail.error)}<p class="error small">{$TxtEmail.error}</p>{/if} 
            </div><div class="clear"></div>
            <div class="form_row">
                <label for="{$TxtTelefon.name}">Telefonszám <span class="require">*</span></label>
                <input type="text" id="{$TxtTelefon.name}" name="{$TxtTelefon.name}" value="{$TxtTelefon.activ}"/>
                {if isset($TxtTelefon.error)}<p class="error small">{$TxtTelefon.error}</p>{/if} 
            </div><div class="clear"></div>
            <div class="form_row">
                <label for="{$TxtFax.name}">Fax</label>
                <input type="text" id="{$TxtFax.name}" name="{$TxtFax.name}" value="{$TxtFax.activ}"/>
                {if isset($TxtFax.error)}<p class="error small">{$TxtFax.error}</p>{/if} 
            </div><div class="clear"></div>    
            <div class="form_row">
                <label for="{$SelOrszag.name}">Ország <span class="require">*</span></label>
                {html_options name=$SelOrszag.name options=$SelOrszag.values selected=$SelOrszag.activ} 
                {if isset($SelOrszag.error)}<p class="error small">{$SelOrszag.error}</p>{/if} 
            </div><div class="clear"></div>
            <div class="form_row">
                <label for="{$TxtIrszag.name}">Irányítószám <span class="require">*</span></label>
                <input type="text" id="{$TxtIrszag.name}" name="{$TxtIrszag.name}" value="{$TxtIrszag.activ}"/>
                {if isset($TxtIrszag.error)}<p class="error small">{$TxtIrszag.error}</p>{/if} 
        	</div><div class="clear"></div>
            <div class="form_row">
                <label for="{$TxtVaros.name}">Város <span class="require">*</span></label>
                <input type="text" id="{$TxtVaros.name}" name="{$TxtVaros.name}" value="{$TxtVaros.activ}"/>
                {if isset($TxtVaros.error)}<p class="error small">{$TxtVaros.error}</p>{/if} 
        	</div><div class="clear"></div>
            <div class="form_row">
                <label for="{$TxtUtcaHaz.name}">Utca, ház <span class="require">*</span></label>
                <input type="text" id="{$TxtUtcaHaz.name}" name="{$TxtUtcaHaz.name}" value="{$TxtUtcaHaz.activ}"/>
                {if isset($TxtUtcaHaz.error)}<p class="error small">{$TxtUtcaHaz.error}</p>{/if} 
        	</div><div class="clear"></div>
        </div>
    </div>
</form>