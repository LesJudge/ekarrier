{** Autentikációs adatok **}
{dynamic_filter_text_like data_view="ugyfelDfFirstname" data_name="Vezetéknév" item=$ugyfelDfFirstname item_label=$client->getAttributeLabel('user_vnev')}
{dynamic_filter_text_like data_view="ugyfelDfLastname" data_name="Keresztnév" item=$ugyfelDfLastname item_label=$client->getAttributeLabel('user_knev')}
{dynamic_filter_text_like data_view="ugyfelDfNickname" data_name="Felhasználónév" item=$ugyfelDfNickname item_label=$client->getAttributeLabel('user_fnev')}
{dynamic_filter_text_like data_view="ugyfelDfEmail" data_name="E-mail cím szűrő" item=$ugyfelDfEmail item_label=$client->getAttributeLabel('user_email')}
{dynamic_filter_radios data_view="ugyfelDfNewsletter" data_name="Hírlevél" item=$ugyfelDfNewsletter item_label=$client->getAttributeLabel('user_hirlevel')}
{dynamic_filter_radios data_view="ugyfelDfActive" data_name="Aktív" item=$ugyfelDfActive item_label=$client->getAttributeLabel('user_aktiv')}
{** Ügyfél adatok **}
{dynamic_filter_text_like data_view="ugyfelDfPhone" data_name="Telefonszám szűrő" item=$ugyfelDfPhone item_label=$clientData->getAttributeLabel('telefonszam_vezetekes')}
{**dynamic_filter_select 
    data_view="ugyfelDfCimMegye" 
    data_name="Megye" 
    item=$ugyfelDfCimMegye 
    item_label=$clientData->getAttributeLabel('lakcim_megye_id')**}
{**dynamic_filter_select 
    data_view="ugyfelDfCimVaros" 
    data_name="Város" 
    item=$ugyfelDfCimVaros 
    item_label=$clientData->getAttributeLabel('lakcim_varos_id')**}
{**dynamic_filter_text_like data_view="ugyfelDfLakcim" data_name="Lakcím" item=$ugyfelDfLakcim item_label=$clientData->getAttributeLabel('lakcim_utca')**}
{**dynamic_filter_text_like data_view="ugyfelDfBirthname" data_name="Születési név" item=$ugyfelDfBirthname item_label=$clientData->getAttributeLabel('szuletesi_nev')**}
{**dynamic_filter_text_like data_view="ugyfelDfBirthplace" data_name="Születési hely szűrő" item=$ugyfelDfBirthplace item_label=$clientData->getAttributeLabel('szuletesi_hely')**}
{**dynamic_filter_text_date interval=true data_view="ugyfelDfBirthdate" data_name="Születési idő szűrő" item=$ugyfelDfBirthdate select_labels=$dateLabels item_label=$clientData->getAttributeLabel('szuletesi_ido')**}
{** Munkaerő piaci helyzeti adatok **}
{dynamic_filter_radios data_view="ugyfelDfPalyakezdo" data_name="Pályakezdő" item=$ugyfelDfPalyakezdo item_label=$laborMarket->getAttributeLabel('palyakezdo')}
{dynamic_filter_radios data_view="ugyfelDfRegmunkanelk" data_name="Regisztrált munkanélküli" item=$ugyfelDfRegmunkanelk item_label=$laborMarket->getAttributeLabel('regisztralt_munkanelkuli')}
{dynamic_filter_text_date interval=true data_view="ugyfelDfMikorReg" data_name="Mikor regisztrált" item=$ugyfelDfMikorReg item_label=$laborMarket->getAttributeLabel('mikor_regisztralt')}
{dynamic_filter_radios data_view="ugyfelDfGyesGyedVisszatero" data_name="GYES-GYED visszatérő" item=$ugyfelDfGyesGyedVisszatero item_label=$laborMarket->getAttributeLabel('gyes_gyed_visszatero')}
{dynamic_filter_text_date interval=true data_view="ugyfelDfGyesGyedLejarDatum" data_name="GYES-GYED lejárati dátum" item=$ugyfelDfGyesGyedLejarDatum item_label=$laborMarket->getAttributeLabel('gyes_gyed_lejar_datum')}
{dynamic_filter_radios data_view="ugyfelDfMegvMkep" data_name="Megváltozott munkaképességű" item=$ugyfelDfMegvMkep item_label=$laborMarket->getAttributeLabel('megvaltozott_mkepessegu')}
{dynamic_filter_text_date interval=true data_view="ugyfelDfKovFelulvDatum" data_name="Következő felülvizsgálat dátum" item=$ugyfelDfKovFelulvDatum item_label=$laborMarket->getAttributeLabel('kov_felulv_date')}
{dynamic_filter_text data_view="ugyfelDfMvegzesKeok" data_name="Munkavégzést korlátozó egyéb okok" item=$ugyfelDfMvegzesKeok item_label=$laborMarket->getAttributeLabel('mvegzes_keok')}
{dynamic_filter_radios data_view="ugyfelDfDolgozik" data_name="Dolgozik" item=$ugyfelDfDolgozik item_label=$laborMarket->getAttributeLabel('dolgozik')}
{** Projekt információs adatok **}
{dynamic_filter_radios data_view="ugyfelDfEuProgElmKetEv" data_name="Uniós finanszírozású programban részt vett-e az elmúlt 2 évben" item=$ugyfelDfEuProgElmKetEv item_label=$projectInformation->getAttributeLabel('eu_prog_elm_ket_ev')}
{dynamic_filter_radios data_view="ugyfelDfHazaiProgElmKetEv" data_name="Hazai finanszírozású programban részt vett-e az elmúlt 2 évben" item=$ugyfelDfHazaiProgElmKetEv item_label=$projectInformation->getAttributeLabel('hazai_prog_elm_ket_ev')}
{dynamic_filter_radios data_view="ugyfelDfKozAdatbKerul" data_name="Közvetítői adatbázisba kíván e kerülni" item=$ugyfelDfKozAdatbKerul item_label=$projectInformation->getAttributeLabel('koz_adatb_kerul')}
{** Munkarend **}
{dynamic_filter_checkboxes data_view="ugyfelDfMunkarend" data_name="Munkarend" item=$ugyfelDfMunkarend item_label="Munkarend"}
{** Program információ **}
{dynamic_filter_checkboxes data_view="ugyfelDfProgramInformacio" data_name="Program információ" item=$ugyfelDfProgramInformacio item_label="Program információ"}
{** További projekt információs adatok **}
{dynamic_filter_radios data_view="ugyfelDfHozzajarulMunkakozv" data_name="Hozzájárult-e munkaközvetítéshez" item=$ugyfelDfHozzajarulMunkakozv item_label=$projectInformation->getAttributeLabel('hozjarul_munkakozv')}
{dynamic_filter_radios data_view="ugyfelDfMobilitastVallal" data_name="Mobilitást vállal-e" item=$ugyfelDfMobilitastVallal item_label=$projectInformation->getAttributeLabel('mobilitast_vallal')}
{dynamic_filter_radios data_view="ugyfelDfEgyMegallKtttnkProg" data_name="Együttműködési megállapodást kötöttünk-e vele a programba" item=$ugyfelDfEgyMegallKtttnkProg item_label=$projectInformation->getAttributeLabel('egy_megall_ktttnk_prog')}
{dynamic_filter_radios data_view="ugyfelDfEgyMegallKtttnkKepz" data_name="Együttműködési megállapodást kötöttünk-e vele a képzésbe" item=$ugyfelDfEgyMegallKtttnkKepz item_label=$projectInformation->getAttributeLabel('egy_megall_ktttnk_kepz')}
{dynamic_filter_select data_view="ugyfelDfKepzesBekerult" data_name="Melyik képzésbe került be" item=$ugyfelDfKepzesBekerult item_label=$projectInformation->getAttributeLabel('kepzes_bekerult')}
{dynamic_filter_select 
    data_view="ugyfelDfHovaErkezett" 
    data_name="Hova érkezett" 
    item=$ugyfelDfHovaErkezett 
    item_label=$projectInformation->getAttributeLabel('hova_erkezett_id')}
{** Végzettség adatok **}
{dynamic_filter_text_like data_view="ugyfelDfVegzettsegIskola" data_name="Iskola neve" item=$ugyfelDfVegzettsegIskola item_label=$userEducation->getAttributeLabel('ugyfel_attrvegzettseg_iskola')}
{dynamic_filter_checkboxes data_view="ugyfelDfVegzettsegSzint" data_name="Végzettség típusa" item=$ugyfelDfVegzettsegSzint item_label=$userEducation->getAttributeLabel('vegzettseg_id')}
{dynamic_filter_text_date interval=true data_view="ugyfelDfVegzettsegKezdes" data_name="Kezdés éve" item=$ugyfelDfVegzettsegKezdes item_label=$userEducation->getAttributeLabel('ugyfel_attrvegzettseg_kezdet')}
{dynamic_filter_text_date interval=true data_view="ugyfelDfVegzettsegVegzes" data_name="Végzés éve" item=$ugyfelDfVegzettsegVegzes item_label=$userEducation->getAttributeLabel('ugyfel_attrvegzettseg_veg')}
{dynamic_filter_text_like data_view="ugyfelDfVegzettsegSzak" data_name="Szak" item=$ugyfelDfVegzettsegSzak item_label=$userEducation->getAttributeLabel('ugyfel_attrvegzettseg_szak')}
{** Nyelvtudás adatok **}
<script
    data-uw-dynamic-filter-view="ugyfelDfNyelvtudasNyelv"
    data-uw-dynamic-filter-name="Nyelvtudás (nyelv és szint alapján)"
    data-uw-dynamic-filter-item="{$ugyfelDfNyelvtudasNyelv.name}"
    type="text/html"
>
<div class="uw-df-filter uw-df-filter-checkbox">
    <label>Nyelvtudás</label>
    {foreach from=$ugyfelDfNyelvtudasNyelv.values key=key item=value}
    <label>
        <input 
            name="{$ugyfelDfNyelvtudasNyelv.name}[{$key}]" 
            type="checkbox" 
            value="{$key}"
            {if is_array($ugyfelDfNyelvtudasNyelv.activ) and isset($ugyfelDfNyelvtudasNyelv.activ[$key])} checked="checked"{/if} 
        />
        {$value}
    </label>
    <div>
        {foreach from=$ugyfelDfNyelvtudasSzint.values key=id item=name}
        <label style="float: left; margin-right: 16px;">
            <input 
                name="{$ugyfelDfNyelvtudasSzint.name}[{$key}][{$id}]" 
                type="checkbox"
                {if is_array($ugyfelDfNyelvtudasSzint.activ) and in_array($id, $ugyfelDfNyelvtudasSzint.activ[$key])} checked="checked"{/if} 
                value="{$id}"
            />
            {$name}
        </label>
        {/foreach}
        <div class="clear"></div>
    </div>
    {/foreach}
    <label>
        <input name="{$ugyfelDfNyelvtudasMind.name}" type="checkbox"{if $ugyfelDfNyelvtudasMind.activ eq 1} checked="checked"{/if} />
        Rendelkezzen az összes kiválasztott nyelvvel!
    </label>
</div>
</script>
<script 
    data-uw-dynamic-filter-view="ugyfelDfSzIsmeret"
    data-uw-dynamic-filter-name="Számítógépes ismeret"
    data-uw-dynamic-filter-item="{$ugyfelDfSzIsmeret.name}"
    type="text/html"
>
    <div class="uw-df-filter uw-df-filter-text uw-df-filter-text-like">
        <label>Számítógépes ismeret</label>
        <input id="cknowledge-trigger" type="hidden" value="{(int)is_array($ugyfelDfSzIsmeret.activ)}" />
        <button id="cknowledge-btn-add" type="button">Új ismeret</button>
        <label>
            <input name="{$ugyfelDfSzIsmeretMind.name}" type="checkbox"{if $ugyfelDfSzIsmeretMind.activ eq 1} checked="checked"{/if} />
            Rendelkezzen az összes ismerettel!
        </label>
    </div>
</script>
<!--
<script
    data-uw-dynamic-filter-view="ugyfelDfNyelvtudasSzint"
    data-uw-dynamic-filter-name="Nyelvtudás - Szint"
    data-uw-dynamic-filter-item="{$ugyfelDfNyelvtudasSzint.name}"
    type="text/html"
>
<div class="uw-dynamic-filter-filter">
    <label>Nyelvtudás - Szint</label>
    {html_checkboxes 
        name=$ugyfelDfNyelvtudasSzint.name
        options=$ugyfelDfNyelvtudasSzint.values
        selected=$ugyfelDfNyelvtudasSzint.activ}
</div>
</script>
-->
{** Számítógépes ismeretek **}

