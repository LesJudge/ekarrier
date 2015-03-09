<div id="knowledgeForm">
    <div class="shpt-form shpt-form-knowledge">
        <div class="shpt-form-heading">Nyelvtudás #<span id="knowledgeForm_label"></span><button class="shpt-form-button shpt-form-remove-current" type="button"></button></div>
        <div class="shpt-form-body">
            <div class="shpt-form-row">
                <label>Nyelv <span class="require">*</span></label>
                <select id="knowledgeForm_#index#_nyelvtudas_nyelv_id" name="relationships[knowledges][#index#][nyelvtudas_nyelv_id]">
                    <option value="">--Kérem, válasszon!--</option>
                    {foreach from=$nyelvtudasLanguages item=nyelvtudasLanguage}
                    <option value="{$nyelvtudasLanguage->nyelvtudas_nyelv_id}">{$nyelvtudasLanguage->nev}</option>
                    {/foreach}
                </select>
                <input id="knowledgeForm_#index#_nyelvtudas_nyelv_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
                <div class="clear"></div>
            </div>
            <div class="shpt-form-row">
                <label>Szint <span class="require">*</span></label>
                <select id="knowledgeForm_#index#_nyelvtudas_szint_id" name="relationships[knowledges][#index#][nyelvtudas_szint_id]">
                    <option value="">--Kérem, válasszon!--</option>
                    {foreach from=$nyelvtudasLevels item=nyelvtudasLevel}
                    <option value="{$nyelvtudasLevel->nyelvtudas_szint_id}">{$nyelvtudasLevel->nev}</option>
                    {/foreach}
                </select>
                <input id="knowledgeForm_#index#_nyelvtudas_szint_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
                <div class="clear"></div>
            </div>
            <input id="knowledgeForm_#index#_ugyfel_attr_nyelvtudas_id" name="relationships[knowledges][#index#][ugyfel_attr_nyelvtudas_id]" type="hidden" />
            <input id="knowledgeForm_#index#_ugyfel_attr_nyelvtudas_id_error" type="hidden" />
        </div>
    </div>
    <div id="knowledgeFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető nyelvtudás!</div>
    <div id="knowledgeFormControls" class="shpt-form-controls"><button id="knowledgeFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új nyelvtudás</button></div>
</div>