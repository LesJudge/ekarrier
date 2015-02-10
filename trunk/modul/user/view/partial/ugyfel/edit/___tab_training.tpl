<div class="field">
    <div class="form_row">
        <div id="trainingsForm">
            <div class="shpt-form shpt-form-training">
                <div class="shpt-form-heading">
                    Képzés #<span id="trainingsForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="trainingsForm_#index#_kepzes_nev">
                            Képzés
                            <span class="require">*</span><!--/.require-->
                        </label>
                        <input id="trainingsForm_#index#_kepzes_nev" type="text" />
                        <input id="trainingsForm_#index#_kepzes_nev_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <input id="trainingsForm_#index#_kepzes_id" name="models[training_interested][#index#][kepzes_id]" type="hidden" />
                        <input id="trainingsForm_#index#_kepzes_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <label>
                            <input class="fake-resztvett" type="checkbox" />
                            <input 
                                id="trainingsForm_#index#_resztvett" 
                                name="models[training_interested][#index#][resztvett]" 
                                type="hidden" 
                            />
                            Résztvett
                        </label>
                        <input id="trainingsForm_#index#_resztvett_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div>
                    <div class="shpt-form-row mikor-field" style="display: none;">
                        <label for="trainingsForm_#index#_mikor">Mikor</label>
                        <input 
                            id="trainingsForm_#index#_mikor" 
                            name="models[training_interested][#index#][mikor]" 
                            type="text" 
                        />
                        <input id="trainingsForm_#index#_mikor_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div>
                </div><!--/.shpt-form-body-->
            </div><!--/#trainingsForm_template-->
            <div id="trainingsFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető képzés!</div><!--/#trainingsForm_noforms_template-->
            <div id="trainingsFormControls" class="shpt-form-controls">
                <button id="trainingsFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új képzés</button>
            </div><!--/#trainingsForm_controls-->
        </div><!-- /#trainingsForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->