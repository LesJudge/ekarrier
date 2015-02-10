<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
	jQuery.each($(".tinymce"), function() {
        tinyMCE.init({ mode : "exact", elements : this.id, theme : "advanced", skin : "o2k7", skin_variant : "silver", language : "hu", theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom", gecko_spellcheck : "true", plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
    	theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,link,unlink,forecolor,backcolor,cleanup,|",    	
		theme_advanced_resizing : true,			
		document_base_url : $("#DOMAIN").val(),			
		width : "630",  
		height : "300", 
		paste_auto_cleanup_on_paste : true, 
		plugin_preview_width : "1000", 
		theme_advanced_resize_horizontal : false,
        theme_advanced_path : false,theme_advanced_statusbar_location : 0,
		});
    });
});
/*]]>*/
</script>

<div class="content clearfix">
	<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor adatmodositas " enctype="multipart/form-data">
		{include file='page/all/view/page.message.tpl'} 

		<div class="form-row">
				<label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
				<textarea id="{$TxtTartalom.name}" name="{$TxtTartalom.name}" class="tinymce">{$content}</textarea>
				{if isset($TxtTartalom.error)}<div class="ui-state-error">{$TxtTartalom.error}</div>{/if} 
		</div><div class="clear"></div>
		
		<div class="form-row">
				<label>&nbsp;</label>
				<button class="submit btn" name="{$BtnSave}" id="{$BtnSave}" value="reg" type="submit">Módosít</button>
		</div><div class="clear"></div>
	</form>
</div>