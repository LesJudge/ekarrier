<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="ugyfelkod">Ügyfélkód</label>
            <input 
                id="ugyfelkod" 
                class="uw-ugyfelkezelo-form-row-input" 
                type="text" 
                readonly="readonly" 
                value="{$client->ugyfel_id}" 
            />
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div id="tab-szemelyes-adatok-statusz-row" class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$ClientDataStatus->getAttributeLabel('aktualis_statusz')}</label>
            {html_options 
                name="models[client_data_status][aktualis_statusz]" 
                options=$statusOptions 
                selected=$ClientDataStatus->aktualis_statusz}
            {ar_error model=$ClientDataStatus property='aktualis_statusz' view='admin_ar_error.tpl'}
        </div>
        <div id="field-szemelyes-adatok-idotartam" class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$ClientDataStatus->getAttributeLabel('idotartam')}</label>
            <input name="models[client_data_status][idotartam]" type="text" value="{$ClientDataStatus->idotartam}" />
            {ar_error model=$ClientDataStatus property='idotartam' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$ClientDataStatus->getAttributeLabel('kovetkezo_statusz')}</label>
            {html_options 
                name="models[client_data_status][kovetkezo_statusz]" 
                options=$statusOptions 
                selected=$ClientDataStatus->kovetkezo_statusz}
            {ar_error model=$ClientDataStatus property='kovetkezo_statusz' view='admin_ar_error.tpl'}
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$client->getAttributeLabel('munkakor_kategoria')}</label>
            {html_options 
                name="client[munkakor_kategoria]" 
                options=$munkakorKategoriaOptions 
                selected=$client->munkakor_kategoria}
            {ar_error model=$client property='munkakor_kategoria' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$client->getAttributeLabel('munkaba_allas_allapot')}</label>
            {html_options 
                name="client[munkaba_allas_allapot]" 
                options=$munkabaAllasAllapotOptions 
                selected=$client->munkaba_allas_allapot}
            {ar_error model=$client property='munkaba_allas_allapot' view='admin_ar_error.tpl'}
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="tanacsadoja" class="item-pull-left">Tanácsadója</label>
            <select>
                <option>Tanácsadó</option>
                <option>Tanácsadó</option>
                <option>Tanácsadó</option>
            </select>
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$client->getAttributeLabel('nem')}</label>
            {html_options 
                name="client[nem]" 
                options=$gender 
                selected=$client->nem}
            {ar_error model=$client property='nem' view='admin_ar_error.tpl'}
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserVnev">
                {$client->getAttributeLabel('vezeteknev')}
                <span class="require">*</span>
            </label>
            <input 
                id="clientUserVnev" 
                class="uw-ugyfelkezelo-form-row-input" 
                name="client[vezeteknev]" 
                type="text" 
                value="{$client->vezeteknev}"
            />
            {ar_error model=$client property='vezeteknev' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserKnev">
                {$client->getAttributeLabel('keresztnev')}
                <span class="require">*</span>
            </label>
            <input 
                id="clientUserKnev" 
                class="uw-ugyfelkezelo-form-row-input" 
                name="client[keresztnev]" 
                type="text" 
                value="{$client->keresztnev}"
            />
            {ar_error model=$client property='keresztnev' view='admin_ar_error.tpl'}
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientBirthDataSzuletesiVezeteknev">{$ClientBirthData->getAttributeLabel('szuletesi_vezeteknev')}</label>
            <input 
                id="clientUserVnev" 
                class="uw-ugyfelkezelo-form-row-input" 
                name="models[client_birth_data][szuletesi_vezeteknev]" 
                type="text" 
                value="{$ClientBirthData->szuletesi_vezeteknev}"
            />
            {ar_error model=$ClientBirthData property='szuletesi_vezeteknev' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientBirthDataSzuletesiKeresztnev">{$ClientBirthData->getAttributeLabel('szuletesi_keresztnev')}</label>
            <input 
                id="clientUserKnev" 
                class="uw-ugyfelkezelo-form-row-input" 
                name="models[client_birth_data][szuletesi_keresztnev]" 
                type="text" 
                value="{$ClientBirthData->szuletesi_keresztnev}"
            />
            {ar_error model=$ClientBirthData property='szuletesi_keresztnev' view='admin_ar_error.tpl'}
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$ClientBirthData->getAttributeLabel('szuletesi_hely_orszag_id')}</label>
            {html_options 
                name="models[client_birth_data][szuletesi_hely_orszag_id]" 
                options=$countryOptions 
                selected=$ClientBirthData->szuletesi_hely_orszag_id}
            {ar_error model=$ClientBirthData property='szuletesi_hely_orszag_id' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$ClientBirthData->getAttributeLabel('szuletesi_hely_varos_id')}</label>
            {html_options 
                name="models[client_birth_data][szuletesi_hely_varos_id]" 
                options=$cityOptions  
                selected=$ClientBirthData->szuletesi_hely_varos_id}
            {ar_error model=$ClientBirthData property='szuletesi_hely_orszag_id' view='admin_ar_error.tpl'}
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientBirthDataSzuletesiIdo" class="item-pull-left">
                {$ClientBirthData->getAttributeLabel('szuletesi_ido')}
            </label>
            <div class="uw-datepicker-container">
                <input 
                    id="clientBirthDataSzuletesiIdo" 
                    name="models[client_birth_data][szuletesi_ido]"
                    class="uw-ugyfelkezelo-form-row-input"
                    type="text" 
                    value="{$ClientBirthData->szuletesi_ido}" 
                />
            </div>
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline">
            <input id="clientAge" type="text" disabled="disabled" style="width: 50px; text-align: center;" />
        </div>
        {ar_error model=$ClientBirthData property='szuletesi_ido' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientAnyjaNeve" class="item-pull-left">{$client->getAttributeLabel('anyja_neve')}</label>
            <input 
                id="clientAnyjaNeve" 
                name="client[anyja_neve]" 
                class="uw-ugyfelkezelo-form-row-input"
                type="text" 
                value="{$client->anyja_neve}" 
            />
        </div>
        {ar_error model=$client property='anyja_neve' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row tab-szemelyes-adatok-cim">
        <label>Lakcím</label>
        {if $Residence}
        {html_options 
            name="models[residence][cim_orszag_id]" 
            options=$countryOptions  
            selected=$Residence->cim_orszag_id}
        {html_options 
            name="models[residence][cim_megye_id]" 
            options=$countyOptions  
            selected=$Residence->cim_megye_id}
        {html_options 
            name="models[residence][cim_varos_id]" 
            options=$cityOptions  
            selected=$Residence->cim_varos_id}
        {html_options 
            name="models[residence][cim_iranyitoszam_id]" 
            options=$zipCodeOptions  
            selected=$Residence->cim_iranyitoszam_id}
        <input name="models[residence][utca]" type="text" value="{$Residence->utca}" placeholder="Utca" />
        <input name="models[residence][hazszam]" type="text" value="{$Residence->hazszam}" placeholder="Házszám" />        
        {else}
            <p>Hiba a cím betöltésekor!</p>
        {/if}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row tab-szemelyes-adatok-cim">
        <label>Tartózkodási hely</label>
        {if $DwellingPlace}
        {html_options 
            name="models[dwelling_place][cim_orszag_id]" 
            options=$countryOptions  
            selected=$DwellingPlace->cim_orszag_id}
        {html_options 
            name="models[dwelling_place][cim_megye_id]" 
            options=$countyOptions  
            selected=$DwellingPlace->cim_megye_id}
        {html_options 
            name="models[dwelling_place][cim_varos_id]" 
            options=$cityOptions  
            selected=$DwellingPlace->cim_varos_id}
        {html_options 
            name="models[dwelling_place][cim_iranyitoszam_id]" 
            options=$zipCodeOptions  
            selected=$DwellingPlace->cim_iranyitoszam_id}
        <input name="models[dwelling_place][utca]" type="text" value="{$DwellingPlace->utca}" placeholder="Utca" />
        <input name="models[dwelling_place][hazszam]" type="text" value="{$DwellingPlace->hazszam}" placeholder="Házszám" />        
        {else}
            <p>Hiba a cím betöltésekor!</p>
        {/if}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row tab-szemelyes-adatok-cim">
        <label>Ideiglenes lakcím</label>
        {if $TemporaryResidence}
        {html_options 
            name="models[temporary_residence][cim_orszag_id]" 
            options=$countryOptions  
            selected=$TemporaryResidence->cim_orszag_id}
        {html_options 
            name="models[temporary_residence][cim_megye_id]" 
            options=$countyOptions  
            selected=$TemporaryResidence->cim_megye_id}
        {html_options 
            name="models[temporary_residence][cim_varos_id]" 
            options=$cityOptions  
            selected=$TemporaryResidence->cim_varos_id}
        {html_options 
            name="models[temporary_residence][cim_iranyitoszam_id]" 
            options=$zipCodeOptions  
            selected=$TemporaryResidence->cim_iranyitoszam_id}
        <input name="models[temporary_residence][utca]" type="text" value="{$TemporaryResidence->utca}" placeholder="Utca" />
        <input name="models[temporary_residence][hazszam]" type="text" value="{$TemporaryResidence->hazszam}" placeholder="Házszám" />        
        {else}
            <p>Hiba a cím betöltésekor!</p>
        {/if}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientTelefonszamVezetekes">{$client->getAttributeLabel('telefonszam_vezetekes')}</label>
        <input 
            id="clientTelefonszamVezetekes" 
            name="client[telefonszam_vezetekes]" 
            type="text" 
            value="{$client->telefonszam_vezetekes}" 
        />
        {ar_error model=$client property='telefonszam_vezetekes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientTelefonszamMobil1">{$client->getAttributeLabel('telefonszam_mobil1')}</label>
        <input 
            id="clientTelefonszamMobil1" 
            name="client[telefonszam_mobil1]" 
            type="text" 
            value="{$client->telefonszam_mobil1}" 
        />
        {ar_error model=$client property='telefonszam_mobil1' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientTelefonszamMobil2">{$client->getAttributeLabel('telefonszam_mobil2')}</label>
        <input 
            id="clientTelefonszamMobil2" 
            name="client[telefonszam_mobil2]" 
            type="text" 
            value="{$client->telefonszam_mobil2}" 
        />
        {ar_error model=$client property='telefonszam_mobil2' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientUserEmail">{$client->getAttributeLabel('email')}</label>
        <input type="text" id="clientUserEmail" name="client[email]" value="{$client->email}">
        {ar_error model=$client property='email' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea 
            name="models[comment_personal_data][megjegyzes]" 
            class="uw-ugyfelkezelo-input-textarea-megjegyzes"
        >{if $CommentPersonalData}{$CommentPersonalData->megjegyzes}{/if}</textarea>
        {ar_error model=$CommentPersonalData property='megjegyzes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.uw-ugyfelkezelo-form-->