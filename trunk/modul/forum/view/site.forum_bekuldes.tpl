<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>

<div class="content clearfix">
	<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data"> 
	{include file='page/all/view/page.message.tpl'}                   

	    
	    <input type="hidden" id="{$TxtBekuldo.name}" name="{$TxtBekuldo.name}" value="{$TxtBekuldo.activ}"/>
	
	    <div class="form-row">
			<label for="{$TxtTargy.name}">Tárgy <span class="require">*</span></label>
			<input type="text" id="{$TxtTargy.name}" name="{$TxtTargy.name}" value="{$TxtTargy.activ}"/>
			{if isset($TxtTargy.error)}<div class="ui-state-error">{$TxtTargy.error}</div>{/if} 
	    </div>
	    <div class="form-row">
	        <label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>		
	        <textarea class="tinymce clear" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}" rows="10">{$TxtTartalom.activ}</textarea>
	        {if isset($TxtTartalom.error)}<div class="ui-state-error">{$TxtTartalom.error}</div>{/if} 
		</div>                 
		<div class="form-row">
			<label>&nbsp;</label>
			<img src="captcha.php" id="captcha" class="captcha-img" />
		</div>
		<div class="form-row">
          <label for="{$TxtCaptcha.name}">Ellenőrző kód: <span class="require">*</span></label>
          <input type="text" id="{$TxtCaptcha.name}" name="{$TxtCaptcha.name}" value="{$TxtCaptcha.activ}"/>          
          <span class="captcha-help" onclick="$('#captcha').attr('src','captcha.php?'+Math.random()); $('#{$TxtCaptcha.name}').focus();">Nem olvasható? Kattintson ide.</span>
		  {if isset($TxtCaptcha.error)}<div class="ui-state-error">{$TxtCaptcha.error}</div>{/if} 
    	</div>
		<div class="clear"></div>
		<br />
		<div class="btn-nav-row">
			<button class="btn btn-lg btn-primary" name="{$BtnSave}" id="{$BtnSave}" value="send" type="submit">Beküld</button>
		</div>                                                    
	</form>
</div>