<script type="text/javascript">
//<![CDATA[
$(function() { {$FormScript}
});
//]]>
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="newsLetterForm" enctype="multipart/form-data">
<h3 class="newsletterForm-title designedText-2">Hírlevél feliratkozás</h3> 
{include file='page/all/view/page.message.tpl'}
<div class="newsletterForm-info">
Iratkozzon fel mihamarabb hírlevelünkre, 
hogy időben értesülhessen az újdonságokról!</div>
<div class="form-row">
	<input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}"  class="text labelInField"  value="Név" alt="Név"/>
	<div class="clear"></div>
	{if isset($TxtNev.error)}<div class="ui-state-error">{$TxtNev.error}</div>{/if} 	
</div>
<div class="form-row">
	<input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}"  class="text labelInField" value="E-mail cím" alt="E-mail cím"/>
	<div class="clear"></div>
	{if isset($TxtEmail.error)}<div class="ui-state-error">{$TxtEmail.error}</div>{/if} 
</div>
<div class="form-row-submit ">
	<button class="submit" type="submit" name="{$BtnSave}" id="{$BtnSave}" value="Feliratkozás" title="Feliratkozás">Feliratkozás</button>
	<div class="clear"></div>
</div>
</form>
