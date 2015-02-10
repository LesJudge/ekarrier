<div class="field">
    <div class="form_row">
        <div id="amitKinalunkForm">
            <div class="shpt-form shpt-form-amitKinalunk">
                <div class="shpt-form-heading">
                    Amit kínálunk #<span id="amitKinalunkForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="amitKinalunkForm_#index#_amitKinalunk">
                            Amit kínálunk
                            <span class="require">*</span>
                        </label>
                        <input id="amitKinalunkForm_#index#_amit_kinalunk" name="{$piAmitKinalunk}[#index#]" type="text" />
                        <input id="amitKinalunkForm_#index#_amit_kinalunk_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#amitKinalunkForm_template-->
            <div id="amitKinalunkFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető adat!</div><!--/#amitKinalunkForm_noforms_template-->
            <div id="amitKinalunkFormControls" class="shpt-form-controls">
                <button id="amitKinalunkFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új opció</button>
            </div><!--/#amitKinalunkForm_controls-->
        </div><!-- /#amitKinalunkForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->