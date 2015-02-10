<div class="form_row">
        <label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
        <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
        {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if}
</div><div class="clear"></div>