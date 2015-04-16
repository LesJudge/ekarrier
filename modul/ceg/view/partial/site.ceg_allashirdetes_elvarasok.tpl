<div class="notice">
    <strong>Tipp!</strong> Kezdje el gépelni az elvárást, ha rendszerünk talál hasonlót, akkor felajánlja azt!
</div>
<br />
<div id="elvarasForm">
    <div id="elvarasForm_template">
        <div>
            <label for="elvarasForm_#index#_elvaras">Elvárás</label>
            <div class="sheepIt-form-block">
				<input id="elvarasForm_#index#_elvaras" name="{$piElvarasok}[#index#]" type="text"/>				
			</div>
			<a id="elvarasForm_remove_current"> <button type="button" class="remove-btn btn btn-sm btn-default" title="Elem eltávolítása!"></button> </a>
			 <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="elvarasForm_noforms_template">        
		{if $isNewRecord}
        	<div class="alert-box"> Kérem, adjon az álláshirdetéshez elvárásokat!</div>
        {else}
        	<div class="alert-box">Az álláshirdetéshez nem tartozik egyetlen elvárás sem!</div>
        {/if}
    </div>
    <div id="elvarasForm_controls">
        <div class="sheepIt-add-row" id="elvarasForm_add">
			<a href="javascript:;" class="btn btn-default">
                <span>Elvárás hozzáadása</span>
            </a>           
        </div>
    </div>
</div>
<div class="clear"></div>