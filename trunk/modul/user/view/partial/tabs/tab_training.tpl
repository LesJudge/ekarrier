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
                        <label for="trainingsForm_#index#_szolgaltatas_nev">
                            Képzés
                            <span class="require">*</span><!--/.require-->
                        </label>
                        <input id="trainingsForm_#index#_szolgaltatas_nev" name="trainings[#index#][kepzes_nev]" type="text" />
                        <input id="trainingsForm_#index#_szolgaltatas_nev_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <input id="trainingsForm_#index#_szolgaltatas_id" name="trainings[#index#][kepzes_id]" type="text" />
                        <input id="trainingsForm_#index#_szolgaltatas_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
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