<div class="form_row">
                <label for="{$TxtInputname.name}">Inputlabel <span class="require">*</span></label>
                <input id="{$TxtInputname.name}" name="{$TxtInputname.name}" value="{$TxtInputname.activ}" type="text" />
                {if isset($TxtInputname.error)}<p class="error small">{$TxtInputname.error}</p>{/if}
            </div><div class="clear"></div>