<div class="form_row">
                <label for="{$TxtInputname.name}">Inputlabel <span class="require">*</span></label>
                <textarea id="{$TxtInputname.name}" name="{$TxtInputname.name}">{$TxtInputname.activ}</textarea>
                {if isset($TxtInputname.error)}<p class="error small">{$TxtInputname.error}</p>{/if}
            </div><div class="clear"></div>