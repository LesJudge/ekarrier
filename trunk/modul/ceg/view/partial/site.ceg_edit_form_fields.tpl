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
            $(this).removeAttr("selected");
            if($.inArray($(this).attr('value'),IDs) == -1){
                $(this).attr('disabled',true);
                $(this).addClass('disabledItemGroup');
            }else{
                $(this).attr("selected",true);
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
<h3>Belépéshez szükséges adatok</h3>
<div class="separator"></div><!--/.separator-->
<div class="form_row">
    <label for="{$TxtFnev.name}">
        Felhasználónév
        <span class="require">*</span><!--/.require-->
    </label>
    <input id="{$TxtFnev.name}" name="{$TxtFnev.name}" type="text" value="{$TxtFnev.activ}" />
    {if isset($TxtFnev.error)}<div class="ui-state-error">{$TxtFnev.error}</div>{/if}
</div><!--/.form_row-->
<div class="clear"></div><!--/.clear-->
<div class="form_row">
    <label for="{$Password.name}">Jelszó&nbsp;<span class="require">*</span></label>
    <input type="password" id="{$Password.name}" name="{$Password.name}" value="{$Password.activ}"/>
    {if isset($Password.error)}<div class="ui-state-error">{$Password.error}</div>{/if} 
</div><!--/.form_row-->
<div class="form_row">
    <label for="{$Password2.name}">Jelszó újra&nbsp;<span class="require">*</span></label>
    <input type="password" id="{$Password2.name}" name="{$Password2.name}" value="{$Password2.activ}"/>
    {if isset($Password2.error)}<div class="ui-state-error">{$Password2.error}</div>{/if}
</div><!--/.form_row-->
<div class="clear"></div><!--/.clear-->
<h3>Cég adatai</h3>
<div class="separator"></div>
<div class="form_row">
    <label for="{$TxtCegnev.name}">Cég neve <span class="require">*</span></label>
    <input id="{$TxtCegnev.name}" name="{$TxtCegnev.name}" type="text" value="{$TxtCegnev.activ}" />
    {if isset($TxtCegnev.error)}<div class="ui-state-error">{$TxtCegnev.error}</div>{/if}
</div><!--/.form_row-->
<div class="clear"></div>
<div class="form_row">
    <label for="{$TxtCegjegyzekszam.name}">Cégjegyzékszám</label>
    <input id="{$TxtCegjegyzekszam.name}" name="{$TxtCegjegyzekszam.name}" type="text" value="{$TxtCegjegyzekszam.activ}" />
    {if isset($TxtCegjegyzekszam.error)}<div class="ui-state-error">{$TxtCegjegyzekszam.error}</div>{/if}
</div><!--/.form_row-->
<div class="form_row">
    <label for="{$TxtAdoszam.name}">Adószám</label>
    <input id="{$TxtAdoszam.name}" name="{$TxtAdoszam.name}" type="text" value="{$TxtAdoszam.activ}" />
    {if isset($TxtAdoszam.error)}<div class="ui-state-error">{$TxtAdoszam.error}</div>{/if}
</div><!--/.form_row-->
<div class="form-row">
    <label for="{$SelSzektor.name}">Szektor <span class="require">*</span></label>
    {html_options id=$SelSzektor.name name=$SelSzektor.name options=$SelSzektor.values selected=$SelSzektor.activ}
    {if isset($SelSzektor.error)}<div class="ui-state-error">{$SelSzektor.error}</div>{/if}
</div>
<div class="clear"></div>

<div class="form-row">
    <label for="{$SelTevcsop.name}">Tevékenységi csoport <span class="require">*</span></label>
    {html_options id=$SelTevcsop.name name=$SelTevcsop.name options=$SelTevcsop.values selected=$SelTevcsop.activ}
    {if isset($SelTevcsop.error)}<div class="ui-state-error">{$SelTevcsop.error}</div>{/if}
</div>
<div class="clear"></div>
<div class="form-row">
    <label for="{$SelTevkor.name}">Tevékenységi kör <span class="require">*</span></label>
    {html_options id=$SelTevkor.name name=$SelTevkor.name options=$SelTevkor.values selected=$SelTevkor.activ}
    {if isset($SelTevkor.error)}<div class="ui-state-error">{$SelTevkor.error}</div>{/if}
</div>
<div class="clear"></div>

<h3>Székhely adatok</h3>
<div class="separator"></div>
<div class="form-row">
    <label for="{$SelSzekhelyOrszag.name}">Ország</label>
    {html_options id=$SelSzekhelyOrszag.name name=$SelSzekhelyOrszag.name options=$SelSzekhelyOrszag.values selected=$SelSzekhelyOrszag.activ}
    {if isset($SelSzekhelyOrszag.error)}<div class="ui-state-error">{$SelSzekhelyOrszag.error}</div>{/if}
</div>
<div class="clear"></div>
<div class="form-row">
    <label for="{$SelSzekhelyMegye.name}">Megye</label>
    {html_options id=$SelSzekhelyMegye.name name=$SelSzekhelyMegye.name options=$SelSzekhelyMegye.values selected=$SelSzekhelyMegye.activ}
    {if isset($SelSzekhelyMegye.error)}<div class="ui-state-error">{$SelSzekhelyMegye.error}</div>{/if}
</div>
<div class="clear"></div>
<div class="form-row">
    <label for="{$SelSzekhelyVaros.name}">Város</label>
    {html_options id=$SelSzekhelyVaros.name name=$SelSzekhelyVaros.name options=$SelSzekhelyVaros.values selected=$SelSzekhelyVaros.activ}
    {if isset($SelSzekhelyVaros.error)}<div class="ui-state-error">{$SelSzekhelyVaros.error}</div>{/if}
</div>
<div class="clear"></div>
<div class="form-row">
    <label for="{$SelSzekhelyIranyitoszam.name}">Irányítószám</label>
    {html_options id=$SelSzekhelyIranyitoszam.name name=$SelSzekhelyIranyitoszam.name options=$SelSzekhelyIranyitoszam.values selected=$SelSzekhelyIranyitoszam.activ}
    {if isset($SelSzekhelyIranyitoszam.error)}<div class="ui-state-error">{$SelSzekhelyIranyitoszam.error}</div>{/if}
</div>
<div class="clear"></div>
<h3>Kapcsolattartó adatai</h3>
<div class="separator"></div><!--/.separator-->
<div class="form_row">
    <label for="{$TxtVnev.name}">
        Vezetéknév
        <span class="require">*</span><!--/.require-->
    </label>
    <input id="{$TxtVnev.name}" name="{$TxtVnev.name}" type="text" value="{$TxtVnev.activ}" />
    {if isset($TxtVnev.error)}<div class="ui-state-error">{$TxtVnev.error}</div>{/if}
</div><!--/.form_row-->
<div class="form_row">
    <label for="{$TxtKnev.name}">
        Keresztnév
        <span class="require">*</span><!--/.require-->
    </label>
    <input id="{$TxtKnev.name}" name="{$TxtKnev.name}" type="text" value="{$TxtKnev.activ}" />
    {if isset($TxtKnev.error)}<div class="ui-state-error">{$TxtKnev.error}</div>{/if}
</div><!--/.form_row-->
<div class="form_row">
    <label for="{$TxtEmail.name}">
        E-mail
        <span class="require">*</span><!--/.require-->
    </label>
    <input id="{$TxtEmail.name}" name="{$TxtEmail.name}" type="text" value="{$TxtEmail.activ}" />
    {if isset($TxtEmail.error)}<div class="ui-state-error">{$TxtEmail.error}</div>{/if}
</div><!--/.form_row-->
<div class="form_row">
    <label for="{$TxtKtoTel.name}">
        Telefon
        <span class="require">*</span><!--/.require-->
    </label>
    <input id="{$TxtKtoTel.name}" name="{$TxtKtoTel.name}" type="text" value="{$TxtKtoTel.activ}" />
    {if isset($TxtKtoTel.error)}<div class="ui-state-error">{$TxtKtoTel.error}</div>{/if}
</div><!--/.form_row-->
<div class="clear"></div><!--/.clear-->
<div class="form-row">
    <label for="{$ChkHirlevel.name}">Hírlevélre feliratkozom</label>
    <input type="checkbox" id="{$ChkHirlevel.name}" name="{$ChkHirlevel.name}" value="1" style="height:auto;" {if $ChkHirlevel.activ}checked="checked"{/if}/>
    {if isset($ChkHirlevel.error)}<div class="ui-state-error">{$ChkHirlevel.error}</div>{/if} 
</div><div class="clear"></div>