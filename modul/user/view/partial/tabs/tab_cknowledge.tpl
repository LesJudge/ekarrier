<div class="field">
    <div class="form_row">
        <div id="cKnowledgeForm">
            <div class="shpt-form shpt-form-cknowledge">
                <div class="shpt-form-heading">
                    Nyelvtudás #<span id="cKnowledgeForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="cKnowledgeForm_#index#_user_attr_vegzettseg_kezdet">
                            Ismeret
                            <span class="require">*</span>
                        </label>
                        <input id="cKnowledgeForm_#index#_ismeret" name="cknowledges[#index#][ismeret]" type="text" />
                        <input id="cKnowledgeForm_#index#_ismeret_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#cKnowledgeForm_template-->
            <div id="cKnowledgeFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető nyelvtudás!</div><!--/#cKnowledgeForm_noforms_template-->
            <div id="cKnowledgeFormControls" class="shpt-form-controls">
                    <button id="cKnowledgeFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új számítógépes ismeret</button>
            </div><!--/#cKnowledgeForm_controls-->
        </div><!-- /#cKnowledgeForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->