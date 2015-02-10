<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientUserVnev">
            {$client->getAttributeLabel('user_vnev')}
            <span class="require">*</span>
        </label>
        <input type="text" id="clientUserVnev" name="client[user_vnev]" value="{$client->user_vnev}">
        {ar_error model=$client property='user_vnev' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientUserKnev">
            {$client->getAttributeLabel('user_knev')}
            <span class="require">*</span>
        </label>
        <input type="text" id="clientUserKnev" name="client[user_knev]" value="{$client->user_knev}">
        {ar_error model=$client property='user_knev' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataSzuletesiNev">{$ClientData->getAttributeLabel('szuletesi_nev')}</label>
        <input 
            id="clientDataSzuletesiNev" 
            name="models[client_data][szuletesi_nev]" 
            type="text" 
            value="{$ClientData->szuletesi_nev}" 
        />
        {ar_error model=$ClientData property='szuletesi_nev' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataAnyjaNeve">{$ClientData->getAttributeLabel('anyja_neve')}</label>
        <input 
            id="clientDataAnyjaNeve" 
            name="models[client_data][anyja_neve]" 
            type="text" 
            value="{$ClientData->anyja_neve}" 
        />
        {ar_error model=$ClientData property='anyja_neve' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>{$ClientData->getAttributeLabel('nem')}</label>
        {html_options name="models[client_data][nem]" options=$gender selected=$ClientData->nem}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientUserEmail">{$client->getAttributeLabel('user_email')}</label>
        <input type="text" id="clientUserEmail" name="client[user_email]" value="{$client->user_email}">
        {ar_error model=$client property='user_email' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>{$ClientData->getAttributeLabel('user_allapot_id')}</label>
        {html_options 
            name="models[client_data][user_allapot_id]" 
            options=$stateOptions 
            selected=$ClientData->user_allapot_id}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>{$ClientData->getAttributeLabel('user_statusz_id')}</label>
        {html_options 
            name="models[client_data][user_statusz_id]" 
            options=$statusOptions 
            selected=$ClientData->user_statusz_id}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>{$ClientData->getAttributeLabel('vegzettseg_id')}</label>
        {html_options 
            name="models[client_data][vegzettseg_id]" 
            options=$highestDegreeOptions 
            selected=$ClientData->vegzettseg_id}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataTelefonszamVezetekes">{$ClientData->getAttributeLabel('telefonszam_vezetekes')}</label>
        <input 
            id="clientDataTelefonszamVezetekes" 
            name="models[client_data][telefonszam_vezetekes]" 
            type="text" 
            value="{$ClientData->telefonszam_vezetekes}" 
        />
        {ar_error model=$ClientData property='telefonszam_vezetekes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataTelefonszamMobil1">{$ClientData->getAttributeLabel('telefonszam_mobil1')}</label>
        <input 
            id="clientDataTelefonszamMobil1" 
            name="models[client_data][telefonszam_mobil1]" 
            type="text" 
            value="{$ClientData->telefonszam_mobil1}" 
        />
        {ar_error model=$ClientData property='telefonszam_mobil1' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataTelefonszamMobil2">{$ClientData->getAttributeLabel('telefonszam_mobil2')}</label>
        <input 
            id="clientDataTelefonszamMobil2" 
            name="models[client_data][telefonszam_mobil2]" 
            type="text" 
            value="{$ClientData->telefonszam_mobil2}" 
        />
        {ar_error model=$ClientData property='telefonszam_mobil2' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="lakcim-varos-nev">{$ClientData->getAttributeLabel('lakcim_varos_id')}</label>
        <input id="lakcim-varos-nev" type="text" />
        <input 
            id="clientDataLakcimVarosId" 
            name="models[client_data][lakcim_varos_id]" 
            type="hidden" 
            readonly="readonly" 
        />
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="lakcim-megye-nev">{$ClientData->getAttributeLabel('lakcim_megye_id')}</label>
        <input id="lakcim-megye-nev" type="text" readonly="readonly" />
        <input 
            id="clientDataLakcimMegyeId" 
            name="models[client_data][lakcim_megye_id]" 
            type="hidden" 
            readonly="readonly" 
        />
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="lakcim-iranyitoszam">{$ClientData->getAttributeLabel('lakcim_iranyitoszam_id')}</label>
        <input id="lakcim-iranyitoszam" type="text" readonly="readonly" />
        <input 
            id="clientDataLakcimIranyitoszamId" 
            name="models[client_data][lakcim_iranyitoszam_id]" 
            type="hidden" 
            readonly="readonly" 
        />
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataLakcimUtca">{$ClientData->getAttributeLabel('lakcim_utca')}</label>
        <input 
            id="clientDataLakcimUtca" 
            name="models[client_data][lakcim_utca]" 
            type="text" 
            value="{$ClientData->lakcim_utca}" 
        />
        {ar_error model=$ClientData property='lakcim_utca' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataLakcimHazszam">{$ClientData->getAttributeLabel('lakcim_hazszam')}</label>
        <input 
            id="clientDataLakcimHazszam" 
            name="models[client_data][lakcim_hazszam]" 
            type="text" 
            value="{$ClientData->lakcim_hazszam}" 
        />
        {ar_error model=$ClientData property='lakcim_hazszam' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div id="clientAgeRow" class="uw-ugyfelkezelo-form-row">
        <label for="clientDataSzuletesiIdo">{$ClientData->getAttributeLabel('szuletesi_ido')}</label>
        <input 
            id="clientDataSzuletesiIdo" 
            name="models[client_data][szuletesi_ido]" 
            type="text" 
            value="{$ClientData->szuletesi_ido}" 
        />
        <input id="clientAge" type="text" disabled />
        <div class="clear"></div>
        {ar_error model=$ClientData property='szuletesi_ido' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="szhely-varos-nev">{$ClientData->getAttributeLabel('szhely_varos_id')}</label>
        <input id="szhely-varos-nev" type="text" />
        <input 
            id="clientDataSzhelyVarosId" 
            name="models[client_data][szhely_varos_id]" 
            type="hidden" 
            readonly="readonly" 
        />
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="clear"></div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="szhely-megye-nev">{$ClientData->getAttributeLabel('szhely_megye_id')}</label>
        <input id="szhely-megye-nev" type="text" readonly="readonly" />
        <input 
            id="clientDataSzhelyMegyeId" 
            name="models[client_data][szhely_megye_id]" 
            type="hidden" 
            readonly="readonly" 
        />
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="szhely-iranyitoszam">{$ClientData->getAttributeLabel('szhely_iranyitoszam_id')}</label>
        <input id="szhely-iranyitoszam" type="text" readonly="readonly" />
        <input 
            id="clientDataSzhelyIranyitoszamId" 
            name="models[client_data][szhely_iranyitoszam_id]" 
            type="hidden" 
            readonly="readonly" 
        />
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataMegjegyzes">{$ClientData->getAttributeLabel('megjegyzes')}</label>
        <textarea id="clientDataMegjegyzes"></textarea>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientDataKapcsolatfelvetelIdeje">{$ClientData->getAttributeLabel('kapcsolatfelvetel_ideje')}</label>
        <input 
            id="clientDataKapcsolatfelvetelIdeje" 
            name="models[client_data][kapcsolatfelvetel_ideje]" 
            type="text" 
            value="{$ClientData->kapcsolatfelvetel_ideje}" 
        />
        {ar_error model=$ClientData property='kapcsolatfelvetel_ideje' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.field-->
<div class="field uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <label>{$client->getAttributeLabel('user_hirlevel')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    name="client[user_hirlevel]" 
                    type="radio" 
                    {if $client->user_hirlevel eq 1} checked="checked" {/if}
                    value="1"
                />
                {$activeValues[1]}
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    name="client[user_hirlevel]" 
                    type="radio" 
                    {if $client->user_hirlevel eq 0} checked="checked" {/if}
                    value="0"
                />
                {$activeValues[0]}
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$client property='user_hirlevel' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>{$client->getAttributeLabel('user_aktiv')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    name="client[user_aktiv]" 
                    type="radio" 
                    {if $client->user_aktiv eq 1} checked="checked" {/if}
                    value="1"
                />
                {$activeValues[1]}
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    name="client[user_aktiv]" 
                    type="radio" 
                    {if $client->user_aktiv eq 0} checked="checked" {/if}
                    value="0"
                />
                {$activeValues[0]}
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$client property='user_aktiv' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div>
<style type="text/css">
#clientAgeRow .ui-datepicker-trigger,
#clientAgeRow input {
    float: left;
}
#clientAge {
    margin-left: 12px;
    text-align: center;
    width: 50px;
}
</style>