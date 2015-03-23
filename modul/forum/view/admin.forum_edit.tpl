<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}
}) 
</script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_24">
	    <div class="box_top">
	   		<h2 class="icon time">Fórum téma - [{$edit_mode}]</h2>
	    </div>
        <div class="box_content padding"> 
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'}
        	<div class="field"> 
	            <div class="form_row">
					<label for="{$SelNyelv.name}">Nyelv <span class="require">*</span></label>
					{html_options name=$SelNyelv.name options=$SelNyelv.values selected=$SelNyelv.activ} 
					{if isset($SelNyelv.error)}<p class="error small">{$SelNyelv.error}</p>{/if} 
	            </div><div class="clear"></div>                  
                <div class="form_row">
                    <label for="{$TxtBekuldo.name}">Beküldő <span class="require">*</span></label>
                    <input type="text" id="{$TxtBekuldo.name}" name="{$TxtBekuldo.name}" value="{$TxtBekuldo.activ}"/>
                    {if isset($TxtBekuldo.error)}<p class="error small">{$TxtBekuldo.error}</p>{/if} 
                </div><div class="clear"></div>
                <div class="form_row">
					<label for="{$TxtTargy.name}">Tárgy <span class="require">*</span></label>
					<input type="text" id="{$TxtTargy.name}" name="{$TxtTargy.name}" value="{$TxtTargy.activ}"/>
					{if isset($TxtTargy.error)}<p class="error small">{$TxtTargy.error}</p>{/if} 
                </div><div class="clear"></div>
                <div class="form_row">
                    <label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
                    <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
                    {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if} 
				</div><div class="clear"></div>
                
                    <div class="form_row">
                        <label>Ellenőrizve <span class="require">*</span></label>
                        {html_radios name=$ChkChecked.name options=$ChkChecked.values selected=$ChkChecked.activ}
                        {if isset($ChkChecked.error)}<p class="error small">{$ChkChecked.error}</p>{/if}
                    </div><div class="clear"></div>            
                                
                                
                                <div class="form_row">
					<label>Publikus</label>
					{html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
					{if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if} 
				</div><div class="clear"></div>                                                 
			</div>
		</div>
	</div>      
</form>