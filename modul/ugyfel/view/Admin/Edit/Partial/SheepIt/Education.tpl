<div id="educationForm">
    <div class="shpt-form shpt-form-education">
        <div class="shpt-form-heading">
            Tanulmány #<span id="educationForm_label"></span>
            <button class="shpt-form-button shpt-form-remove-current" type="button"></button>
        </div>
        <div class="shpt-form-body">
            <div class="shpt-form-row">
                <input id="educationForm_#index#_ugyfel_attr_vegzettseg_id" name="relationships[educations][#index#][ugyfel_attr_vegzettseg_id]" type="hidden" value="" />
                <input id="educationForm_#index#_ugyfel_attr_vegzettseg_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row">
                <label>Végzettség <span class="require">*</span></label>
                <select id="educationForm_#index#_vegzettseg_id" name="relationships[educations][#index#][vegzettseg_id]">
                    <option value="">--Kérem, válasszon!--</option>
                    {foreach from=$beallitasEducations item=beallitasEducation}
                    <option value="{$beallitasEducation->vegzettseg_id}">{$beallitasEducation->nev}</option>
                    {/foreach}
                </select>
                <div class="clear"></div>
                <input id="educationForm_#index#_vegzettseg_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row" style="display: none;">
                <label for="educationForm_#index#_iskola">Iskola</label>
                <input id="educationForm_#index#_iskola" name="relationships[educations][#index#][iskola]" type="text" />
                <input id="educationForm_#index#_iskola_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row" style="display: none;">
                <label for="educationForm_#index#_kezdet">Kezdés</label>
                <input id="educationForm_#index#_kezdet" name="relationships[educations][#index#][kezdet]" type="text" />
                <input id="educationForm_#index#_kezdet_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row" style="display: none;">
                <label for="educationForm_#index#_veg">Végzés</label>
                <input id="educationForm_#index#_veg" name="relationships[educations][#index#][veg]" type="text" />
                <input id="educationForm_#index#_veg_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row" style="display: none;">
                <label for="educationForm_#index#_szak">Szak</label>
                <input id="educationForm_#index#_szak" name="relationships[educations][#index#][szak]" type="text" />
                <input id="educationForm_#index#_szak_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row">
                <label for="educationForm_#index#_megnevezes">Megnevezés</label>
                <input id="educationForm_#index#_megnevezes" name="relationships[educations][#index#][megnevezes]" type="text" />
                <input id="educationForm_#index#_megnevezes_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
        </div>
    </div>
    <div id="educationFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető tanulmány!</div>
    <div id="educationFormControls" class="shpt-form-controls">
        <button id="educationFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új tanulmány</button>
    </div>
</div>