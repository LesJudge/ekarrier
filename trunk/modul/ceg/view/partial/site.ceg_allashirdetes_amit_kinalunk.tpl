<div id="amitKinalunkForm">
    <div id="amitKinalunkForm_template">
        <div>
            <label for="amitKinalunkForm_#index#_amit_kinalunk">Amit kínálunk</label>
			<div class="sheepIt-form-block">
            	<input id="amitKinalunkForm_#index#_amit_kinalunk" name="{$piAmitKinalunk}[#index#]" type="text"/>
			</div>           
			<a id="amitKinalunkForm_remove_current"> <button type="button" class="remove-btn btn btn-sm btn-default" title="Elem eltávolítása!"></button> </a>
			<div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="amitKinalunkForm_noforms_template">        
		{if $isNewRecord}
        	<div class="alert-box">Kérem, adj meg, hogy mit kínálnak az álláshirdetéshez!</div>
        {else}
        	<div class="alert-box">Az álláshirdetéshez nem tartozik egyetlen amit kínálunk opció sem!</div>
        {/if}
    </div>
    <div id="amitKinalunkForm_controls">
         <div class="sheepIt-add-row" id="amitKinalunkForm_add">
			<a href="javascript:;" class="btn btn-default">
                <span>Amit kínálunk opció hozzáadása</span>
            </a>           
        </div>
    </div>
</div>
<div class="clear"></div>