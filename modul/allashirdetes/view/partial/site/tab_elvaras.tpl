<div class="field">
    <div class="form_row">
        <div id="elvarasForm">
            <div class="shpt-form shpt-form-elvaras">
                <div class="shpt-form-heading">
                    Elvárás #<span id="elvarasForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="elvarasForm_#index#_elvaras">
                            Elvárás
                            <span class="require">*</span>
                        </label>
                        <input id="elvarasForm_#index#_elvaras" name="{$piElvarasok}[#index#]" type="text" />
                        <input id="elvarasForm_#index#_elvaras_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#elvarasForm_template-->
            <div id="elvarasFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető elvárás!</div><!--/#elvarasForm_noforms_template-->
            <div id="elvarasFormControls" class="shpt-form-controls">
                    <button id="elvarasFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új elvárás</button>
            </div><!--/#elvarasForm_controls-->
        </div><!-- /#elvarasForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->