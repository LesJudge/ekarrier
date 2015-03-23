<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<!--script type="text/javascript" src="../js/admin/add_tinymce.js"></script-->
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
        
  
  jQuery.each($(".mceNonEditable"), function() {
        tinyMCE.init({ mode : "exact", elements : this.id, theme : "advanced", skin : "o2k7", skin_variant : "silver", language : "hu", theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom", gecko_spellcheck : "true", plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
    	theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,link,unlink,forecolor,backcolor,cleanup,|",    	
		theme_advanced_resizing : true,			
		document_base_url : $("#DOMAIN").val(),			
		width : "630",  
		height : "300", 
		paste_auto_cleanup_on_paste : true, 
		plugin_preview_width : "1000", 
		theme_advanced_resize_horizontal : false,
                readonly : 1,
        theme_advanced_path : false,theme_advanced_statusbar_location : 0,
		});
    });  
});    


/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Üzenetek - [{$edit_mode}]</h2>
                        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
                </div>
                
                <div class="box_content padding">
                        {include file='page/admin/view/admin.message.tpl'}
                        <div class="form_muvelet">
                            <a><button class="submit tip" name="{$BtnSave}" id="{$BtnSave}" value="{php}echo LANG_AdminEdit_mentes;{/php}" title="{php}echo LANG_AdminEdit_mentes;{/php}"><img src="../images/admin/icons/save.png"></button></a>
                        
                            <a href="{$DOMAIN_ADMIN}ugyfeluzenetek" id="{$FormName}_close"><img class="tip" title="{php}echo LANG_AdminEdit_megse;{/php}" src="../images/admin/icons/cancel.png"/></a>
                        
                        </div> 
                                <div class="field" {if $mod=="1"}style="display:none"{/if}>
                                <label for="{$SelUgyfel.name}">Ügyfél</label>
                                        {html_options name=$SelUgyfel.name options=$SelUgyfel.values selected=$SelUgyfel.activ} 
					<span class="ui-icon ui-icon-info tip" title=""></span>
					{if isset($SelUgyfel.error)}<p class="error small">{$SelUgyfel.error}</p>{/if}
				</div><div class="clear"></div>
                               
                               
                                 <div class="form_row">
                                    <label for="{$TxtTartalom.name}">Üzenet <span class="require">*</span></label>
                                    <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
                                    {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if}
				</div><div class="clear"></div>
                                
                                
                                
                               {if $mod=="1"}
                                <div class="form_row">
                                        <label>Elolvasva <span class="require">*</span></label>
                                        {html_radios name=$ChkSeen.name options=$ChkSeen.values selected=$ChkSeen.activ}
                                        {if isset($ChkSeen.error)}<p class="error small">{$ChkSeen.error}</p>{/if}
                                </div><div class="clear"></div>
                                 {/if}
                                
                                <div class="form_row">
                                        <label>Publikus <span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                        
                       
                </div>
        </div>
        
        
</form>