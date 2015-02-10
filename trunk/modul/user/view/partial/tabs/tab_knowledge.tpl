<div class="field">
    <div class="form_row">
        <div id="knowledgeForm">
            <div class="shpt-form shpt-form-knowledge">
                <div class="shpt-form-heading">
                    Nyelvtudás #<span id="knowledgeForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label>
                            Nyelv
                            <span class="require">*</span><!--/.require-->
                        </label>
                        <select id="knowledgeForm_#index#_nyelvtudas_nyelv_id" name="knowledges[#index#][nyelvtudas_nyelv_id]">
                            {foreach from=$langLangsOptions item=lang}
                            <option value="{$lang.nyelvtudas_nyelv_id}">{$lang.nyelvtudas_nyelv_nev}</option>
                            {/foreach}
                        </select>
                        <input id="knowledgeForm_#index#_nyelvtudas_nyelv_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                        <div class="clear"></div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <label>
                            Szint
                            <span class="require">*</span><!--/.require-->
                        </label>
                        <select id="knowledgeForm_#index#_nyelvtudas_szint_id" name="knowledges[#index#][nyelvtudas_szint_id]">
                            {foreach from=$langLevelsOptions item=level}
                            <option value="{$level.nyelvtudas_szint_id}">{$level.nyelvtudas_szint_nev}</option>
                            {/foreach}
                        </select>
                        <input id="knowledgeForm_#index#_nyelvtudas_szint_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                        <div class="clear"></div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#knowledgeForm_template-->
            <div id="knowledgeFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető nyelvtudás!</div><!--/#knowledgeForm_noforms_template-->
            <div id="knowledgeFormControls" class="shpt-form-controls">
                    <button id="knowledgeFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új nyelvtudás</button>
            </div><!--/#knowledgeForm_controls-->
        </div><!-- /#knowledgeForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->