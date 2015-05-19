<div class="uw-ugyfelkezelo-form">
    <input name="relationships[status][ugyfel_id]" value="{$client->status->ugyfel_id}" type="hidden" />
    <input name="relationships[birthdata][ugyfel_id]" value="{$client->birthdata->ugyfel_id}" type="hidden" />
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="ugyfelkod">Ügyfélkód</label>
            <input id="ugyfelkod" class="uw-ugyfelkezelo-form-row-input" type="text" readonly="readonly" value="{$client->ugyfel_id}" />
            {ar_error model=$client property='ugyfel_id' view='admin_ar_error.tpl'}
        </div>
    </div>
    <div id="tab-szemelyes-adatok-statusz-row" class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Aktuális státusz</label>
            <select name="relationships[status][aktualis_statusz]">
                <option value="">--Kérem, válasszon!--</option>
                {foreach from=$beallitasClientStatus item=status}
                <option value="{$status->ugyfel_statusz_id}" {if $status->ugyfel_statusz_id eq $client->status->aktualis_statusz}selected="selected"{/if}>{$status->nev}</option>
                {/foreach}
            </select>
            {ar_error model=$client->status property='aktualis_statusz' view='admin_ar_error.tpl'}
        </div>
        <div id="field-szemelyes-adatok-idotartam" class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Időtartam</label>
            <input name="relationships[status][idotartam]" type="text" value="{$client->status->idotartam}" />
            {ar_error model=$client->status property='idotartam' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Következő státusz</label>
            <select name="relationships[status][kovetkezo_statusz]">
                <option value="">--Kérem, válasszon!--</option>
                {foreach from=$beallitasClientStatus item=status}
                <option value="{$status->ugyfel_statusz_id}" {if $status->ugyfel_statusz_id eq $client->status->kovetkezo_statusz}selected="selected"{/if}>{$status->nev}</option>
                {/foreach}
            </select>
            {ar_error model=$client->status property='kovetkezo_statusz' view='admin_ar_error.tpl'}
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Munkakör kategória</label>
            <select name="client[ugyfel_munkakor_kategoria_id]">
                <option value="">--Kérem, válasszon!--</option>
                {foreach from=$ugyfelJobCategory item=jobCategory}
                <option value="{$jobCategory->ugyfel_munkakor_kategoria_id}" {if $jobCategory->ugyfel_munkakor_kategoria_id eq $client->ugyfel_munkakor_kategoria_id}selected="selected"{/if}>{$jobCategory->nev}</option>
                {/foreach}
            </select>
            {ar_error model=$client property='ugyfel_munkakor_kategoria_id' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Munkába állás állapota</label>
            <select name="client[ugyfel_munkaba_allas_allapot_id]">
                <option value="">--Kérem, válasszon!--</option>
                {foreach from=$ugyfelEmploymentStatus item=employmentStatus}
                <option value="{$employmentStatus->ugyfel_munkaba_allas_allapot_id}" {if $employmentStatus->ugyfel_munkaba_allas_allapot_id eq $client->ugyfel_munkaba_allas_allapot_id}selected="selected"{/if}>{$employmentStatus->nev}</option>
                {/foreach}
            </select>
            {ar_error model=$client property='ugyfel_munkaba_allas_allapot_id' view='admin_ar_error.tpl'}
        </div>
    </div>
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
            <label>Neme</label>
            {html_options name="client[nem]" options=$gender selected=$client->nem}
            {ar_error model=$client property='nem' view='admin_ar_error.tpl'}
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserVnev">Vezetéknév<span class="require">*</span></label>
            <input id="clientUserVnev" class="uw-ugyfelkezelo-form-row-input" name="client[vezeteknev]" type="text" value="{$client->vezeteknev}" />
            {ar_error model=$client property='vezeteknev' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserKnev">Keresztnév<span class="require">*</span></label>
            <input id="clientUserKnev" class="uw-ugyfelkezelo-form-row-input" name="client[keresztnev]" type="text" value="{$client->keresztnev}" />
            {ar_error model=$client property='keresztnev' view='admin_ar_error.tpl'}
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientBirthDataSzuletesiVezeteknev">Születési vezetéknév</label>
            <input id="clientUserVnev" class="uw-ugyfelkezelo-form-row-input" name="relationships[birthdata][vezeteknev]" type="text" value="{$client->birthdata->vezeteknev}" />
            {ar_error model=$client->birthdata property='vezeteknev' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientBirthDataSzuletesiKeresztnev">Születési keresztnév</label>
            <input id="clientUserKnev" class="uw-ugyfelkezelo-form-row-input" name="relationships[birthdata][keresztnev]" type="text" value="{$client->birthdata->keresztnev}" />
            {ar_error model=$client->birthdata property='keresztnev' view='admin_ar_error.tpl'}
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <button id="birthdata-birthplace-edit-btn" type="button">Szerkesztés</button>
        <div id="birthdata-birthplace-info">
            <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
                <label>Ország</label>
                <input class="uw-ugyfelkezelo-form-row-input" type="text" value="{$client->birthdata->country->nev}" readonly="readonly" />
            </div>
            <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
                <label>Város</label>
                <input class="uw-ugyfelkezelo-form-row-input" type="text" value="{$client->birthdata->city->cim_varos_nev}" readonly="readonly" />
            </div>
        </div>
        <div id="birthdata-birthplace-edit">
            <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
                <label>Ország</label>
                <select id="birthdata-birthplace-country" name="relationships[birthdata][orszag_id]" disabled="disabled"></select>
                <input id="birthdata-birthplace-country-id" value="{$client->birthdata->orszag_id}" type="hidden" />
                {ar_error model=$client->birthdata property='orszag_id' view='admin_ar_error.tpl'}
            </div>
            <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
                <label>Város</label>
                <select id="birthdata-birthplace-city" name="relationships[birthdata][varos_id]" disabled="disabled"></select>
                <input id="birthdata-birthplace-city-id" value="{$client->birthdata->varos_id}" type="hidden" />
                {ar_error model=$client->birthdata property='orszag_id' view='admin_ar_error.tpl'}
            </div>
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientBirthDataSzuletesiIdo" class="item-pull-left">Születési idő</label>
            <div class="uw-datepicker-container">
                <input id="clientBirthDataSzuletesiIdo" name="relationships[birthdata][szuletesi_ido]" class="uw-ugyfelkezelo-form-row-input" type="text" value="{$birthDataDecorator->getBirthDate()}" />
            </div>
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline">
            <input id="clientAge" type="text" disabled="disabled" style="width: 50px; text-align: center;" />
        </div>
        {ar_error model=$client->birthdata property='szuletesi_ido' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientAnyjaNeve" class="item-pull-left">Anyja neve</label>
            <input id="clientAnyjaNeve" name="client[anyja_neve]" class="uw-ugyfelkezelo-form-row-input" type="text" value="{$client->anyja_neve}" />
        </div>
        {ar_error model=$client property='anyja_neve' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientTAJszam" class="item-pull-left">TAJ szám</label>
            <input id="clientTAJszam" name="client[taj_szam]" class="uw-ugyfelkezelo-form-row-input" type="text" value="{$client->taj_szam}" />
        </div>
        {ar_error model=$client property='taj_szam' view='admin_ar_error.tpl'}
    </div>
    {include file="modul/ugyfel/view/Admin/Edit/Partial/SheepIt/Address.tpl"}
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientTelefonszamVezetekes">Vezetékes telefonszám</label>
        <input id="clientTelefonszamVezetekes" name="client[telefonszam_vezetekes]" type="text" value="{$client->telefonszam_vezetekes}" />
        {ar_error model=$client property='telefonszam_vezetekes' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientTelefonszamMobil1">Elsődleges mobilszám</label>
        <input id="clientTelefonszamMobil1" name="client[telefonszam_mobil1]" type="text" value="{$client->telefonszam_mobil1}" />
        {ar_error model=$client property='telefonszam_mobil1' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientTelefonszamMobil2">Másodlagos mobilszám</label>
        <input id="clientTelefonszamMobil2" name="client[telefonszam_mobil2]" type="text" value="{$client->telefonszam_mobil2}" />
        {ar_error model=$client property='telefonszam_mobil2' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="clientUserEmail">Email</label>
        <input type="text" id="clientUserEmail" name="client[email]" value="{$client->email}">
        {ar_error model=$client property='email' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea name="relationships[commentpersonaldata][megjegyzes]" class="uw-ugyfelkezelo-input-textarea-megjegyzes">{$client->commentpersonaldata->megjegyzes}</textarea>
        {ar_error model=$client->commentpersonaldata property='megjegyzes' view='admin_ar_error.tpl'}
        <input name="relationships[commentpersonaldata][ugyfel_attr_tab_megjegyzes_id]" value="{$client->commentpersonaldata->ugyfel_attr_tab_megjegyzes_id}" type="hidden" />
    </div>
</div>