<div class="form_row">
        <label for="{$TxtElvarasok.name}">Elvárások <span class="require">*</span></label>
        <textarea class="tinymce" id="{$TxtElvarasok.name}" name="{$TxtElvarasok.name}">{$TxtElvarasok.activ}</textarea>
        {if isset($TxtElvarasok.error)}<p class="error small">{$TxtElvarasok.error}</p>{/if}
</div><div class="clear"></div>