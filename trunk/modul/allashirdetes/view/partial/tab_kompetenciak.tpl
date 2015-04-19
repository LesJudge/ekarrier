<div class="field">
    <div class="form_row">
        <div id="kompetenciaForm">
            <div class="shpt-form shpt-form-kompetencia">
                <div class="shpt-form-heading">
                    Kompetencia #<span id="kompetenciaForm_label"></span>
                    <button class="shpt-form-button shpt-form-remove-current" type="button"></button><!--/.shpt-form-remove-current-->
                </div><!--/.shpt-form-heading-->
                <div class="shpt-form-body">
                    <div class="shpt-form-row">
                        <label for="kompetenciaForm_#index#_kompetenciak">
                            Kompetencia
                            <span class="require">*</span>
                        </label>
                        <select class="" name="{$piKompetenciak}[#index#][kompetencia_id]" id="kompetenciaForm_#index#_kompetencia_id">
    					<option value="">--Kérem, válasszon!--</option>
    					{foreach from=$kompetenciakSel item=value}
                                                <option value="{$value.kompetencia_id}">{$value.Nev}</option>
    					{/foreach}
                        </select>
                        <div class="shpt-form-error">shpt-form-error-dummy</div>
                        <div class="clearfix"></div>
                    </div><!--/.shpt-form-row-->
                </div><!--/.shpt-form-body-->
            </div><!--/#amitKinalunkForm_template-->
            <div id="kompetenciaFormNoTemplate" class="shpt-form-no-template">Nincs megjeleníthető adat!</div><!--/#amitKinalunkForm_noforms_template-->
            <div id="kompetenciaFormControls" class="shpt-form-controls">
                <button id="kompetenciaFormAddBtn" class="shpt-form-button shpt-form-control-add" type="button">Új kompetencia</button>
            </div><!--/#amitKinalunkForm_controls-->
        </div><!-- /#amitKinalunkForm -->
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->
<script type="text/javascript">
    /*
    $(window).load(function(){

    {if $kompetenciak}
        for(i = 0; i<{$kompetenciak}.length; i++)
        {
                         
            var kompval ={$kompetenciak}[i]["kompetenciaForm_#index#_kompetencia_id"];
            $("#kompetenciaForm_"+i+"_kompetencia_id option[value='"+kompval+"']").attr('selected',true);
            
            var text = $("#kompetenciaForm_"+i+"_kompetencia_id").prev();
            text.text("anyáad");  

        }
    {/if}
    
    });
    
*/
</script>