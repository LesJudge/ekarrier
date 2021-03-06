<script type="text/javascript">
$(function() { {$FormScript}
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_24">
    	<div class="box_top">
            <h2 class="icon time">Város - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'}
        </div>
        <div class="box_content padding">
            {include file='page/admin/view/admin.message.tpl'}
            {include file='page/admin/view/admin.edit_events.tpl'} 
            <div class="field">
                <div class="form_row">
                    <label for="{$TxtNev.name}">Város név <span class="require">*</span></label>
                    <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
                    {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if}
                </div><div class="clear"></div>
                <div class="form_row">
                    <label for="{$SelOrszag.name}">Ország <span class="require">*</span></label>
                    {html_options name=$SelOrszag.name options=$SelOrszag.values selected=$SelOrszag.activ}
                    {if isset($SelOrszag.error)}
                    <p class="error small">{$SelOrszag.error}</p>
                    {/if} 
                </div><div class="clear"></div>
            </div>
        </div>
    </div>
</form>