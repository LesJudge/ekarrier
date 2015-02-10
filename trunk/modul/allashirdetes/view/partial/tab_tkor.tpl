<div class="field">
    <div class="form_row">
        <div id="tkorForm">
            <div class="shpt-form shpt-form-tkor">
                <div class="shpt-form-heading">
                    Tevékenységi kör #<span id="tkorForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="job-select shpt-form-body">
                    <div class="shpt-form-row">
                        <select class="job-select-main" name="fake" id="tkorForm_#index#_munkakor_fo_id">
                            <option value="">--Kérem, válasszon!--</option>
                            {foreach from=$munkakorMain key=id item=value}
                            <option value="{$id}">{$value}</option>
                            {/foreach}
                        </select>
                        <div class="clear"></div>
                    </div>
                    <div class="shpt-form-row">
                        <select class="job-select-sub" name="fake" id="tkorForm_#index#_munkakor_al_id">
                            <option value="">-- Kérem, válasszon!--</option>
                        </select>
                        <div class="clear"></div>
                    </div>
                    <div class="shpt-form-row">
                        <input id="tkorForm_#index#_munkakor_nev" name="fake" class="job-select-name" type="text" />
                        <input id="tkorForm_#index#_munkakor_id" name="{$piTkor}[#index#][munkakor_id]" class="job-select-id" type="hidden" />
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
                <!--
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="tkorForm_#index#_tkor">
                            Tevékenységi kör
                            <span class="require">*</span>
                        </label>
                        <input id="tkorForm_#index#_munkakor_nev" name="{$piTkor}[#index#][munkakor_nev]" type="text" />
                        <input id="tkorForm_#index#_munkakor_nev_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div>
                    <div class="shpt-form-row">
                        <input id="tkorForm_#index#_munkakor_id" name="{$piTkor}[#index#][munkakor_id]" type="hidden" />
                        <input id="tkorForm_#index#_munkakor_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div>
                </div>
                -->
            </div><!--/#tkorForm_template-->
            <div id="tkorFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető tevékenységi kör!</div><!--/#tkorForm_noforms_template-->
            <div id="tkorFormControls" class="shpt-form-controls">
                    <button id="tkorFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új tevékenységi kör</button>
            </div><!--/#tkorForm_controls-->
        </div><!-- /#tkorForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->