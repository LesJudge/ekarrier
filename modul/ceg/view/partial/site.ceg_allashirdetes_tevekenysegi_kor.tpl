<script type="text/javascript">
    function addNewMunkakor(o,event){
        event.preventDefault();
        var name = $(o).parent().find('#ujnev').val();
        var subcatID = $(o).parent().parent().find('.munkakor_al_id').val();
        
        if(name.length < 5){
            alert("Adja meg a munkakör nevét! (Min. 5 karakter)");
            return false;
        }
        
        if(parseInt(subcatID) < 1){
            alert("Válasszon kategóriát!");
            return false;
        }
        
       $.ajax({
            url: '{$DOMAIN}ajax.php?m=munkakor&al=ajax&method=addNewMunkakor&subcatID='+subcatID+'&munkakorName='+name+'', 
            dataType: 'json', 
            contentType:"application/x-www-form-urlencoded; charset=UTF-8",
            success: function(data){
                if(data['message'] === 'OK'){
                    alert('Sikeres felvitel!');
                    $(o).parent().parent().find('.fakeName').attr('value',data['nev']);
                    $(o).parent().parent().find('.job-select-id').attr('value',data['ID']);
                    $(o).parent().parent().find('.munkakor_al_id').trigger('change');
                    $(o).parent().hide();
                }else{
                    alert("Hiba történt! Próbálja meg később!");
                }
            }, 
            error: function(){
                alert('Hiba történt! Próbálja meg később!');
                return false;
            }
        });
    }
</script>
<div class="notice">
    <strong>Tipp!</strong> Kezdje el gépelni a tevékenységi kört, ha rendszerünk talál hasonlót, akkor felajánlja azt!
</div>
<br />
<div id="tkorForm">
    <div id="tkorForm_template">
        <div class="job-select">
            <h3>Tevékenységi kör</h3>            
            <div class="sheepIt-form-block">
				<select class="job-select-main select-type-1" name="fake" id="tkorForm_#index#_munkakor_fo_id">
					<option value="">--Kérem, válasszon!--</option>
					{foreach from=$munkakorMain key=id item=value}
					<option value="{$id}">{$value}</option>
					{/foreach}
				</select>
				<div class="clear"></div>
				
				<select class="job-select-sub munkakor_al_id select-type-1" name="fake" id="tkorForm_#index#_munkakor_al_id">
					<option value="">-- Kérem, válasszon!--</option>
				</select>
				<div class="clear"></div>
				
				<input id="tkorForm_#index#_munkakor_nev" name="fake" class="job-select-name fakeName" type="text" />
				<div class="clear"></div>
                               
                                <div onclick="$(this).next().toggle()" class="btn btn-default btn-sm">Új munkakör felvétele</div>
				<div id="newMkCont" style="display:none">
                                    <input id="ujnev" name="fake" type="text" value="" />  
                                    <div class="clear"></div>
                                    <button id="tkorForm_munkakor_btn" onClick="addNewMunkakor(this)" class="job-select-name btn btn-default btn-sm">Hozzáadás</button>
                                </div>
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