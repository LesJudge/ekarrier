<div class="uw-ugyfelkezelo-form">
    <div id="tab-munkakorokmunkarend-munkarend" class="uw-ugyfelkezelo-form-row">
        <label>{$ProjectInformation->getAttributeLabel('munkarend_id')}</label>
        {foreach from=$wsOptions item=ws key=key}
        <div 
            class="uw-ugyfelkezelo-form-client-info-chkbox 
            {if $ws->has_field}uw-ugyfelkezelo-form-client-info-chkbox-with-text{/if}"
        >
            {assign var="isChecked" value=array_key_exists($ws->munkarend_id, $selectedWss)}
            <label>
                <input 
                    id="project-information-client-work-schedules-{$ws->munkarend_id}" 
                    name="models[client_work_schedules][{$key}][munkarend_id]" 
                    value="{$ws->munkarend_id}"
                    type="checkbox"
                    {if $isChecked}checked{/if}
                />
                {$ws->munkarend_nev}
            </label>
            {if $ws->has_field}
            <input 
                id="project-information-client-work-schedules-{$ws->munkarend_id}-text" 
                name="models[client_work_schedules][{$key}][egyeb]" 
                type="text"
                {if not $isChecked}disabled{/if}
                {if $isChecked}value="{$selectedPis[$ws->munkarend_id]}"{/if}
            />
            <div class="clear"></div>
            {/if}
        </div>
        {/foreach}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Betölteni kívánt állások, munkakörök</label>
        {include file="modul/ugyfel/view/partial/edit/sheep_it_jobs.tpl"}
        <div class="clear"></div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline">
            <label for="clientEgyebMunkakorokErdeklik" style="width: auto !important; padding-right: 20px;">{$client->getAttributeLabel('egyeb_munkakorok_erdeklik')}</label>
            <input 
                id="clientEgyebMunkakorokErdeklik" 
                name="client[egyeb_munkakorok_erdeklik]" 
                class="uw-ugyfelkezelo-form-row-input"
                type="text" 
                value="{$client->egyeb_munkakorok_erdeklik}" 
            />
        </div>
        {ar_error model=$client property='egyeb_munkakorok_erdeklik' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea 
            name="models[comment_job][megjegyzes]" 
            class="uw-ugyfelkezelo-input-textarea-megjegyzes"
        >{if $CommentJob}{$CommentJob->megjegyzes}{/if}</textarea>
        {ar_error model=$CommentJob property='megjegyzes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.uw-ugyfelkezelo-form-->