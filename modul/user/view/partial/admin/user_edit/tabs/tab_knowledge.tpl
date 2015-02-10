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
                                                <input id="knowledgeForm_#index#_user_nyelvtudas_id" name="knowledges[#index#][user_nyelvtudas_id]" type="text" value="" />
                                                <label>Nyelv</label>
                                                <select id="knowledgeForm_#index#_vegzettseg_id" name="knowledges[#index#][nyelvtudas_nyelv_id]">
                                                        {foreach from=$langsAc item=lang}
                                                        <option value="{$lang.nyelvtudas_nyelv_id}">{$lang.nyelvtudas_nyelv_nev}</option>
                                                        {/foreach}
                                                </select>
                                                <div class="clear"></div>
                                        </div><!--/.shpt-form-row-->
                                        <div class="shpt-form-row">
                                                <label>Szint</label>
                                                <select id="knowledgeForm_#index#_vegzettseg_id" name="knowledges[#index#][nyelvtudas_szint_id]">
                                                        {foreach from=$levelsAc item=level}
                                                        <option value="{$level.nyelvtudas_szint_id}">{$level.nyelvtudas_szint_nev}</option>
                                                        {/foreach}
                                                </select>
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
<script type="text/javascript">
/*<![CDATA[*/
$(function() {

        $("#knowledgeFormControls .shpt-form-button").button({
                icons: {
                        primary: "ui-icon-plusthick"
                }
        });

        var knowledgeForm = $("#knowledgeForm").sheepIt({
                addSelector: "#knowledgeFormAddBtn",
                controlsSelector: "#knowledgeFormControls",
                formTemplateSelector: ".shpt-form-knowledge",
                noFormsTemplateSelector: "#knowledgeFormNoTemplate",
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
                        console.log($("#knowledgeForm .shpt-form").length);
                }
        });

});
/*]]>*/
</script>