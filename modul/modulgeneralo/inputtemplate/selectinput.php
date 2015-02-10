<div class="form_row">
                <label for="{$SelInputname.name}">Inputlabel <span class="require">*</span></label>
                {html_options multiple name=$SelInputname.name options=$SelInputname.values selected=$SelInputname.activ}
                {if isset($SelInputname.error)}<p class="error small">{$SelInputname.error}</p>{/if}
            </div><div class="clear"></div>