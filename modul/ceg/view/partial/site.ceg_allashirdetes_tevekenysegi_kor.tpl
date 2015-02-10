<div id="tkorForm">
    <div id="tkorForm_template">
        <div class="job-select">
            <label>Tevékenységi kör</label>            
            <div class="sheepIt-form-block">
				<select class="job-select-main" name="fake" id="tkorForm_#index#_munkakor_fo_id">
					<option value="">--Kérem, válasszon!--</option>
					{foreach from=$munkakorMain key=id item=value}
					<option value="{$id}">{$value}</option>
					{/foreach}
				</select>
				<div class="clear"></div>
				
				<select class="job-select-sub" name="fake" id="tkorForm_#index#_munkakor_al_id">
					<option value="">-- Kérem, válasszon!--</option>
				</select>
				<div class="clear"></div>
				
				<input id="tkorForm_#index#_munkakor_nev" name="fake" class="job-select-name" type="text" />
				<div class="clear"></div>
				
				<input id="tkorForm_#index#_munkakor_id" name="{$piTkor}[#index#][munkakor_id]" class="job-select-id" type="hidden" />
				<div class="clear"></div>				
				
			</div>	
			<a id="tkorForm_remove_current">
				<button type="button" class="remove-btn btn btn-sm btn-default" title="Elem eltávolítása!"></button>
			</a>
			 <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="tkorForm_noforms_template">
        {if $isNewRecord}
        	<div class="alert-box">Kérem, válasszon tevékenységi kört!</div>
        {else}
        	<div class="alert-box">Nem választott egy tevékenységi kört sem!</div>
        {/if}
    </div>
    <div id="tkorForm_controls">
        <div class="sheepIt-add-row" id="tkorForm_add">
            <a href="javascript:;" class="btn btn-default">
                <span>Tevékenységi kör hozzáadása.</span>
            </a>
        </div>
    </div>
</div>
<div class="clear"></div>