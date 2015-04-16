<div class="notice">
    <strong>Tipp!</strong> Kezdje el gépelni a feladatot, ha rendszerünk talál hasonlót, akkor felajánlja azt!
</div>
<br />
<div id="feladatForm">
    <div id="feladatForm_template">
        <div>
            <label for="feladatForm_#index#_feladat">Feladat</label>
			<div class="sheepIt-form-block">
            	<input id="feladatForm_#index#_feladat" name="{$piFeladatok}[#index#]" type="text"/>
			</div>
			<a id="feladatForm_remove_current"> <button type="button" class="remove-btn btn btn-sm btn-default" title="Elem eltávolítása!"></button> </a>
			<div class="clear"></div>           
        </div>
        <div class="clear"></div>
    </div>
    <div id="feladatForm_noforms_template">
       {if $isNewRecord}
        	<div class="alert-box">Kérem, adjon az álláshirdetéshez feladatokat!</div>
        {else}
        	<div class="alert-box">Az álláshirdetéshez nem tartozik egyetlen feladat sem!</div>
        {/if}
    </div>
    <div id="feladatForm_controls">
        <div class="sheepIt-add-row" id="feladatForm_add">
			<a href="javascript:;" class="btn btn-default">
                <span>Feladat hozzáadása</span>
            </a>           
        </div>
    </div>
</div>
<div class="clear"></div>