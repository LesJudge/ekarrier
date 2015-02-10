<div class="field">
    <h2>Alap adatok</h2>
    
    <div class="form_row">
        <label for="{$SelSzektor.name}">Szektor <span class="require">*</span></label>
        {html_options name=$SelSzektor.name options=$SelSzektor.values selected=$SelSzektor.activ}
        {if isset($SelSzektor.error)}<p class="error small">{$SelSzektor.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$TxtCegjegyzekszam.name}">Cégjegyzék szám</label>
        <input id="{$TxtCegjegyzekszam.name}" name="{$TxtCegjegyzekszam.name}" type="text" value="{$TxtCegjegyzekszam.activ}" />
        {if isset($TxtCegjegyzekszam.error)}<p class="error small">{$TxtCegjegyzekszam.error}</p>{/if}
    </div>
    <div class="clear"></div>

    <div class="form_row">
        <label for="{$TxtAdoszam.name}">Adószám</label>
        <input id="{$TxtAdoszam.name}" name="{$TxtAdoszam.name}" type="text" value="{$TxtAdoszam.activ}" />
        {if isset($TxtAdoszam.error)}<p class="error small">{$TxtAdoszam.error}</p>{/if}
    </div>
    <div class="clear"></div>
</div>
    
<div class="field">
    <h2>Székhely adatok</h2>
    
    <div class="form_row">
        <label for="{$SelSzekhelyOrszag.name}">Ország <span class="require">*</span></label>
        {html_options name=$SelSzekhelyOrszag.name options=$SelSzekhelyOrszag.values selected=$SelSzekhelyOrszag.activ}
        {if isset($SelSzekhelyOrszag.error)}<p class="error small">{$SelSzekhelyOrszag.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$SelSzekhelyMegye.name}">Megye <span class="require">*</span></label>
        {html_options name=$SelSzekhelyMegye.name options=$SelSzekhelyMegye.values selected=$SelSzekhelyMegye.activ}
        {if isset($SelSzekhelyMegye.error)}<p class="error small">{$SelSzekhelyMegye.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$SelSzekhelyVaros.name}">Város <span class="require">*</span></label>
        {html_options name=$SelSzekhelyVaros.name options=$SelSzekhelyVaros.values selected=$SelSzekhelyVaros.activ}
        {if isset($SelSzekhelyVaros.error)}<p class="error small">{$SelSzekhelyVaros.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$SelSzekhelyIranyitoszam.name}">Irányítószám <span class="require">*</span></label>
        {html_options name=$SelSzekhelyIranyitoszam.name options=$SelSzekhelyIranyitoszam.values selected=$SelSzekhelyIranyitoszam.activ}
        {if isset($SelSzekhelyIranyitoszam.error)}<p class="error small">{$SelSzekhelyIranyitoszam.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$TxtSzekhelyUtca.name}">Utca <span class="require">*</span></label>
        <input id="{$TxtSzekhelyUtca.name}" name="{$TxtSzekhelyUtca.name}" type="text" value="{$TxtSzekhelyUtca.activ}" />
        {if isset($TxtSzekhelyUtca.error)}<p class="error small">{$TxtSzekhelyUtca.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$TxtSzekhelyHazszam.name}">Házszám <span class="require">*</span></label>
        <input id="{$TxtSzekhelyHazszam.name}" name="{$TxtSzekhelyHazszam.name}" type="text" value="{$TxtSzekhelyHazszam.activ}" />
        {if isset($TxtSzekhelyHazszam.error)}<p class="error small">{$TxtSzekhelyHazszam.error}</p>{/if}
    </div>
    <div class="clear"></div>
</div>
    
<div class="field">
    <h2>Kapcsolattartó adatok</h2>
    
    <div class="form_row">
        <label for="{$TxtVnev.name}">Vezetéknév <span class="require">*</span></label>
        <input id="{$TxtVnev.name}" name="{$TxtVnev.name}" type="text" value="{$TxtVnev.activ}" />
        {if isset($TxtVnev.error)}<p class="error small">{$TxtVnev.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$TxtKnev.name}">Keresztnév <span class="require">*</span></label>
        <input id="{$TxtKnev.name}" name="{$TxtKnev.name}" type="text" value="{$TxtKnev.activ}" />
        {if isset($TxtKnev.error)}<p class="error small">{$TxtKnev.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$TxtEmail.name}">E-mail cím <span class="require">*</span></label>
        <input id="{$TxtEmail.name}" name="{$TxtEmail.name}" type="text" value="{$TxtEmail.activ}" />
        {if isset($TxtEmail.error)}<p class="error small">{$TxtEmail.error}</p>{/if}
    </div>
    <div class="clear"></div>
    
    <div class="form_row">
        <label for="{$TxtKtoTel.name}">Telefonszám <span class="require">*</span></label>
        <input id="{$TxtKtoTel.name}" name="{$TxtKtoTel.name}" type="text" value="{$TxtKtoTel.activ}" />
        {if isset($TxtKtoTel.error)}<p class="error small">{$TxtKtoTel.error}</p>{/if}
    </div>
    <div class="clear"></div>
</div>