<div class="notice">
    <strong>Tipp!</strong> Kezdje el gépelni a kompetenciát, ha rendszerünk talál hasonlót, akkor felajánlja azt!
</div>
<br />
<div id="kompetenciaForm">
    <div id="kompetenciaForm_template">
        
            <label for="kompetenciaForm_#index#_kompetencia">Kompetencia</label>
			<div class="sheepIt-form-block">
            	<!--input id="kompetenciaForm_#index#_kompetencia_id" name="{$piKompetenciak}[#index#]" type="text"/-->
                          
                            <select class="" name="kompetenciak[#index#][kompetencia_id]" id="kompetenciaForm_#index#_kompetencia_id">
					<option value="">--Kérem, válasszon!--</option>
					{foreach from=$kompetenciakSel item=value}
					<option value="{$value.kompetencia_id}">{$value.Nev}</option>
					{/foreach}
                            </select>
                         
                                
			</div>
			<a id="kompetenciaForm_remove_current"> <button type="button" class="remove-btn btn btn-sm btn-default" title="Elem eltávolítása!"></button> </a>
			<div class="clear"></div>           
        
        <div class="clear"></div>
    </div>
    <div id="kompetenciaForm_noforms_template">
       {if $isNewRecord}
        	<div class="alert-box">Kérem, adjon az álláshirdetéshez kompetenciákat!</div>
        {else}
        	<div class="alert-box">Az álláshirdetéshez nem tartozik egyetlen kompetencia sem!</div>
        {/if}
    </div>
    <div id="kompetenciaForm_controls">
        <div class="sheepIt-add-row" id="kompetenciaForm_add">
			<a href="javascript:;" class="btn btn-default">
                <span>Kompetencia hozzáadása</span>
            </a>           
        </div>
    </div>
</div>
<div class="clear"></div>