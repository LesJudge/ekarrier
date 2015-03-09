<div class="uw-ugyfelkezelo-form">
    {foreach from=$services item=service}
    <div class="uw-ugyfelkezelo-service-option parent-item">
        <div class="uw-ugyfelkezelo-service-option-service-name">{$service->getName()}</div>
        <label class="uw-ugyfelkezelo-service-option-checkbox-label">
            <input 
                class="uw-ugyfelkezelo-service-option-checkbox" 
                name="relationships[services][{$service->getId()}][reszt_akar_venni]" 
                type="checkbox" 
                {if $service->getWantToParticipate()} checked="checked" value="1" {/if}
            /> Részt akar rajta venni
        </label>
        <label class="uw-ugyfelkezelo-service-option-checkbox-label">
            <input 
                class="uw-ugyfelkezelo-service-option-checkbox" 
                name="relationships[services][{$service->getId()}][reszt_vett]" 
                type="checkbox" 
                {if $service->getAttended()} checked="checked" value="1" {/if}
            /> Részt vett rajta
            <input 
                name="relationships[services][{$service->getId()}][mikor]" 
                class="uw-ugyfelkezelo-service-option-disabled uw-ugyfelkezelo-service-mikor disable-on-unchecked" 
                type="text" 
                value="{$service->getWhen()}" 
                {if not $service->getWantToParticipate() and not $service->getAttended()} disabled="disabled" {/if}
                style="float: right; width: 50%;"
            />
        </label>
        <input 
            class="disable-on-unchecked" 
            name="relationships[services][{$service->getId()}][szolgaltatas_id]" 
            type="hidden" 
            value="{$service->getId()}" 
            {if not $service->getWantToParticipate() and not $service->getAttended()} disabled="disabled" {/if}
        />
        <input 
            class="disable-on-unchecked" 
            name="relationships[services][{$service->getId()}][ugyfel_attr_szolgaltatas_erdekelt_id]" 
            value="{$service->getRecordId()}" 
            type="hidden"
            {if not $service->getWantToParticipate() and not $service->getAttended()} disabled="disabled" {/if}
        />
    </div>
    {foreachelse}
    <div class="notice warning"><p>Nincs megjeleníthető opció!</p></div>
    {/foreach}
</div>