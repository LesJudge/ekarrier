<div class="field">
    <div class="form_row">
        <div id="educationForm">
            <div class="shpt-form shpt-form-education">
                <div class="shpt-form-heading">
                    Tanulmány #<span id="educationForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <input id="educationForm_#index#_user_attr_vegzettseg_id" name="models[user_education][#index#][user_attr_vegzettseg_id]" type="hidden" value="" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div>
                    <div class="shpt-form-row">
                        <label>{$models.userEducation->getAttributeLabel('vegzettseg_id')}</label>
                        <select id="educationForm_#index#_vegzettseg_id" name="models[user_education][#index#][vegzettseg_id]">
                            {foreach from=$educationOptions key=key item=name}
                            <option value="{$key}">{$name}</option>
                            {/foreach}
                        </select>
                        <div class="clear"></div>
                        <input id="educationForm_#index#_vegzettseg_id_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row" style="display: none;">
                        <label for="educationForm_#index#_user_attr_vegzettseg_iskola">{$models.userEducation->getAttributeLabel('user_attr_vegzettseg_iskola')}</label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_iskola" name="models[user_education][#index#][user_attr_vegzettseg_iskola]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_iskola_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row" style="display: none;">
                        <label for="educationForm_#index#_user_attr_vegzettseg_kezdet">{$models.userEducation->getAttributeLabel('user_attr_vegzettseg_kezdet')}</label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_kezdet" name="models[user_education][#index#][user_attr_vegzettseg_kezdet]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_kezdet_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row" style="display: none;">
                        <label for="educationForm_#index#_user_attr_vegzettseg_veg">{$models.userEducation->getAttributeLabel('user_attr_vegzettseg_veg')}</label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_veg" name="models[user_education][#index#][user_attr_vegzettseg_veg]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_veg_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row" style="display: none;">
                        <label for="educationForm_#index#_user_attr_vegzettseg_szak">{$models.userEducation->getAttributeLabel('user_attr_vegzettseg_szak')}</label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_szak" name="models[user_education][#index#][user_attr_vegzettseg_szak]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_szak_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                    <div class="shpt-form-row">
                        <label for="educationForm_#index#_user_attr_vegzettseg_megnevezes">{$models.userEducation->getAttributeLabel('user_attr_vegzettseg_megnevezes')}</label>
                        <input id="educationForm_#index#_user_attr_vegzettseg_megnevezes" name="models[user_education][#index#][user_attr_vegzettseg_megnevezes]" type="text" />
                        <input id="educationForm_#index#_user_attr_vegzettseg_megnevezes_error" type="hidden" value="" />
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#educationForm_template-->
            <div id="educationFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető tanulmány!</div><!--/#educationForm_noforms_template-->
            <div id="educationFormControls" class="shpt-form-controls">
                    <button id="educationFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új tanulmány</button>
            </div><!--/#educationForm_controls-->
        </div><!-- /#educationForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->