<div class="field">
    <div class="form_row">
        <div id="jobForm">
            <div class="shpt-form shpt-form-job">
                <div class="shpt-form-heading">
                    Munkakör #<span id="jobForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <input id="jobForm_#index#_key" type="hidden" value="" />
                        <input id="jobForm_#index#_key_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div>
                    <div class="shpt-form-row">
                        <div class="job-select">
                            <!--
                            <select class="job-select-main" name="models[client_job][#index#][categories][]">
                                <option value="">--Kérem, válasszon!--</option>
                                {foreach from=$jobMainCategories key=id item=value}
                                <option value="{$id}">{$value}</option>
                                {/foreach}
                            </select>
                            <select class="job-select-sub" name="models[client_job][#index#][categories][]">
                                <option value="">-- Kérem, válasszon!--</option>
                            </select>
                            -->
                            <input class="job-select-main" name="models[client_job][#index#][categories][]" type="hidden" value="112" />
                            <input class="job-select-sub" name="models[client_job][#index#][categories][]" type="hidden" value="114" />
                            <input class="job-select-name" name="models[client_job][#index#][munkakor_nev]" type="text" />
                            <input class="job-select-id" name="models[client_job][#index#][munkakor_id]" value="" type="hidden" />
                            <div class="clear"></div>
                        </div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#jobForm_template-->
            <div id="jobFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető munkakör!</div><!--/#jobForm_noforms_template-->
            <div id="jobFormControls" class="shpt-form-controls">
                    <button id="jobFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új munkakör</button>
            </div><!--/#jobForm_controls-->
        </div><!-- /#jobForm -->
    </div>
    <div class="clear"></div>
</div>
<style type="text/css">
.job-select select {
    display: block;
    float: none;
    margin-bottom: 16px;
}
</style>