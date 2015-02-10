<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() {
    {$FormScript}
});
/*]]>*/
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
        <div class="box_top">
            <h2 class="icon time">Ügyfél állapot - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
        </div>
        <div class="box_content padding">
            {include file='page/admin/view/admin.message.tpl'}
            {include file='page/admin/view/admin.edit_events.tpl'} 
            <div class="field">
                <div class="form_row">
                    <label for="{$TxtNev.name}">Név <span class="require">*</span></label>
                    <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
                    {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if}
                </div>
                <div class="clear"></div>
            </div>
            <div class="field">
                <div class="form_row">
                    <label>Publikus <span class="require">*</span></label>
                    {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                    {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    {if isset($recordStatus) and $recordStatus eq true}
    {include file="page/admin/view/admin.record_status.tpl"}
    {/if}
</form>