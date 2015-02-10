<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>
<script type="text/javascript">
$(function() { {$FormScript} 
}); 
</script>
<div class="content clearfix">
	{foreach from=$parent_data key=for_id item=item}			
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="icomoon icomoon-user"></i> {$item.bekuldo} <span class="badge">{$item.bekuldve_date}</span></h3></div>
		<div class="panel-body">
			{$item.tartalom}
		</div>
	</div>		
	{/foreach}
	<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data"> 
		{include file='page/all/view/page.message.tpl'}                  

		<!--
	   	<div class="form-row">
			<label for="{$TxtBekuldo.name}">Név <span class="require">*</span></label>		
		   <input class="" type="text" id="{$TxtBekuldo.name}" name="{$TxtBekuldo.name}" value="{$TxtBekuldo.activ}"/>
		   {if isset($TxtBekuldo.error)}<div class="ui-state-error">{$TxtBekuldo.error}</div>{/if}
		</div>
		-->
		<div class="form-row">
		  	<label for="{$TxtTartalom.name}">Hozzászólás <span class="require">*</span></label>	
			<textarea  id="{$TxtTartalom.name}" name="{$TxtTartalom.name}" rows="10" class="tinymce">{$TxtTartalom.activ}</textarea>
			{if isset($TxtTartalom.error)}<div class="ui-state-error">{$TxtTartalom.error}</div>{/if}
		</div>
		<div class="form-row">
			<label>&nbsp;</label>
			<img src="captcha.php" id="captcha" class="captcha-img" />
		</div>
		<div class="form-row">
			<label for="{$TxtCaptcha.name}">Ellenőrző kód: <span class="require">*</span></label>	
		    <input class="" type="text" id="{$TxtCaptcha.name}" name="{$TxtCaptcha.name}" value="{$TxtCaptcha.activ}"/>
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