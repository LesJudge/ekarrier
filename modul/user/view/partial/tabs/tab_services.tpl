<div class="field">
    <div class="form_row">
        <div id="servicesForm">
            <div class="shpt-form shpt-form-service">
                <div class="shpt-form-heading">
                    Szolgáltatás #<span id="servicesForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="servicesForm_#index#_szolgaltatas_nev">
                            Szolgáltatás
                            <span class="require">*</span><!--/.require-->
                        </label>
                        <input id="servicesForm_#index#_szolgaltatas_nev" name="services[#index#][szolgaltatas_nev]" type="text" />
                        <input id="servicesForm_#index#_szolgaltatas_nev_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <input id="servicesForm_#index#_szolgaltatas_id" name="services[#index#][szolgaltatas_id]" type="text" />
                        <input id="servicesForm_#index#_szolgaltatas_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#servicesForm_template-->
            <div id="servicesFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető szolgáltatás!</div><!--/#servicesForm_noforms_template-->
            <div id="servicesFormControls" class="shpt-form-controls">
                <button id="servicesFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új szolgáltatás</button>
            </div><!--/#servicesForm_controls-->
        </div><!-- /#servicesForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->