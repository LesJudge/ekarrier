$(function() {    
    /*Tiny MCE*/
    jQuery.each($(".tinymce"), function() {
        tinyMCE.init({ mode : "exact", elements : this.id, theme : "advanced", skin : "o2k7", skin_variant : "silver", language : "hu", theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom", gecko_spellcheck : "true", plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
    	theme_advanced_buttons1 : "undo,redo,|,fullscreen,|,print,|,preview,|,search,replace,|,pasteword,|,template,mymenubutton,|,code,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,styleprops,|,pagebreak",
    	theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect,|,bullist,numlist,|,outdent,indent,blockquote",
    	theme_advanced_buttons3 : "link,unlink,anchor,image,|,insertdate,inserttime,|,forecolor,backcolor,tablecontrols,|,hr,|,cleanup|,removeformat",
		theme_advanced_buttons4 : "", 
		theme_advanced_resizing : true,
		relative_urls : true,
		//relative_urls: false,
		//remove_script_host: false,
		document_base_url : $("#DOMAIN").val(),		
		file_browser_callback : RimoFileBrowser, 
		template_templates : tinyMCESablon, 
		width : "800",  
		height : "550", 
		paste_auto_cleanup_on_paste : true, 
		plugin_preview_width : "1000", 
		theme_advanced_resize_horizontal : false,
        theme_advanced_path : false,theme_advanced_statusbar_location : 0,
		content_css : "/js/tinymce/jscripts/tiny_mce/themes/advanced/skins/o2k7/user-admin.css",
		
        // Style formats
        style_formats : [
               {title : 'Content Táblázat'}, 							
				{title : 'contentTable', selector : 'TABLE', classes : 'contentTable'},               
				{title : 'contentTable-header', selector : 'TD', classes : 'contentTable-header'},
				{title : 'head-title-1', selector : 'P', classes : 'head-title-1'},
				{title : 'head-title-2', selector : 'P', classes : 'head-title-2'}									    				
        ],
        });
    });
});
/*File Manager a TYNMC-hez*/
function RimoFileBrowser(field_name, url, type, win) {
  tinyMCE.activeEditor.windowManager.open({
      file : DOMAIN_ADMIN+"ajax.php?m=file_browser&type="+type,
      title : 'File Manager',
      width : 860,
      height : 450,
      resizable : "no",
      inline : "yes",
      close_previous : "no"
  }, {
      window : win,
      input : field_name
  });
  return false;
}