<div class="uw-ugyfelkezelo-form">
    <input name="relationships[labormarket][ugyfel_id]" value="{$client->labormarket->ugyfel_id}" type="hidden" />
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Pályakezdő</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-palyakezdo-1" name="relationships[labormarket][palyakezdo]" type="radio" value="1" {if $client->labormarket->palyakezdo === 1} checked="checked" {/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-palyakezdo-0" name="relationships[labormarket][palyakezdo]" type="radio" value="0" {if $client->labormarket->palyakezdo === 0} checked="checked" {/if}/> Nem
            </label>            
        </div>
        {ar_error model=$client->labormarket property='palyakezdo' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Regisztrált munkanélküli</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-regisztralt-munkanelkuli-1" name="relationships[labormarket][regisztralt_munkanelkuli]" type="radio" value="1"{if $client->labormarket->regisztralt_munkanelkuli === 1} checked="checked" {/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-regisztralt-munkanelkuli-0" name="relationships[labormarket][regisztralt_munkanelkuli]" type="radio" value="0"{if $client->labormarket->regisztralt_munkanelkuli === 0} checked="checked" {/if} /> Nem
            </label>            
        </div>
        {ar_error model=$client->labormarket property='regisztralt_munkanelkuli' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="labor-market-mikor-regisztralt" class="item-pull-left">Mikor regisztrált</label>
        <div class="uw-datepicker-container">
            <input id="labor-market-mikor-regisztralt" name="relationships[labormarket][mikor_regisztralt]" type="text" value="{$client->labormarket->mikor_regisztralt}" />
        </div>
        {ar_error model=$client->labormarket property='mikor_regisztralt' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">GYES-GYED visszatérő</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-gyes-gyed-visszatero-1" name="relationships[labormarket][gyes_gyed_visszatero]" type="radio" value="1"{if $client->labormarket->gyes_gyed_visszatero === 1} checked="checked" {/if} /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-gyes-gyed-visszatero-0" name="relationships[labormarket][gyes_gyed_visszatero]" type="radio" value="0"{if $client->labormarket->gyes_gyed_visszatero === 0} checked="checked" {/if} /> Nem
            </label>            
        </div>
        {ar_error model=$client->labormarket property='gyes_gyed_visszatero' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="labor-market-gyes-gyed-lejar-datum"class="item-pull-left">GYES-GYED lejárati dátum</label>
        <div class="uw-datepicker-container">
            <input id="labor-market-gyes-gyed-lejar-datum" name="relationships[labormarket][gyes_gyed_lejarati_datum]" type="text" value="{$client->labormarket->gyes_gyed_lejarati_datum}" />
        </div>
        {ar_error model=$client->labormarket property='gyes_gyed_lejarati_datum' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Megváltozott munkaképességű</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-megvaltozott-mkepessegu-1" name="relationships[labormarket][megvaltozott_munkakepessegu]" type="radio" value="1"{if $client->labormarket->megvaltozott_munkakepessegu === 1} checked="checked" {/if} /> Igen
            </label>            
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-megvaltozott-mkepessegu-0" name="relationships[labormarket][megvaltozott_munkakepessegu]" type="radio" value="0"{if $client->labormarket->megvaltozott_munkakepessegu === 0} checked="checked" {/if} /> Nem
            </label>            
        </div>
        {ar_error model=$client->labormarket property='megvaltozott_munkakepessegu' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="labor-market-mvegzes-keok" class="item-pull-left">Munkavégzést korlátozó egyéb okok</label>
        <textarea id="labor-market-mvegzes-keok" name="relationships[labormarket][munkavegzest_korlatozo_egyeb_okok]" cols="5" rows="5">{$client->labormarket->munkavegzest_korlatozo_egyeb_okok}</textarea>
        {ar_error model=$client->labormarket property='munkavegzest_korlatozo_egyeb_okok' view='admin_ar_error.tpl'}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="labor-market-kov-felulv-date" class="item-pull-left">Következő felülvizsgálat ideje</label>
        <div class="uw-datepicker-container">
            <input id="labor-market-kov-felulv-date" name="relationships[labormarket][kovetkezo_felulvizsgalat_ideje]" type="text" value="{$client->labormarket->kovetkezo_felulvizsgalat_ideje}" />
            {ar_error model=$client->labormarket property='kovetkezo_felulvizsgalat_ideje' view='admin_ar_error.tpl'}
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">Dolgozik</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-dolgozik-1" name="relationships[labormarket][dolgozik]" type="radio" value="1"{if $client->labormarket->dolgozik === 1} checked="checked" {/if} /> Igen
            </label>            
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input id="labor-market-dolgozik-0" name="relationships[labormarket][dolgozik]" type="radio" value="0"{if $client->labormarket->dolgozik === 0} checked="checked" {/if} /> Nem
            </label>            
        </div>
        {ar_error model=$client->labormarket property='dolgozik' view='admin_ar_error.tpl'}
    </div>
    <div id="tab-labor-market-workplace-data">
        <div class="uw-ugyfelkezelo-form-row">
            <label for="labor-market-dolgozik-nev" class="item-pull-left">Cég név</label>
            <input id="labor-market-dolgozik-nev" name="relationships[labormarket][dolgozik_nev]" type="text" value="{$client->labormarket->dolgozik_nev}" />
            {ar_error model=$client->labormarket property='dolgozik_nev' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row">
            <label for="labor-market-dolgozik-cim" class="item-pull-left">Cég cím</label>
            <input id="labor-market-dolgozik-cim" name="relationships[labormarket][dolgozik_cim]" type="text" value="{$client->labormarket->dolgozik_cim}" />
            {ar_error model=$client->labormarket property='dolgozik_cim' view='admin_ar_error.tpl'}
        </div>
        <div class="uw-ugyfelkezelo-form-row">
            <label for="labor-market-dolgozik-munkakor" class="item-pull-left">Munkakör</label>
            <input id="labor-market-dolgozik-munkakor" name="relationships[labormarket][dolgozik_munkakor]" type="text" value="{$client->labormarket->dolgozik_munkakor}" />
            {ar_error model=$client->labormarket property='dolgozik_munkakor' view='admin_ar_error.tpl'}
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea name="relationships[commentlabormarket][megjegyzes]" class="uw-ugyfelkezelo-input-textarea-megjegyzes">{$client->commentlabormarket->megjegyzes}</textarea>
        {ar_error model=$client->commentlabormarket property='megjegyzes' view='admin_ar_error.tpl'}
        <input name="relationships[commentlabormarket][ugyfel_attr_tab_megjegyzes_id]" value="{$client->commentlabormarket->ugyfel_attr_tab_megjegyzes_id}" type="hidden" />
    </div>
</div>