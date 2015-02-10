<div class="field">
    <div class="form_row">
        <div id="educationForm">
            <div class="shpt-form shpt-form-education">
                <div class="shpt-form-heading">
                    Végzettség #<span id="educationForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <input id="educationForm_#index#_user_attr_vegzettseg_id" name="educations[#index#][user_attr_vegzettseg_id]" type="hidden" value="" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                        <label>
                            Végzettség
                            <span class="require">*</span>
                        </label>
                        <select id="educationForm_#index#_vegzettseg_id" name="educations[#index#][vegzettseg_id]">
                            {foreach from=$educationOptions item=education}
                            <option value="{$education.vegzettseg_id}">{$education.vegzettseg_nev}</option>
                            {/foreach}
                        </select>
                        <div class="clear"></div>
                        <input id="educationForm_#index#_vegzettseg_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <label for="educationForm_#index#_user_attr_vegzettseg_iskola">
                            Iskola
                            <span class="require">*</span>
                        </label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_iskola" name="educations[#index#][user_attr_vegzettseg_iskola]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_iskola_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <label for="educationForm_#index#_user_attr_vegzettseg_kezdet">
                            Kezdés éve
                            <span class="require">*</span>
                        </label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_kezdet" name="educations[#index#][user_attr_vegzettseg_kezdet]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_kezdet_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <label for="educationForm_#index#_user_attr_vegzettseg_veg">
                            Végzés éve
                            <span class="require">*</span>
                        </label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_veg" name="educations[#index#][user_attr_vegzettseg_veg]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_veg_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <label for="educationForm_#index#_user_attr_vegzettseg_szak">Szak</label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_szak" name="educations[#index#][user_attr_vegzettseg_szak]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_szak_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#educationForm_template-->
            <div id="educationFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető végzettség!</div><!--/#educationForm_noforms_template-->
            <div id="educationFormControls" class="shpt-form-controls">
                    <button id="educationFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új végzettség</button>
            </div><!--/#educationForm_controls-->
        </div><!-- /#educationForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->