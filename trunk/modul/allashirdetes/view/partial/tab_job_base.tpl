<div class="field tabField">
    <div class="form_row">
        <label for="{$TxtNev.name}">Munkakör megnevezés <span class="require">*</span></label>
        <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
        {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$TxtLink.name}">Link <span class="require">*</span></label>
        <input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}"/>
        <span class="ui-icon ui-icon-info tip" title="A link a böngésző címsorában szerepel (URL-ben). A linkben csak bizonyos karakterek megengedettek, ezért az ön által megadott szöveg  átalakításra kerül. A link a pontos azonosítás érdekében <strong>egyedi</strong>."></span>
        {if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if}
    </div>
    <div class="clear"></div>
</div>
<div class="field">
    <div class="form_row">
        <label>Egyedi álláshirdetés ? <span class="require">*</span></label>
        {html_radios name=$ChkEgyedi.name options=$ChkEgyedi.values selected=$ChkEgyedi.activ}
        {if isset($ChkEgyedi.error)}<p class="error small">{$ChkEgyedi.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div id="companyRow" class="form_row">
        <label for="{$SelCeg.name}">Cég <span class="require">*</span></label>
        {html_options name=$SelCeg.name options=$SelCeg.values selected=$SelCeg.activ}  
        {if isset($SelCeg.error)}<p class="error small">{$SelCeg.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div id="advertiserRow" class="form_row">
        <label for="{$TxtHirdeto.name}">Hirdető <span class="require">*</span></label>
        <input id="{$TxtHirdeto.name}" name="{$TxtHirdeto.name}" type="text" value="{$TxtHirdeto.activ}" />
        {if isset($TxtHirdeto.error)}<p class="error small">{$TxtHirdeto.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label>Más hirdetése <span class="require">*</span></label>
        {html_radios name=$ChkMasHirdetese.name options=$ChkMasHirdetese.values selected=$ChkMasHirdetese.activ}
        {if isset($ChkMasHirdetese.error)}<p class="error small">{$ChkMasHirdetese.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div id="notOurLinkRow" class="form_row">
        <label for="{$TxtMasHirdeteseLink.name}">Más hirdetése (link) <span class="require">*</span></label>
        <input id="{$TxtMasHirdeteseLink.name}" name="{$TxtMasHirdeteseLink.name}" type="text" value="{$TxtMasHirdeteseLink.activ}" />
        {if isset($TxtMasHirdeteseLink.error)}<p class="error small">{$TxtMasHirdeteseLink.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$SelMunkarend.name}">Munkarend <span class="require">*</span></label>
        {html_options name=$SelMunkarend.name options=$SelMunkarend.values selected=$SelMunkarend.activ}  
        {if isset($SelMunkarend.error)}<p class="error small">{$SelMunkarend.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$SelSzektor.name}">Szektor <span class="require">*</span></label>
        {html_options name=$SelSzektor.name options=$SelSzektor.values selected=$SelSzektor.activ}  
        {if isset($SelSzektor.error)}<p class="error small">{$SelSzektor.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$SelPozicio.name}">Pozíció <span class="require">*</span></label>
        {html_options name=$SelPozicio.name options=$SelPozicio.values selected=$SelPozicio.activ}  
        {if isset($SelPozicio.error)}<p class="error small">{$SelPozicio.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form-row">
        <label>Ellenőrzött álláshirdetés <span class="require">*</span></label>
        {html_radios name=$ChkEllenorzott.name options=$ChkEllenorzott.values selected=$ChkEllenorzott.activ}
        {if isset($ChkEllenorzott.error)}<p class="error small">{$ChkEllenorzott.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$DateLejar.name}">Lejárati dátum <span class="require">*</span></label>
        <input id="{$DateLejar.name}" name="{$DateLejar.name}" type="text" value="{$DateLejar.activ}" />
        {if isset($DateLejar.error)}<p class="error small">{$DateLejar.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$SelErtesites.name}">Értesítés <span class="require">*</span></label>
        {html_options name=$SelErtesites.name options=$SelErtesites.values selected=$SelErtesites.activ}  
        {if isset($SelErtesites.error)}<p class="error small">{$SelErtesites.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label>Publikus <span class="require">*</span></label>
        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
    </div>
    <div class="clear"></div>
</div>