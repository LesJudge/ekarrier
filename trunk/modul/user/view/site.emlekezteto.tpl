<script type="text/javascript">
$(function() { {$FormScript}
}); 
</script>
<div class="content clearfix">
{$jelszoemlekezteto_oldal}
<br />
	<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
		{include file='page/all/view/page.message.tpl'} 
		<div class="form-row">
		      <label for="{$TxtTelefon.name}">E-mail cím <span class="require">*</span></label>
		      <input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}" value="{$TxtEmail.activ}"/>
		      {if isset($TxtEmail.error)}
		      <div class="ui-state-error">{$TxtEmail.error}</div>
		      {/if} 
		</div><div class="clear"></div>
        	<div class="form-row">
        <label>&nbsp;</label>
		<button class="submit btn" name="{$BtnSave}" id="{$BtnSave}" value="reg">Jelszó küldése</button>
        </div>
	</form>
</div>