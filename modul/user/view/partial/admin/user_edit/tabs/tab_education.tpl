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
                                                <input id="educationForm_#index#_user_attr_vegzettseg_id" name="educations[#index#][user_attr_vegzettseg_id]" type="text" value="" />
                                                <label>Végzettség</label>
                                                <select id="educationForm_#index#_vegzettseg_id" name="educations[#index#][vegzettseg_id]">
                                                        {foreach from=$educationsAc item=education}
                                                        <option value="{$education.vegzettseg_id}">{$education.vegzettseg_nev}</option>
                                                        {/foreach}
                                                </select>
                                                <div class="clear"></div>
                                        </div><!--/.shpt-form-row-->
                                        <div class="shpt-form-row">
                                                <label for="educationForm_#index#_iskola">Iskola</label>
                                                <input id="educationForm_#index#_iskola" name="educations[#index#][user_attr_vegzettseg_iskola]" type="text" />
                                        </div><!--/.shpt-form-row-->
                                        <div class="shpt-form-row">
                                                <label for="educationForm_#index#_kezdet">Kezdés</label>
                                                <input id="educationForm_#index#_kezdet" name="educations[#index#][user_attr_vegzettseg_kezdet]" type="text" />
                                        </div><!--/.shpt-form-row-->
                                        <div class="shpt-form-row">
                                                <label for="educationForm_#index#_veg">Végzés</label>
                                                <input id="educationForm_#index#_veg" name="educations[#index#][user_attr_vegzettseg_veg]" type="text" />
                                        </div><!--/.shpt-form-row-->
                                        <div class="shpt-form-row">
                                                <label for="educationForm_#index#_szak">Szak</label>
                                                <input id="educationForm_#index#_szak" name="educations[#index#][user_attr_vegzettseg_szak]" type="text" />
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
<script type="text/javascript">
/*<![CDATA[*/
$(function() {

        $("#educationFormControls .shpt-form-button").button({
                icons: {
                        primary: "ui-icon-plusthick"
                }
        });

        var educationForm = $("#educationForm").sheepIt({
                addSelector: "#educationFormAddBtn",
                controlsSelector: "#educationFormControls",
                formTemplateSelector: ".shpt-form-education",
                noFormsTemplateSelector: "#educationFormNoTemplate",
                removeCurrentSelector: ".shpt-form-remove-current",
                separator: "",
                allowRemoveLast: false,
                allowRemoveCurrent: true,
                allowRemoveAll: false,
                allowAdd: true,
                allowAddN: false,
                maxFormsCount: 0,
                minFormsCount: 0,
                iniFormsCount: 0,
                afterAdd: function(source, newForm) {
                        console.log("afterAdd");
                        newForm.find(".shpt-form-remove-current").button({
                                icons: {
                                        primary: "ui-icon-trash"
                                },
                                text: false
                        });
                        //newForm.find("input[id$=\"kezdet\"], input[id$=\"veg\"]").datepicker();
                        console.log($(".shpt-form").length);
                }
        });

});
/*]]>*/
</script>