<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
	jQuery.each($(".tinymce"), function() {
        tinyMCE.init({ mode : "exact", elements : this.id, theme : "advanced", skin : "o2k7", skin_variant : "silver", language : "hu", theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom", gecko_spellcheck : "true", plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
    	theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,link,unlink,forecolor,backcolor,cleanup,|",    	
		theme_advanced_resizing : true,			
		document_base_url : $("#DOMAIN").val(),			
		width : "100%",  
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
{if $FormError}
 <div class="info info-error">
    <p><img src="images/site/form-error.png" style="float:left; margin:5px;"/>{$FormError}</p>
</div> 
<div class="clear"></div>
{/if}
{if $FormMessage}
<div id="form_info" class="info info-success">
    <p>{$FormMessage}</p>
</div>
<div class="clear"></div>
{/if}

{if not empty($messages)}
	{foreach from=$messages item=message} 
		<div class="commentItem">
			<div class="commentItem-name">{$message.szerzo}</div>
			<div class="commentItem-date">{$message.datum}</div>
			<div class="commentItem-text">
				<div class="pull-right">
					<form action="" method="post" name="{$FormName}" id="{$FormName}">
						<input type="hidden" name="delMessageID" value="{$message.ID}">
						<button class="commentItem-next btn" name="{$BtnDelUzenet}" id="{$BtnDelUzenet}" type="submit">Törlés <i class="glyphicon glyphicon-chevron-right"></i></button>
						<div class="clear"></div>
					</form>		
				</div>
				{$message.uzenet}
				<div class="clear"></div>
			</div>
		</div>
	{/foreach}
{else}
<div class="alert alert-info">Még senki nem írt hozzá!</div>
{/if}


<div class="btn-nav-row">
<form action="" method="post" name="{$FormName}" id="{$FormName}">
	<div class="form-row">
		<div class="text-type-3">Hozzászólás <span class="require">*</span></div>
		<textarea id="message" name="message" class="tinymce"></textarea>
	</div>
	<div class="clear"></div>
	<div class="form-row" style="margin-top:5px;">		
		<button class="btn btn-primary btn-md pull-right" name="{$BtnAddUzenet}" id="{$BtnAddUzenet}" type="submit">Elküld</button>
	</div>
	<div class="clear"></div>
</form>  
</div>
