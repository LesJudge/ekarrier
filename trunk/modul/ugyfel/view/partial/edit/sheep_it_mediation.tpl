<div id="mediationForm">
    <div class="shpt-form shpt-form-mediation">
        <div class="shpt-form-heading">
            Közvetítés #<span id="mediationForm_label"></span>
            <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
        </div><!--/.shpt-form-heading-->
        <div class="shpt-form-body">
            <div class="shpt-form-row">
                <label for="mediationForm_#index#_kozvetites">
                    Közvetítés
                    <span class="require">*</span><!--/.require-->
                </label>
                <input id="mediationForm_#index#_kozvetites" name="models[client_mediation][#index#][kozvetites]" type="text" />
                <input id="mediationForm_#index#_kozvetites_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div><!--/.shpt-form-row-->
            <div class="shpt-form-row mikor-field">
                <label for="mediationForm_#index#_mikor">Mikor</label>
                <input 
                    id="mediationForm_#index#_mikor" 
                    name="models[client_mediation][#index#][mikor]" 
                    type="text" 
                />
                <input id="mediationForm_#index#_mikor_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
        </div><!--/.shpt-form-body-->
    </div><!--/#mediationForm_template-->
    <div id="mediationFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető közvetítés!</div><!--/#mediationForm_noforms_template-->
    <div id="mediationFormControls" class="shpt-form-controls">
        <button id="mediationFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új közvetítés</button>
    </div><!--/#mediationForm_controls-->
</div><!-- /#mediationForm -->