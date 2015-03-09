<div class="uw-ugyfelkezelo-form">
    <input name="relationships[projectinformation][ugyfel_id]" value="{$client->projectinformation->ugyfel_id}" type="hidden" />
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Hova érkezett</label>
        <select name="relationships[projectinformation][karrierpont_id]">
            <option value="">--Kérem, válasszon!--</option>
            {foreach from=$beallitasHovaErkezett item=hovaErkezett}
            <option value="{$hovaErkezett->karrierpont_id}"{if $hovaErkezett->karrierpont_id eq $client->projectinformation->karrierpont_id} selected="selected"{/if}>{$hovaErkezett->nev}</option>
            {/foreach}
        </select>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Az elmúlt 2 évben Uniós finanszírozású foglalkoztatási programban részt vett-e ?</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-eu-prog-elm-ket-ev-1" name="relationships[projectinformation][eu_prog_elm_ket_ev]" type="radio" value="1"{if $client->projectinformation->eu_prog_elm_ket_ev === 1} checked="checked"{/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-eu-prog-elm-ket-ev-0" name="relationships[projectinformation][eu_prog_elm_ket_ev]" type="radio" value="0"{if $client->projectinformation->eu_prog_elm_ket_ev === 0} checked="checked"{/if} /> Nem
            </label>
        </div>
        {ar_error model=$client->projectinformation property='eu_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">A programba bevonás idején hazai foglalkoztatási programban részt vett-e ?</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-hazai-prog-elm-ket-ev-1" name="relationships[projectinformation][hazai_prog_elm_ket_ev]" type="radio" value="1"{if $client->projectinformation->hazai_prog_elm_ket_ev === 1} checked="checked"{/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-hazai-prog-elm-ket-ev-0" name="relationships[projectinformation][hazai_prog_elm_ket_ev]" type="radio" value="0"{if $client->projectinformation->hazai_prog_elm_ket_ev === 0} checked="checked"{/if} /> Nem
            </label>            
        </div>
        {ar_error model=$client->projectinformation property='hazai_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <p>A CSAT Egyesület többek között munkaerő közvetítői tevékenységet is folytat a hatékonyabb álláskeresés támogatása érdekében.</p>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Közvetítőti adatbázisba kíván kerülni ?</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-koz-adatb-kerul-1" name="relationships[projectinformation][kozvetitio_adatbazisba_kivan_kerulni]" type="radio" value="1"{if $client->projectinformation->kozvetitio_adatbazisba_kivan_kerulni === 1} checked="checked"{/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-koz-adatb-kerul-0" name="relationships[projectinformation][kozvetitio_adatbazisba_kivan_kerulni]" type="radio" value="0"{if $client->projectinformation->kozvetitio_adatbazisba_kivan_kerulni === 0} checked="checked"{/if} /> Nem
            </label>
        </div>
        {ar_error model=$client->projectinformation property='kozvetitio_adatbazisba_kivan_kerulni' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Mobilitást vállal ?</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-mobilitast-vallal-1" name="relationships[projectinformation][mobilitast_vallal]" type="radio" value="1"{if $client->projectinformation->mobilitast_vallal === 1} checked="checked"{/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-mobilitast-vallal-0" name="relationships[projectinformation][mobilitast_vallal]" type="radio" value="0"{if $client->projectinformation->mobilitast_vallal === 0} checked="checked"{/if} /> Nem
            </label>
        </div>
        {ar_error model=$client->projectinformation property='mobilitast_vallal' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="project-information-mobilitast-vallal-megjegyzes">Mobilitást vállal megjegyzés</label>
        <input id="project-information-mobilitast-vallal-megjegyzes" name="relationships[projectinformation][mobilitast_vallal_megjegyzes]" type="text" value="{$client->projectinformation->mobilitast_vallal_megjegyzes}" />
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Honnan hallott a programról ?</label>
        {foreach from=$programInformations item=programInformation}
        <div class="uw-ugyfelkezelo-form-client-info-chkbox {if $programInformation->getHasField()}uw-ugyfelkezelo-form-client-info-chkbox-with-text{/if} parent-item">
            <label>
                <input id="project-information-program-information-{$programInformation->getId()}" class="program-information-checkbox" name="relationships[programinformations][{$programInformation->getId()}][program_informacio_id]" value="{$programInformation->getId()}" type="checkbox" {if $programInformation->getChecked()} checked="checked" {/if} /> {$programInformation->getName()}
            </label>
            {if $programInformation->getHasField()}
            <input id="project-information-program-information-{$programInformation->getId()}-text" name="relationships[programinformations][{$programInformation->getId()}][egyeb]" class="disable-on-unchecked" type="text" value="{$programInformation->getMisc()}" {if not $programInformation->getChecked()} disabled="disabled" {/if} />
            <div class="clear"></div>
            {/if}
            {if is_object($programInformation->getObject())}{ar_error model=$programInformation->getObject() property='egyeb' view='admin_ar_error.tpl'}{/if}
            <input name="relationships[programinformations][{$programInformation->getId()}][ugyfel_attr_program_informacio_id]" class="disable-on-unchecked" value="{$programInformation->getRecordId()}" type="hidden" {if not $programInformation->getChecked()} disabled="disabled" {/if} />
        </div>
        {foreachelse}
        <div class="notice warning"><p>Nincs megjeleníthető opció!</p></div>
        {/foreach}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Hozzájárul a munkaközvetítéshez ?</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-hozjarul-munkakozv-1" name="relationships[projectinformation][hozzajarul_a_munkakozvetiteshez]" type="radio" value="1"{if $client->projectinformation->hozzajarul_a_munkakozvetiteshez === 1} checked="checked"{/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-hozjarul-munkakozv-0" name="relationships[projectinformation][hozzajarul_a_munkakozvetiteshez]" type="radio" value="0"{if $client->projectinformation->hozzajarul_a_munkakozvetiteshez === 0} checked="checked"{/if} /> Nem
            </label>
        </div>
        {ar_error model=$client->projectinformation property='hozzajarul_a_munkakozvetiteshez' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Együttműködési megállapodást kötöttünk-e vele a programba ?</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-egy_megall-ktttnk-prog-1" name="relationships[projectinformation][egy_megall_ktttnk_prog]" type="radio" value="1"{if $client->projectinformation->egy_megall_ktttnk_prog === 1} checked="checked"{/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-egy_megall-ktttnk-prog-0" name="relationships[projectinformation][egy_megall_ktttnk_prog]" type="radio" value="0"{if $client->projectinformation->egy_megall_ktttnk_prog === 0} checked="checked"{/if} /> Nem
            </label>            
        </div>
        {ar_error model=$client->projectinformation property='egy_megall_ktttnk_prog' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Együttműködési megállapodást kötöttünk-e vele a képzésbe ?</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-egy-megall-ktttnk-kepz-1" name="relationships[projectinformation][egy_megall_ktttnk_kepz]" type="radio" value="1"{if $client->projectinformation->egy_megall_ktttnk_kepz === 1} checked="checked"{/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="project-information-egy-megall-ktttnk-kepz-0" name="relationships[projectinformation][egy_megall_ktttnk_kepz]" type="radio" value="0"{if $client->projectinformation->egy_megall_ktttnk_kepz === 0} checked="checked"{/if} /> Nem
            </label>            
        </div>
        {ar_error model=$client->projectinformation property='egy_megall_ktttnk_kepz' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea name="relationships[commentprojectinformation][megjegyzes]" class="uw-ugyfelkezelo-input-textarea-megjegyzes">{$client->commentprojectinformation->megjegyzes}</textarea>
        {ar_error model=$client->commentprojectinformation property='megjegyzes' view='admin_ar_error.tpl'}
        <input name="relationships[commentprojectinformation][ugyfel_attr_tab_megjegyzes_id]" value="{$client->commentprojectinformation->ugyfel_attr_tab_megjegyzes_id}" type="hidden" />
    </div>
</div>