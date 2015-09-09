<div id="jobForm">
    <div class="shpt-form shpt-form-job">
        <div class="shpt-form-heading">
            Munkakör #<span id="jobForm_label"></span>
            <button class="shpt-form-button shpt-form-remove-current" type="button"></button>
        </div>
        <div class="shpt-form-body">
            <!--
            <div class="shpt-form-row">
                <input id="jobForm_#index#_key" type="hidden" value="" />
                <input id="jobForm_#index#_key_error" type="hidden" value="" />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
            -->
            <div class="shpt-form-row">
                <div class="job-select">
                    <input 
                        id="jobForm_#index#_ugyfel_attr_munkakor_id" 
                        name="relationships[jobs][#index#][ugyfel_attr_munkakor_id]" 
                        type="hidden" 
                    />
                    <input 
                        id="jobForm_#index#_ugyfel_attr_munkakor_id_error" 
                        name="" 
                        type="hidden" 
                    />
                </div>
            </div>
            <div class="shpt-form-row">
                <input id="jobForm_#index#_munkakor_nev" name="relationships[jobs][#index#][munkakor_nev]" type="text" />
                <input id="jobForm_#index#_munkakor_nev_error" name="" type="hidden"  />
                <div class="shpt-form-error">shpt-form-error-dummy</div>
            </div>
        </div>
    </div>
    <div id="jobFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető munkakör!</div>
    <div id="jobFormControls" class="shpt-form-controls">
        <button id="jobFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új munkakör</button>
    </div>
</div>