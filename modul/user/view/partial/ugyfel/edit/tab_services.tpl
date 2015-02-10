<div class="uw-ugyfelkezelo-form">
    {foreach from=$servicesOptions key=serviceId item=serviceName}
    <div class="uw-ugyfelkezelo-service-option">
        <div class="uw-ugyfelkezelo-service-option-service-name">{$serviceName}</div>
        <label class="uw-ugyfelkezelo-service-option-checkbox-label">
            <input 
                class="uw-ugyfelkezelo-service-option-checkbox" 
                name="models[service_interested][{$serviceId}][reszt_akar_venni]" 
                type="checkbox" 
                {if $ServiceInterested[$serviceId]['reszt_akar_venni']}checked{/if}
            />
            Részt akar rajta venni
        </label>
        <label class="uw-ugyfelkezelo-service-option-checkbox-label">
            <input 
                class="uw-ugyfelkezelo-service-option-checkbox"
                name="models[service_interested][{$serviceId}][reszt_vett]" 
                type="checkbox" 
                {if $ServiceInterested[$serviceId]['reszt_vett']}checked{/if}
            />
            Részt vett rajta
        </label>
        <input 
            class="uw-ugyfelkezelo-service-option-service-id"
            name="models[service_interested][{$serviceId}][szolgaltatas_id]" 
            type="hidden" 
            value="{$serviceId}" 
            {if not isset($ServiceInterested[$serviceId])}disabled{/if}
        />
    </div>
    {foreachelse}
    <div>Nincs megjeleníthető szolgáltatás!</div>
    {/foreach}
</div>
<style type="text/css">
.uw-ugyfelkezelo-service-option .uw-ugyfelkezelo-service-option-checkbox {
    
}
.uw-ugyfelkezelo-service-option .uw-ugyfelkezelo-service-option-service-id {
    
}
</style>