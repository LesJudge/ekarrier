<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript} });
/*]]>*/
</script>
<style type="text/css">
div.editorField div.editorColumn
{
        float:left;
        margin-right:30px;
}
</style>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_24">
                <div class="box_top">
                        <h2 class="icon time">{block name="title"}Munkakör tartalom kiegészítés{/block} - [{$edit_mode}]</h2>
                        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
                </div>
                
                <div class="box_content padding">
                        {include file='page/admin/view/admin.message.tpl'}
                        {include file='page/admin/view/admin.edit_events.tpl'}
                        <div class="field editorField">
                                <div class="editorColumn">
                                        <label for="{$TxtAktTartalom.name}">Jelenlegi tartalom <span class="require">*</span></label>
                                        <textarea class="tinymce" id="{$TxtAktTartalom.name}" name="{$TxtAktTartalom.name}">{$TxtAktTartalom.activ}</textarea>
                                        {if isset($TxtAktTartalom.error)}<p class="error small">{$TxtAktTartalom.error}</p>{/if}
                                </div>
                        </div>
                        
                        <div class="field editorField">
                                <div class="editorColumn">
                                        <label for="{$TxtTartalom.name}">Beküldött tartalom <span class="require">*</span></label>
                                        <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
                                        {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if}
                                </div>
                        </div>
                                
                        <div class="field">
                                <div class="form_row">
                                        <label>Publikálva <span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label>Feldolgozva <span class="require">*</span></label>
                                        {html_radios name=$ChkFeldolgozva.name options=$ChkFeldolgozva.values selected=$ChkFeldolgozva.activ}
                                        {if isset($ChkFeldolgozva.error)}<p class="error small">{$ChkFeldolgozva.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                </div>
        </div>
</form>