<div id="cKnowledgeForm">
    <div class="shpt-form shpt-form-cknowledge">
        <div class="shpt-form-heading">
            Számítógépes ismeret #<span id="cKnowledgeForm_label"></span>
            <button class="shpt-form-button shpt-form-remove-current" type="button"></button>
        </div>
        <div class="shpt-form-body">
            <div class="shpt-form-row">
                <input id="cKnowledgeForm_#index#_ugyfel_attr_szamitogepes_ismeret_id" name="relationships[computerknowledges][#index#][ugyfel_attr_szamitogepes_ismeret_id]" type="hidden" value="" />
                <input id="cKnowledgeForm_#index#_ugyfel_attr_szamitogepes_ismeret_id_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            <div class="shpt-form-row">
                <label for="cKnowledgeForm_#index#_ismeret">Ismeret <span class="require">*</span></label>
                <input id="cKnowledgeForm_#index#_ismeret" name="relationships[computerknowledges][#index#][ismeret]" type="text" />
                <input id="cKnowledgeForm_#index#_ismeret_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
        </div>
    </div>
    <div id="cKnowledgeFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető számítógépes ismeret!</div>
    <div id="cKnowledgeFormControls" class="shpt-form-controls">
        <button id="cKnowledgeFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új számítógépes ismeret</button>
    </div>
</div>