<div id="addressForm">
    <div class="shpt-form shpt-form-address">
        <div class="shpt-form-heading">
            Cím
            <button class="shpt-form-button shpt-form-remove-current" type="button"></button>
            <!--<button class="shpt-form-button shpt-address-edit-current" type="button">Szerkesztés</button>-->
        </div>
        <div class="shpt-form-body">
            <div class="shpt-form-row">
                <input id="addressForm_#index#_ugyfel_attr_cim_id" name="relationships[addresses][#index#][ugyfel_attr_cim_id]" type="hidden" value="" />
                <input id="addressForm_#index#_ugyfel_attr_cim_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row">
                <label for="addressForm_#index#_ugyfel_cim_tipus_id">Típus <span class="require">*</span></label>
                <select id="addressForm_#index#_ugyfel_cim_tipus_id" name="relationships[addresses][#index#][ugyfel_cim_tipus_id]">
                <option value="">--Kérem, válasszon!--</option>
                {foreach from=$ugyfelAddressTypes item=ugyfelAddressType}
                <option value="{$ugyfelAddressType->ugyfel_cim_tipus_id}">{$ugyfelAddressType->nev}</option>
                {/foreach}
                </select>
                <input id="addressForm_#index#_ugyfel_cim_tipus_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
                <div class="clearfix"></div>
            </div>
                <!--
            <div class="shpt-form-row shpt-address-edit-row">
                <label for="addressForm_#index#_cim_orszag_id">Ország <span class="require">*</span></label>
                <select id="addressForm_#index#_cim_orszag_id" name="relationships[addresses][#index#][cim_orszag_id]"></select>
                <input id="addressForm_#index#_cim_orszag_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row shpt-address-edit-row">
                <label for="addressForm_#index#_cim_megye_id">Megye <span class="require">*</span></label>
                <select id="addressForm_#index#_cim_megye_id" name="relationships[addresses][#index#][cim_megye_id]"></select>
                <input id="addressForm_#index#_cim_megye_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row shpt-address-edit-row">
                <label for="addressForm_#index#_cim_varos_id">Város <span class="require">*</span></label>
                <select id="addressForm_#index#_cim_varos_id" name="relationships[addresses][#index#][cim_varos_id]"></select>
                <input id="addressForm_#index#_cim_varos_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row shpt-address-edit-row">
                <label for="addressForm_#index#_cim_iranyitoszam_id">Irányítószám <span class="require">*</span></label>
                <select id="addressForm_#index#_cim_iranyitoszam_id" name="relationships[addresses][#index#][cim_iranyitoszam_id]"></select>
                <input id="addressForm_#index#_cim_iranyitoszam_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            -->
            <div class="shpt-form-row shpt-address-info-row">
                <label for="addressForm_#index#_orszag">Ország</label>
                <input id="addressForm_#index#_orszag" name="relationships[addresses][#index#][orszag]" type="text" />
                <input id="addressForm_#index#_orszag_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row shpt-address-info-row">
                <label for="addressForm_#index#_megye">Megye</label>
                <input id="addressForm_#index#_megye" name="relationships[addresses][#index#][megye]" type="text" />
                <input id="addressForm_#index#_megye_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row shpt-address-info-row">
                <label for="addressForm_#index#_varos">Város</label>
                <input id="addressForm_#index#_varos" name="relationships[addresses][#index#][varos]" type="text" />
                <input id="addressForm_#index#_varos_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row shpt-address-info-row">
                <label for="addressForm_#index#_iranyitoszam">Irányítószám</label>
                <input id="addressForm_#index#_iranyitoszam" name="relationships[addresses][#index#][iranyitoszam]" type="text" />
                <input id="addressForm_#index#_iranyitoszam_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row">
                <label for="addressForm_#index#_utca">Utca</label>
                <input id="addressForm_#index#_utca" name="relationships[addresses][#index#][utca]" type="text" />
                <input id="addressForm_#index#_utca_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row">
                <label for="addressForm_#index#_hazszam">Házszám</label>
                <input id="addressForm_#index#_hazszam" name="relationships[addresses][#index#][hazszam]" type="text" />
                <input id="addressForm_#index#_hazszam_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
        </div>
    </div>
    <div id="addressFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető cím</div>
    <div id="addressFormControls" class="shpt-form-controls">
        <button id="addressFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button" style="width: 250px;">Új cím hozzáadása</button>
    </div>
</div>