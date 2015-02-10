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
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>{$ClientDataStatus->getAttributeLabel('aktualis_statusz')}</label>
            <input type="text" readonly="readonly" value="{$statusOptions[$ClientDataStatus->aktualis_statusz]}" />
        </div>
        <!--<button class="tab-ugyfel-informacio-btn-tab-edit" type="button">Szerkeszt</button>-->
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="tanacsadoja" class="item-pull-left">Tanácsadója</label>
            <input 
                id="tanacsadoja" 
                class="uw-ugyfelkezelo-form-row-input" 
                type="text" 
                readonly="readonly" 
                value="" 
            />
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Munkakör kategória</label>
            <input type="text" readonly="readonly" value="" />
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Munkába állás állapota</label>
            <input type="text" readonly="readonly" value="" />
        </div>
        <!--<button class="tab-ugyfel-informacio-btn-tab-edit" type="button">Szerkeszt</button>-->
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserVnev">{$client->getAttributeLabel('vezeteknev')}</label>
            <input 
                id="clientUserVnev" 
                class="uw-ugyfelkezelo-form-row-input" 
                type="text" 
                readonly="readonly" 
                value="{$client->vezeteknev}"
            />
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserKnev">{$client->getAttributeLabel('keresztnev')}</label>
            <input 
                id="clientUserKnev" 
                class="uw-ugyfelkezelo-form-row-input" 
                type="text" 
                readonly="readonly" 
                value="{$client->keresztnev}"
            />
        </div>
        <!--<button class="tab-ugyfel-informacio-btn-tab-edit" type="button">Szerkeszt</button>-->
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="szuletesi_hely" class="item-pull-left">Születési hely</label>
            <input 
                id="szuletesi_hely" 
                class="uw-ugyfelkezelo-form-row-input" 
                type="text" 
                readonly="readonly" 
                value="" 
            />
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientDataSzuletesiIdo" class="item-pull-left">
                {*$ClientBirthData->getAttributeLabel('szuletesi_ido')*}
                Születési idő
            </label>
            <div class="uw-datepicker-container">
                <input 
                    class="uw-ugyfelkezelo-form-row-input"
                    type="text" 
                    readonly="readonly" 
                    value="{$ClientBirthData->szuletesi_ido}" 
                />
            </div>
        </div>
        <!--<button class="tab-ugyfel-informacio-btn-tab-edit" type="button">Szerkeszt</button>-->
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientDataAnyjaNeve" class="item-pull-left">{$client->getAttributeLabel('anyja_neve')}</label>
            <input 
                id="clientDataAnyjaNeve" 
                class="uw-ugyfelkezelo-form-row-input"
                type="text" 
                readonly="readonly" 
                value="{$client->anyja_neve}" 
            />
        </div>
        <!--<button class="tab-ugyfel-informacio-btn-tab-edit" type="button">Szerkeszt</button>-->
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div id="field-lakcim" class="uw-ugyfelkezelo-form-row tab-szemelyes-adatok-cim">
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
        <input name="models[residence][utca]" type="text" value="{$Residence->utca}" />
        <input name="models[residence][hazszam]" type="text" value="{$Residence->hazszam}" />        
        {else}
            <p>Hiba a cím betöltésekor!</p>
        {/if}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label class="item-pull-left">{$client->getAttributeLabel('vegzettseg_id')}</label>
            <input type="text" readonly="readonly" value="{$highestDegreeOptions[$client->vegzettseg_id]}" />
        </div>
        <!--<button class="tab-ugyfel-informacio-btn-tab-edit" type="button">Szerkeszt</button>-->
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <!--
    <div class="uw-ugyfelkezelo-form-row">
        <div>Adott időpontok, tanácsadás ideje, tanácsadó neve</div>
        <div>Megjelent</div>
    </div>
    -->
    <!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label id="field-label-hirlevel">{$client->getAttributeLabel('user_hirlevel')}</label>
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
        <label>Összes megjegyzés megjelenítése</label>
        <textarea 
            name="models[comment_client_information][megjegyzes]" 
            class="uw-ugyfelkezelo-input-textarea-megjegyzes"
        >{if $CommentClientInformation}{$CommentClientInformation->megjegyzes}{/if}</textarea>
        {ar_error model=$CommentClientInformation property='megjegyzes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.uw-ugyfelkezelo-form-->