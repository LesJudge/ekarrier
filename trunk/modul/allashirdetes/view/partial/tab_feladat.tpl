<div class="field">
    <div class="form_row">
        <div id="feladatForm">
            <div class="shpt-form shpt-form-feladat">
                <div class="shpt-form-heading">
                    Feladat #<span id="feladatForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="feladatForm_#index#_feladat">
                            Feladat
                            <span class="require">*</span>
                        </label>
                        <input id="feladatForm_#index#_feladat" name="{$piFeladatok}[#index#]" type="text" />
                        <input id="feladatForm_#index#_feladat_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#feladatForm_template-->
            <div id="feladatFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető feladat!</div><!--/#feladatForm_noforms_template-->
            <div id="feladatFormControls" class="shpt-form-controls">
                    <button id="feladatFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új feladat</button>
            </div><!--/#feladatForm_controls-->
        </div><!-- /#feladatForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->