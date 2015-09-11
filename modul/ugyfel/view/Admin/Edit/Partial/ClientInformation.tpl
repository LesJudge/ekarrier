<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="ugyfelkod">Ügyfélkód</label>
            <input id="ugyfelkod" class="uw-ugyfelkezelo-form-row-input" type="text" readonly="readonly" value="{$client->ugyfel_id}" />
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Aktuális státusz</label>
            <input type="text" readonly="readonly" value="{$client->status->statuscurrent->nev}" />
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="tanacsadoja" class="item-pull-left">Tanácsadója</label>
            <input id="tanacsadoja" class="uw-ugyfelkezelo-form-row-input" type="text" readonly="readonly" value="{$consultant}" />
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Munkakör kategória</label>
            <input type="text" readonly="readonly" value="{$client->jobcategory->nev}" />
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label>Munkába állás állapota</label>
            <input type="text" readonly="readonly" value="{$client->employmentstatus->nev}" />
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserVnev">Vezetéknév</label>
            <input id="clientUserVnev" class="uw-ugyfelkezelo-form-row-input" type="text" readonly="readonly" value="{$client->vezeteknev}" />
        </div>
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientUserKnev">Keresztnév</label>
            <input id="clientUserKnev" class="uw-ugyfelkezelo-form-row-input" type="text" readonly="readonly" value="{$client->keresztnev}" />
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="szuletesi_hely" class="item-pull-left">Születési hely</label>
            <input id="szuletesi_hely" class="uw-ugyfelkezelo-form-row-input" type="text" readonly="readonly" value="{$birthDataDecorator->getFullBirthplace()}" />
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientDataSzuletesiIdo" class="item-pull-left">Születési idő</label>
            <div class="uw-datepicker-container">
                <input class="uw-ugyfelkezelo-form-row-input" type="text" readonly="readonly" value="{$birthDataDecorator->getBirthDate()}" />
            </div>
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline">
            <label for="clientDataAnyjaNeve" class="item-pull-left">Anyja neve</label>
            <input id="clientDataAnyjaNeve" class="uw-ugyfelkezelo-form-row-input"type="text" readonly="readonly" value="{$client->anyja_neve}" />
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row" style="width: 100%;">
        <div class="uw-ugyfelkezelo-form-row uw-ugyfelkezelo-form-row-inline tab-ugyfel-informacio-input-inline" style="width: 100%;">
            <label class="item-pull-left" style="width: 16%;">Legmagasabb iskolai végzettség</label>
            <input type="text" readonly="readonly" value="{$client->highesteducation->nev}" style="width: 30% !important;" />
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label id="field-label-hirlevel">Hírlevélre feliratkozott</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input name="client[user_hirlevel]" type="radio" {if $client->user_hirlevel eq 1} checked="checked" {/if}value="1" /> Igen
            </label>
        </div>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input name="client[user_hirlevel]" type="radio" {if $client->user_hirlevel eq 0} checked="checked" {/if}value="0" /> Nem
            </label>
        </div>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea id="client-information-comments-textarea" name="relationships[commentclientinformation][megjegyzes]" class="uw-ugyfelkezelo-input-textarea-megjegyzes" disabled="disabled">{$collectedComments}</textarea>
    </div>
</div>