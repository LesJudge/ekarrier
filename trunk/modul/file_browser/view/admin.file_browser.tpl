<link rel="stylesheet" href="../modul/{$APP_PATH}/css/file_uploader.css" type="text/css" />
<link href="../css/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../js/swfobject.js"></script>
<script type="text/javascript" src="../js/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce_popup.js"></script>
<script type="text/javascript" src="../js/admin/jquery.removeAccents.js"></script>
<script type="text/javascript" src="../js/jquery.fileinput.min.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}
    $('#{$TxtDirName.name}').removeAccents();
    $("#{$File.name}").fileinput();
    var uploaded_files='<ul>';
    $('#file_upload').uploadify({
        'uploader'  : '../js/uploadify/uploadify.swf',
        'script'    : '../admin/uploadify.php',
        'cancelImg' : '../js/uploadify/cancel.png',
        'folder'    : '../{$current_file_dir}',
        'removeCompleted' : true,
        'multi'       : true,
        'buttonText'  : 'Tallozas',
        'sizeLimit'   : {$file_max_size},
        'onComplete'  : function(event, ID, fileObj, response, data) {
            if(fileObj.name) uploaded_files += '<li>'+response+'</li>';
            if(data.fileCount==0){
                messageBox('REQUEST_URI','{php}echo LANG_FB_msg_file;{/php}',uploaded_files+'</ul>');
                uploaded_files='<ul>';        
            }        
        }
    });
    {if isset($File.error)} $('#toggle_browser').click(); {/if}
});
function submit_url(URL) {
    var win = tinyMCEPopup.getWindowArg("window");
    win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
    {if $file_type == 'image'}
        if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
    {/if}
    tinyMCEPopup.close();
}
function switchUploader()
{
    if($('#{$BtnUploadFile}').attr('onclick')) $('#{$BtnUploadFile}').attr('onclick','');
    else $('#{$BtnUploadFile}').attr('onclick',"javascript:$('#file_upload').uploadifyUpload(); return false;"); 
    $('#browser_uploader').toggle('slow');
    $('#flash_uploader').toggle('slow');
}
</script>
<form action="" name="{$FormName}" id="{$FormName}" class="form form_list" method="post" enctype="multipart/form-data">
	<div id="browser-wrapper">
        <div id="view-tree" class="ui-widget ui-widget-content ui-corner-all">
    		<ul class="dirlist">
    			<li>
                    <a href="ajax.php?m={$APP_PATH}&type={$file_type}">upload</a>  
    			    <ul class="dirlist">
                        {foreach from=$directory_tree key=id item=directory}
                            <li style="margin-left: {$directory.level}em;" class="{$directory.class}">
                                <a href="ajax.php?m={$APP_PATH}&type={$file_type}&viewdir={$directory.dir}&act_dir={$directory.name}">{$directory.name}</a>
                            </li>
                        {/foreach}
                    </ul>
    			</li>
    		</ul>
    	</div>
        <div id="view-files">
            <div class="ui-widget ui-widget-content ui-corner-all list_header">
                <div class="form_fejlecinfo"><img src="../images/admin/icons/folder_open.png"><span>{$current_dir}</span></div>
                <div class="form_muvelet">
                    <button class="submit" onclick="$('#add-file').toggle(); $('#create-dir').hide(); return false;" name="show_file_upload_form" value="" title="{php}echo LANG_FB_upload_file;{/php}"><img src="../images/admin/icons/file_add.png"></button>
                    <button class="submit" onclick="$('#create-dir').toggle(); $('#add-file').hide(); return false;" name="show_dir_upload_form" value="" title="{php}echo LANG_FB_create_dir;{/php}"><img src="../images/admin/icons/folder_open_add2.png"></button>
                    <button class="submit" id="{$BtnDeleteDir}" name="{$BtnDeleteDir}" onclick="return confirmBox('{$BtnDeleteDir}', '{php}echo LANG_AdminList_torol_title;{/php}', '{php}echo LANG_FB_del_dir_and_file;{/php}');" value="{php}echo LANG_FB_del_dir;{/php}');" title="{php}echo LANG_FB_del_dir;{/php}"><img src="../images/admin/icons/folder_open_delete2.png"></button>
                </div>
            </div>
            {include file='page/admin/view/admin.message.tpl'}
            <div id="add-file" class="ui-widget ui-widget-content ui-corner-all form_editor" style="{if not isset($File.error)}display: none;{/if} width: auto;">
                <a id="REQUEST_URI" href="{$REQUEST_URI}" style="display: none;"></a>
                <div class="ui-state-highlight ui-corner-all">
                    <p>
                       <span class="ui-icon ui-icon-info"></span>
					   <strong>Figyelem!</strong>{php}echo LANG_FB_file_info;{/php} : <strong>{$file_max_normalized_size}</strong>
                    </p>
                </div>
                <div class="form_row" id="browser_uploader" style="display: none;">
                    <input type="file" name="{$File.name}" id="{$File.name}">
                    {if isset($File.error)}<div class="ui-state-error"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"/></span>{$File.error}</div>{/if}
                    <br class="clear">{php}echo LANG_FB_switch1;{/php}
                     <a id="toggle_browser" onclick="switchUploader();" style="cursor: pointer; color: blue; text-decoration: underline;">{php}echo LANG_FB_switch1_link;{/php}.</a>
                </div><div class="clear"></div>
                <div class="form_row" id="flash_uploader">
                    <input type="file" id="file_upload" name="{$File.name}_flash">
                    {php}echo LANG_FB_switch2;{/php}
                    <a id="toggle_browser" onclick="switchUploader();" style="cursor: pointer; color: blue; text-decoration: underline;">{php}echo LANG_FB_switch2_link;{/php}.</a>
                </div><div class="clear"></div>
                <div class="form_row">
                    <button id="{$BtnUploadFile}" onclick="javascript:$('#file_upload').uploadifyUpload(); return false;" name="{$BtnUploadFile}" value="upload" style="margin-left: 2px; padding: 0.2em 0.5em;">{php}echo LANG_FB_upload;{/php}</button>
                </div><div class="clear"></div>
           </div> 	
           <div id="create-dir" class="ui-widget ui-widget-content ui-corner-all form_editor" style=" {if not isset($TxtDirName.error)}display: none;{/if} width: auto;">
                 <div class="ui-state-highlight ui-corner-all">
                    <p>
                       <span class="ui-icon ui-icon-info"></span>
					   <strong>{php}echo LANG_FB_figyelem;{/php}!</strong> {php}echo LANG_FB_info_dir;{/php} 
                    </p>
                </div>
                <div class="form_row">
                    <label for="{$TxtDirName.name}">{php}echo LANG_FB_inp_dir;{/php} <span class="require">*</span></label>
                    <input type="text" name="{$TxtDirName.name}" id="{$TxtDirName.name}" value="{$TxtDirName.activ}">
                    {if isset($TxtDirName.error)}<div class="ui-state-error"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"/></span>{$TxtDirName.error}</div>{/if}
                </div><div class="clear"></div>
                <div class="form_row">
                    <button name="{$BtnCreateDir}" id="{$BtnCreateDir}" value="Létrehozás" style="margin-left: 2px; padding: 0.2em 0.5em;">{php}echo LANG_FB_btn_dir;{/php}</button>
                </div><div class="clear"></div>
           </div>
		   <div class="ui-widget ui-widget-content ui-corner-all">
                <table>
                     <tbody  class="ui-table-tbody-active">  
                        {foreach from=$file_tree key=id item=file}
                            <tr>
                                <td style="text-align: left;">
                                    <a class="file thumbnail {$file.type}" href="#" onclick="submit_url('{$file.file}');">
                                        {$file.name}
                                        {if isset($file.image)}
                                            <span><img src="{$DOMAIN}pic/{$APP_PATH}/{$file.name}_75x75?d={$file.dir}"/></span>
                                        {/if}
                                    </a>
                                </td>
                                <td style="width: 15%;">{$file.size}</td>
                                <td class="delete" style="width: 7%;">
                                    <button title="{php}echo LANG_AdminList_torol;{/php}" id="{$BtnDeleteFile}_{$id}" onclick="return confirmBox('{$BtnDeleteFile}_{$id}', '{php}echo LANG_AdminList_torol_title;{/php}', '<strong>{$file.name}</strong><br>{php}echo LANG_AdminList_torol_content;{/php}');" name="{$BtnDeleteFile}" value="{$file.name}"><span class="ui-icon ui-icon-circle-close"></span></button>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
  </div>
</form>