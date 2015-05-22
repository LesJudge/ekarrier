<script type="text/javascript">
$(document).ready(function(){
$('#{$SelTevcsop.name}').on('change',function(){
        var selectedID = $(this).find('option:selected').attr('value');
        
        if(parseInt(selectedID) > 0){
            $.ajax({
                url: '{$DOMAIN}ajax.php?m=tevekenysegikor&al=ajax&todo=filterbygroup&gid='+selectedID, 
                dataType: 'json', 
                success: function(data){
                    resetCircleOpts();
                    filterByGroup(data);
                }, 
                error: function(){
                    resetCircleOpts();
                }
            });
        }else{
            resetCircleOpts();
        }
    });
    
    
    $('#{$SelTevkor.name}').on('change',function(){
        var selectedID = $(this).find('option:selected').attr('value');
        
        if(parseInt(selectedID) > 0){
            $.ajax({
                url: '{$DOMAIN}ajax.php?m=tevekenysegikor&al=ajax&todo=filterbycircle&cid='+selectedID, 
                dataType: 'json', 
                success: function(data){
                    resetGroupOpts();
                    filterByCircle(data);
                }, 
                error: function(){
                    resetGroupOpts();
                }
            });
        }else{
            resetGroupOpts();
        }
    });
    
 });
 
 function filterByGroup(data){
    var IDs = new Array();
    
    for(i=0; i<data.length; i++){
        IDs.push(data[i]['ID']);
    }

    $('#{$SelTevkor.name} option').each(function(){
        if(parseInt($(this).attr('value')) != -1){
            if($.inArray($(this).attr('value'),IDs) == -1){
                $(this).attr('disabled',true);
                $(this).addClass('disabledItemCircle');
            }
        }
    });
}

function filterByCircle(data){
    var IDs = new Array();
    
    for(i=0; i<data.length; i++){
        IDs.push(data[i]['ID']);
    }

    $('#{$SelTevcsop.name} option').each(function(){
        if(parseInt($(this).attr('value')) != -1){
            $(this).prop("selected", false);
            if($.inArray($(this).attr('value'),IDs) == -1){
                $(this).attr('disabled',true);
                $(this).addClass('disabledItemGroup');
            }else{
                $(this).prop("selected",true);
            }   
        }
    });
}

function resetCircleOpts(){
    $('.disabledItemCircle').removeClass('disabledItemCircle');
    $('#{$SelTevkor.name} option').attr('disabled', false);
}

function resetGroupOpts(){
    $('.disabledItemGroup').removeClass('disabledItemGroup');
    $('#{$SelTevcsop.name} option').attr('disabled', false);
}
 
</script>
<style>
.disabledItemCircle, .disabledItemGroup{
    color: darkgrey !important;
    //display:none;
}
</style>


<div class="text-type-2">Belépéshez szükséges adatok</div>
<div class="row">
	<div class="col-lg-12">
		<div class="col-data-3">
				<div class="form_row">
					<input id="{$TxtFnev.name}" name="{$TxtFnev.name}" type="text" value="{$TxtFnev.activ}"  class="form-control" placeholder="Felhasználónév *"/>
					{if isset($TxtFnev.error)}<div class="ui-state-error">{$TxtFnev.error}</div>{/if}
				</div><div class="clear"></div>				
		</div>
	</div>
	<div class="col-lg-12">
		<div class="col-data-3">		
				<div class="form_row">					
					<input type="password" id="{$Password.name}" name="{$Password.name}" value="{$Password.activ}" class="form-control" placeholder="Jelszó *"/>
					{if isset($Password.error)}<div class="ui-state-error">{$Password.error}</div>{/if} 
				</div><div class="clear"></div>
				<div class="form_row">
					<input type="password" id="{$Password2.name}" name="{$Password2.name}" value="{$Password2.activ}" class="form-control" placeholder="Jelszó újra *"/>
					{if isset($Password2.error)}<div class="ui-state-error">{$Password2.error}</div>{/if}
				</div><div class="clear"></div>		
		</div>
	</div>	
	<div class="clear"></div>
</div>	

<div class="text-type-2">Cég adatai</div>
<div class="row">
	<div class="col-lg-12">
		<div class="col-data-3">
				<div class="form_row">
					<input id="{$TxtCegnev.name}" name="{$TxtCegnev.name}" type="text" value="{$TxtCegnev.activ}" class="form-control" placeholder="Cég neve *"/>
					{if isset($TxtCegnev.error)}<div class="ui-state-error">{$TxtCegnev.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<input id="{$TxtCegjegyzekszam.name}" name="{$TxtCegjegyzekszam.name}" type="text" value="{$TxtCegjegyzekszam.activ}"  class="form-control" placeholder="Cégjegyzékszám"/>
					{if isset($TxtCegjegyzekszam.error)}<div class="ui-state-error">{$TxtCegjegyzekszam.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<input id="{$TxtAdoszam.name}" name="{$TxtAdoszam.name}" type="text" value="{$TxtAdoszam.activ}" class="form-control" placeholder="Adószám"/>
					{if isset($TxtAdoszam.error)}<div class="ui-state-error">{$TxtAdoszam.error}</div>{/if}
				</div><div class="clear"></div>				
		</div>
	</div>
	<div class="col-lg-12">
		<div class="col-data-3">		
				<div class="form-row">
					{html_options id=$SelSzektor.name name=$SelSzektor.name options=$SelSzektor.values selected=$SelSzektor.activ class='select-type-1'}
					{if isset($SelSzektor.error)}<div class="ui-state-error">{$SelSzektor.error}</div>{/if}
				</div><div class="clear"></div>				
				<div class="form-row">
					{html_options id=$SelTevcsop.name name=$SelTevcsop.name options=$SelTevcsop.values selected=$SelTevcsop.activ class='select-type-1'}
					{if isset($SelTevcsop.error)}<div class="ui-state-error">{$SelTevcsop.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="form-row">
					{html_options id=$SelTevkor.name name=$SelTevkor.name options=$SelTevkor.values selected=$SelTevkor.activ class='select-type-1'}
					{if isset($SelTevkor.error)}<div class="ui-state-error">{$SelTevkor.error}</div>{/if}
				</div><div class="clear"></div>			
		</div>
	</div>	
	<div class="clear"></div>
</div>	

<div class="text-type-2">Székhely adatok</div>
<div class="row">
	<div class="col-lg-12">
		<div class="col-data-3">
				<div class="form-row">
					{html_options id=$SelSzekhelyOrszag.name name=$SelSzekhelyOrszag.name options=$SelSzekhelyOrszag.values selected=$SelSzekhelyOrszag.activ class='select-type-1'}
					{if isset($SelSzekhelyOrszag.error)}<div class="ui-state-error">{$SelSzekhelyOrszag.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="form-row">
					{html_options id=$SelSzekhelyMegye.name name=$SelSzekhelyMegye.name options=$SelSzekhelyMegye.values selected=$SelSzekhelyMegye.activ class='select-type-1'}
					{if isset($SelSzekhelyMegye.error)}<div class="ui-state-error">{$SelSzekhelyMegye.error}</div>{/if}
				</div>	<div class="clear"></div>		
		</div>
	</div>
	<div class="col-lg-12">
		<div class="col-data-3">		
				<div class="form-row">
					{html_options id=$SelSzekhelyVaros.name name=$SelSzekhelyVaros.name options=$SelSzekhelyVaros.values selected=$SelSzekhelyVaros.activ class='select-type-1'}
					{if isset($SelSzekhelyVaros.error)}<div class="ui-state-error">{$SelSzekhelyVaros.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="form-row">
					{html_options id=$SelSzekhelyIranyitoszam.name name=$SelSzekhelyIranyitoszam.name options=$SelSzekhelyIranyitoszam.values selected=$SelSzekhelyIranyitoszam.activ class='select-type-1'}
					{if isset($SelSzekhelyIranyitoszam.error)}<div class="ui-state-error">{$SelSzekhelyIranyitoszam.error}</div>{/if}
				</div><div class="clear"></div>		
		</div>
	</div>	
	<div class="clear"></div>
</div>	



<div class="text-type-2">Kapcsolattartó adatai</div>
<div class="row">
	<div class="col-lg-12">
		<div class="col-data-3">
				<div class="form_row">
					<input id="{$TxtVnev.name}" name="{$TxtVnev.name}" type="text" value="{$TxtVnev.activ}" placeholder="Vezetéknév *"/>
					{if isset($TxtVnev.error)}<div class="ui-state-error">{$TxtVnev.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<input id="{$TxtKnev.name}" name="{$TxtKnev.name}" type="text" value="{$TxtKnev.activ}" placeholder="Keresztnév *"/>
					{if isset($TxtKnev.error)}<div class="ui-state-error">{$TxtKnev.error}</div>{/if}
				</div><div class="clear"></div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="col-data-3">		
				<div class="form_row">
					<input id="{$TxtEmail.name}" name="{$TxtEmail.name}" type="text" value="{$TxtEmail.activ}" placeholder="E-mail *"/>
					{if isset($TxtEmail.error)}<div class="ui-state-error">{$TxtEmail.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<input id="{$TxtKtoTel.name}" name="{$TxtKtoTel.name}" type="text" value="{$TxtKtoTel.activ}" placeholder="Telefon *"/>
					{if isset($TxtKtoTel.error)}<div class="ui-state-error">{$TxtKtoTel.error}</div>{/if}
				</div><div class="clear"></div>
				<div class="clear"></div>
				<div class="form-row">
					<label for="{$ChkHirlevel.name}">
						<input type="checkbox" id="{$ChkHirlevel.name}" name="{$ChkHirlevel.name}" value="1" style="height:auto;" {if $ChkHirlevel.activ}checked="checked"{/if}/>
						Hírlevélre feliratkozom
					</label>
					{if isset($ChkHirlevel.error)}<div class="ui-state-error">{$ChkHirlevel.error}</div>{/if} 
				</div><div class="clear"></div>
		</div>
	</div>	
	<div class="clear"></div>
</div>	


