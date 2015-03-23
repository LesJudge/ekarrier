<h3>Belépéshez szükséges adatok</h3><div class="separator"></div>

<div class="form-row">
        <label for="{$TxtFnev.name}">Felhasználónév <span class="require">*</span></label>
        <input type="text" id="{$TxtFnev.name}" name="{$TxtFnev.name}" value="{$TxtFnev.activ}"/>
        {if isset($TxtFnev.error)}<div class="ui-state-error">{$TxtFnev.error}</div>{/if} 
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtEmail.name}">E-mail cím <span class="require">*</span></label>
        <input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}" value="{$TxtEmail.activ}"/>
        {if isset($TxtEmail.error)}<div class="ui-state-error">{$TxtEmail.error}</div>{/if} 
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$Password.name}">Jelszó{if $passwordRequired} <span class="require">*</span>{/if}</label>
        <input type="password" id="{$Password.name}" name="{$Password.name}" value="{$Password.activ}"/>
        {if isset($Password.error)}<div class="ui-state-error">{$Password.error}</div>{/if} 
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$Password2.name}">Jelszó mégegyszer{if $passwordRequired} <span class="require">*</span>{/if}</label>
        <input type="password" id="{$Password2.name}" name="{$Password2.name}" value="{$Password2.activ}"/>
        {if isset($Password2.error)}<div class="ui-state-error">{$Password2.error}</div>{/if}
</div><div class="clear"></div>

<h3>Személyes adatok</h3><div class="separator"></div>
<div class="form-row">
        <label for="{$TxtVnev.name}">Vezetéknév <span class="require">*</span></label>
        <input type="text" id="{$TxtVnev.name}" name="{$TxtVnev.name}" value="{$TxtVnev.activ}"/>
        {if isset($TxtVnev.error)}<div class="ui-state-error">{$TxtVnev.error}</div>{/if} 
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtKnev.name}">Keresztnév <span class="require">*</span></label>
        <input type="text" id="{$TxtKnev.name}" name="{$TxtKnev.name}" value="{$TxtKnev.activ}"/>
        {if isset($TxtKnev.error)}<div class="ui-state-error">{$TxtKnev.error}</div>{/if} 
</div><div class="clear"></div>
<div style="display: none">
            <div class="form-row">
                    <label for="{$SelNem.name}">Nem <span class="require">*</span></label>
                    {html_options id=$SelNem.name name=$SelNem.name options=$SelNem.values selected=$SelNem.activ}
                    {if isset($SelNem.error)}<div class="ui-state-error">{$SelNem.error}</div>{/if}
            </div><div class="clear"></div>

            <div class="form-row">
                    <label for="{$TxtAnyjaNeve.name}">Anyja neve</label>
                    <input type="text" id="{$TxtAnyjaNeve.name}" name="{$TxtAnyjaNeve.name}" value="{$TxtAnyjaNeve.activ}"/>
                    {if isset($TxtAnyjaNeve.error)}<div class="ui-state-error">{$TxtAnyjaNeve.error}</div>{/if} 
            </div><div class="clear"></div>

            <div class="form-row">
                    <label for="{$TxtTelszamVezetekes.name}">Vezetékes telefonszám</label>
                    <input id="{$TxtTelszamVezetekes.name}" name="{$TxtTelszamVezetekes.name}" type="text" value="{$TxtTelszamVezetekes.activ}" />
                    {if isset($TxtTelszamVezetekes.error)}<div class="ui-state-error">{$TxtTelszamVezetekes.error}</div>{/if}
            </div><div class="clear"></div>
</div>
<div class="form-row">
        <!--label for="{$TxtTelszamMobil1.name}">Elsődleges mobiltelefonszám <span class="require">*</span></label-->
        <label for="{$TxtTelszamMobil1.name}">Mobiltelefonszám <span class="require">*</span></label>
        <input id="{$TxtTelszamMobil1.name}" name="{$TxtTelszamMobil1.name}" type="text" value="{$TxtTelszamMobil1.activ}" />
        {if isset($TxtTelszamMobil1.error)}<div class="ui-state-error">{$TxtTelszamMobil1.error}</div>{/if}
</div><div class="clear"></div>

<div style="display: none">
        <div class="form-row">
                <label for="{$TxtTelszamMobil2.name}">Másodlagos mobiltelefonszám</label>
                <input id="{$TxtTelszamMobil2.name}" name="{$TxtTelszamMobil2.name}" type="text" value="{$TxtTelszamMobil2.activ}" />
                {if isset($TxtTelszamMobil2.error)}<div class="ui-state-error">{$TxtTelszamMobil2.error}</div>{/if}
        </div><div class="clear"></div>
</div>
        
        
<div class="form-row">
        <label for="{$SelVegzettseg.name}">Legmagasabb iskolai végzettség <span class="require">*</span></label>
        {html_options id=$SelVegzettseg.name name=$SelVegzettseg.name options=$SelVegzettseg.values selected=$SelVegzettseg.activ}
        {if isset($SelVegzettseg.error)}<div class="ui-state-error">{$SelVegzettseg.error}</div>{/if}
</div><div class="clear"></div>

<div style="display: none">


<h3>Születési adatok</h3>
<div class="separator"></div>

<div class="form-row">
        <label for="{$DateSzulIdo.name}">Születési idő <span class="require">*</span></label>
        <input id="{$DateSzulIdo.name}" name="{$DateSzulIdo.name}" type="text" value="{$DateSzulIdo.activ}" />
        {if isset($DateSzulIdo.error)}<div class="ui-state-error">{$DateSzulIdo.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelSzulhelyOrszag.name}">Ország <span class="require">*</span></label>
        {html_options id=$SelSzulhelyOrszag.name name=$SelSzulhelyOrszag.name options=$SelSzulhelyOrszag.values selected=$SelSzulhelyOrszag.activ}
        {if isset($SelSzulhelyOrszag.error)}<div class="ui-state-error">{$SelSzulhelyOrszag.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelSzulhelyVaros.name}">Város <span class="require">*</span></label>
        {html_options id=$SelSzulhelyVaros.name name=$SelSzulhelyVaros.name options=$SelSzulhelyVaros.values selected=$SelSzulhelyVaros.activ}
        {if isset($SelSzulhelyVaros.error)}<div class="ui-state-error">{$SelSzulhelyVaros.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtSzulVezeteknev.name}">Születési vezetéknév</label>
        <input type="text" id="{$TxtSzulVezeteknev.name}" name="{$TxtSzulVezeteknev.name}" value="{$TxtSzulVezeteknev.activ}"/>
        {if isset($TxtSzulVezeteknev.error)}<div class="ui-state-error">{$TxtSzulVezeteknev.error}</div>{/if} 
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtSzulKeresztnev.name}">Születési keresztnév</label>
        <input type="text" id="{$TxtSzulKeresztnev.name}" name="{$TxtSzulKeresztnev.name}" value="{$TxtSzulKeresztnev.activ}"/>
        {if isset($TxtSzulKeresztnev.error)}<div class="ui-state-error">{$TxtSzulKeresztnev.error}</div>{/if} 
</div><div class="clear"></div>

<h3>Lakhely</h3>
<div class="selector"></div>

<div class="form-row">
        <label for="{$SelLakhelyOrszag.name}">Ország <span class="require">*</span></label>
        {html_options id=$SelLakhelyOrszag.name name=$SelLakhelyOrszag.name options=$SelLakhelyOrszag.values selected=$SelLakhelyOrszag.activ}
        {if isset($SelLakhelyOrszag.error)}<div class="ui-state-error">{$SelLakhelyOrszag.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelLakhelyMegye.name}">Megye <span class="require">*</span></label>
        {html_options id=$SelLakhelyMegye.name name=$SelLakhelyMegye.name options=$SelLakhelyMegye.values selected=$SelLakhelyMegye.activ}
        {if isset($SelLakhelyMegye.error)}<div class="ui-state-error">{$SelLakhelyMegye.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelLakhelyVaros.name}">Város <span class="require">*</span></label>
        {html_options id=$SelLakhelyVaros.name name=$SelLakhelyVaros.name options=$SelLakhelyVaros.values selected=$SelLakhelyVaros.activ}
        {if isset($SelLakhelyVaros.error)}<div class="ui-state-error">{$SelLakhelyVaros.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelLakhelyIranyitoszam.name}">Irányítószám</label>
        {html_options id=$SelLakhelyIranyitoszam.name name=$SelLakhelyIranyitoszam.name options=$SelLakhelyIranyitoszam.values selected=$SelLakhelyIranyitoszam.activ}
        {if isset($SelLakhelyIranyitoszam.error)}<div class="ui-state-error">{$SelLakhelyIranyitoszam.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtLakhelyUtca.name}">Utca</label>
        <input id="{$TxtLakhelyUtca.name}" name="{$TxtLakhelyUtca.name}" type="text" value="{$TxtLakhelyUtca.activ}" />
        {if isset($TxtLakhelyUtca.error)}<div class="ui-state-error">{$TxtLakhelyUtca.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtLakhelyHazszam.name}">Házszám</label>
        <input id="{$TxtLakhelyHazszam.name}" name="{$TxtLakhelyHazszam.name}" type="text" value="{$TxtLakhelyHazszam.activ}" />
        {if isset($TxtLakhelyHazszam.error)}<div class="ui-state-error">{$TxtLakhelyHazszam.error}</div>{/if}
</div><div class="clear"></div>

<h3>Tartózkodási hely</h3>
<div class="separator"></div>

<div class="form-row">
        <label for="{$SelTarthelyOrszag.name}">Ország</label>
        {html_options id=$SelTarthelyOrszag.name name=$SelTarthelyOrszag.name options=$SelTarthelyOrszag.values selected=$SelTarthelyOrszag.activ}
        {if isset($SelTarthelyOrszag.error)}<div class="ui-state-error">{$SelTarthelyOrszag.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelTarthelyMegye.name}">Megye</label>
        {html_options id=$SelTarthelyMegye.name name=$SelTarthelyMegye.name options=$SelTarthelyMegye.values selected=$SelTarthelyMegye.activ}
        {if isset($SelTarthelyMegye.error)}<div class="ui-state-error">{$SelTarthelyMegye.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelTarthelyVaros.name}">Város</label>
        {html_options id=$SelTarthelyVaros.name name=$SelTarthelyVaros.name options=$SelTarthelyVaros.values selected=$SelTarthelyVaros.activ}
        {if isset($SelTarthelyVaros.error)}<div class="ui-state-error">{$SelTarthelyVaros.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelTarthelyIranyitoszam.name}">Irányítószám</label>
        {html_options id=$SelTarthelyIranyitoszam.name name=$SelTarthelyIranyitoszam.name options=$SelTarthelyIranyitoszam.values selected=$SelTarthelyIranyitoszam.activ}
        {if isset($SelTarthelyIranyitoszam.error)}<div class="ui-state-error">{$SelTarthelyIranyitoszam.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtTarthelyUtca.name}">Utca</label>
        <input id="{$TxtTarthelyUtca.name}" name="{$TxtTarthelyUtca.name}" type="text" value="{$TxtTarthelyUtca.activ}" />
        {if isset($TxtTarthelyUtca.error)}<div class="ui-state-error">{$TxtTarthelyUtca.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtTarthelyHazszam.name}">Házszám</label>
        <input id="{$TxtTarthelyHazszam.name}" name="{$TxtTarthelyHazszam.name}" type="text" value="{$TxtTarthelyHazszam.activ}" />
        {if isset($TxtTarthelyHazszam.error)}<div class="ui-state-error">{$TxtTarthelyHazszam.error}</div>{/if}
</div><div class="clear"></div>

<h3>Ideiglenes lakcím</h3>
<div class="separator"></div>

<div class="form-row">
        <label for="{$SelIdeiglenesOrszag.name}">Ország</label>
        {html_options id=$SelIdeiglenesOrszag.name name=$SelIdeiglenesOrszag.name options=$SelIdeiglenesOrszag.values selected=$SelIdeiglenesOrszag.activ}
        {if isset($SelIdeiglenesOrszag.error)}<div class="ui-state-error">{$SelIdeiglenesOrszag.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelIdeiglenesMegye.name}">Megye</label>
        {html_options id=$SelIdeiglenesMegye.name name=$SelIdeiglenesMegye.name options=$SelIdeiglenesMegye.values selected=$SelIdeiglenesMegye.activ}
        {if isset($SelIdeiglenesMegye.error)}<div class="ui-state-error">{$SelIdeiglenesMegye.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelIdeiglenesVaros.name}">Város</label>
        {html_options id=$SelIdeiglenesVaros.name name=$SelIdeiglenesVaros.name options=$SelIdeiglenesVaros.values selected=$SelIdeiglenesVaros.activ}
        {if isset($SelIdeiglenesVaros.error)}<div class="ui-state-error">{$SelIdeiglenesVaros.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$SelIdeiglenesIranyitoszam.name}">Irányítószám</label>
        {html_options id=$SelIdeiglenesIranyitoszam.name name=$SelIdeiglenesIranyitoszam.name options=$SelIdeiglenesIranyitoszam.values selected=$SelIdeiglenesIranyitoszam.activ}
        {if isset($SelIdeiglenesIranyitoszam.error)}<div class="ui-state-error">{$SelIdeiglenesIranyitoszam.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtIdeiglenesUtca.name}">Utca</label>
        <input id="{$TxtIdeiglenesUtca.name}" name="{$TxtIdeiglenesUtca.name}" type="text" value="{$TxtIdeiglenesUtca.activ}" />
        {if isset($TxtIdeiglenesUtca.error)}<div class="ui-state-error">{$TxtIdeiglenesUtca.error}</div>{/if}
</div><div class="clear"></div>

<div class="form-row">
        <label for="{$TxtIdeiglenesHazszam.name}">Házszám</label>
        <input id="{$TxtIdeiglenesHazszam.name}" name="{$TxtIdeiglenesHazszam.name}" type="text" value="{$TxtIdeiglenesHazszam.activ}" />
        {if isset($TxtIdeiglenesHazszam.error)}<div class="ui-state-error">{$TxtIdeiglenesHazszam.error}</div>{/if}
</div><div class="clear"></div>


</div>
<div class="form-row">
        <label for="{$ChkHirlevel.name}">Álláshirdetésekre és hírlevélre feliratkozom</label>
        <input type="checkbox" id="{$ChkHirlevel.name}" name="{$ChkHirlevel.name}" value="1" style="height:auto;" {if $ChkHirlevel.activ}checked="checked"{/if}/>
        {if isset($ChkHirlevel.error)}<div class="ui-state-error">{$ChkHirlevel.error}</div>{/if} 
</div><div class="clear"></div>