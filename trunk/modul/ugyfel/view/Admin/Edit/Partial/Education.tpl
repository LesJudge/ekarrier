<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <label>Legmagasabb iskolai végzettség</label>
        <select name="client[vegzettseg_id]">
            <option value="">--Kérem, válasszon!--</option>
            {foreach from=$beallitasEducations item=education}
            <option value="{$education->vegzettseg_id}" {if $education->vegzettseg_id eq $client->vegzettseg_id}selected="selected"{/if}>{$education->nev}</option>
            {/foreach}
        </select>
        {ar_error model=$client property='vegzettseg_id' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Tanulmányok</label>
        {include file="modul/ugyfel/view/Admin/Edit/Partial/SheepIt/Education.tpl"}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Nyelvtudás</label>
        {include file="modul/ugyfel/view/Admin/Edit/Partial/SheepIt/Knowledge.tpl"}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Számítógépes ismeret</label>
        {include file="modul/ugyfel/view/Admin/Edit/Partial/SheepIt/ComputerKnowledge.tpl"}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea name="relationships[commenteducation][megjegyzes]" class="uw-ugyfelkezelo-input-textarea-megjegyzes">{$client->commenteducation->megjegyzes}</textarea>
        {ar_error model=$client->commenteducation property='megjegyzes' view='admin_ar_error.tpl'}
        <input name="relationships[commenteducation][ugyfel_attr_tab_megjegyzes_id]" value="{$client->commenteducation->ugyfel_attr_tab_megjegyzes_id}" type="hidden" />
    </div>
</div>