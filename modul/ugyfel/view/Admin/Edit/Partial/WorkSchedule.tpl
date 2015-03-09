<div class="uw-ugyfelkezelo-form">
    <div id="tab-munkakorokmunkarend-munkarend" class="uw-ugyfelkezelo-form-row">
        <label>Munkarend</label>
        {foreach from=$workschedules item=workschedule}
        <div class="uw-ugyfelkezelo-form-client-info-chkbox {if $workschedule->getHasField()}uw-ugyfelkezelo-form-client-info-chkbox-with-text{/if} parent-item">
            <label>
                <input id="project-information-program-information-{$workschedule->getId()}" class="workschedule-checkbox" name="relationships[workschedules][{$workschedule->getId()}][munkarend_id]" value="{$workschedule->getId()}" type="checkbox" {if $workschedule->getChecked()} checked="checked" {/if} /> {$workschedule->getName()}
            </label>
            {if $workschedule->getHasField()}
            <input id="project-information-program-information-{$workschedule->getId()}-text" name="relationships[workschedules][{$workschedule->getId()}][egyeb]" class="disable-on-unchecked" type="text" value="{$workschedule->getMisc()}" {if not $workschedule->getChecked()} disabled="disabled" {/if} />
            <div class="clear"></div>
            {/if}
            {if is_object($workschedule->getObject())}
            {ar_error model=$workschedule->getObject() property='egyeb' view='admin_ar_error.tpl'}
            {/if}
            <input name="relationships[workschedules][{$workschedule->getId()}][ugyfel_attr_munkarend_id]" class="disable-on-unchecked" value="{$workschedule->getRecordId()}" type="hidden" {if not $workschedule->getChecked()} disabled="disabled" {/if} />
        </div>
        {foreachelse}
        <div class="notice warning"><p>Nincs megjeleníthető opció!</p></div>
        {/foreach}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Betölteni kívánt állások, munkakörök</label>
        {include file="modul/ugyfel/view/Admin/Edit/Partial/SheepIt/Job.tpl"}
        <div class="clear"></div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea name="relationships[commentjob][megjegyzes]" class="uw-ugyfelkezelo-input-textarea-megjegyzes">{$client->commentjob->megjegyzes}</textarea>
        {ar_error model=$client->commentjob property='megjegyzes' view='admin_ar_error.tpl'}
        <input name="relationships[commentjob][ugyfel_attr_tab_megjegyzes_id]" value="{$client->commentjob->ugyfel_attr_tab_megjegyzes_id}" type="hidden" />
    </div>
</div>