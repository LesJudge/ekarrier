<div class="form_row">
    <label for="{$TxtNev.name}">
        Megnevezés
        <span class="require">*</span>
    </label>
    <input id="{$TxtNev.name}" name="{$TxtNev.name}" type="text" value="{$TxtNev.activ}"/>
    {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if} 
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$SelMunkarend.name}">
        Munkarend
        <span class="require">*</span>
    </label>
    {html_options name=$SelMunkarend.name id=$SelMunkarend.name options=$SelMunkarend.values selected=$SelMunkarend.activ style="width: 100px !important;"} 
    {if isset($SelMunkarend.error)}<p class="error small">{$SelMunkarend.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$SelSzektor.name}">
        Szektor
        <span class="require">*</span>
    </label>
    {html_options name=$SelSzektor.name id=$SelSzektor.name options=$SelSzektor.values selected=$SelSzektor.activ style="width: 100px !important;"} 
    {if isset($SelSzektor.error)}<p class="error small">{$SelSzektor.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$SelPozicio.name}">
        Pozíció
        <span class="require">*</span>
    </label>    
	{html_options name=$SelPozicio.name id=$SelPozicio.name options=$SelPozicio.values selected=$SelPozicio.activ}    
	{if isset($SelPozicio.error)}<p class="error small">{$SelPozicio.error}</p>{/if}
	
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$TxtMunkavegzesJellege.name}">Munkavégzés jellege</label>
    <input id="{$TxtMunkavegzesJellege.name}" name="{$TxtMunkavegzesJellege.name}" type="text" value="{$TxtMunkavegzesJellege.activ}" />
    {if isset($TxtMunkavegzesJellege.error)}<p class="error small">{$TxtMunkavegzesJellege.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$TxtMunkaber.name}">Munkabér</label>
    <input id="{$TxtMunkaber.name}" name="{$TxtMunkaber.name}" type="text" value="{$TxtMunkaber.activ}" />
    {if isset($TxtMunkaber.error)}<p class="error small">{$TxtMunkaber.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$TxtProbaido.name}">Próbaidő</label>
    <input id="{$TxtProbaido.name}" name="{$TxtProbaido.name}" type="text" value="{$TxtProbaido.activ}" />
    {if isset($TxtProbaido.error)}<p class="error small">{$TxtProbaido.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$DateLejar.name}">
        Lejárati dátum
        <span class="require">*</span>
    </label>
    <input id="{$DateLejar.name}" name="{$DateLejar.name}" type="text" value="{$DateLejar.activ}" />
    {if isset($DateLejar.error)}<p class="error small">{$DateLejar.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$SelErtesites.name}">
        Értesítés
        <span class="require">*</span>
    </label>
    {html_options name=$SelErtesites.name id=$SelErtesites.name options=$SelErtesites.values selected=$SelErtesites.activ} 
    {if isset($SelErtesites.error)}<p class="error small">{$SelErtesites.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label>Publikus <span class="require">*</span></label>
    <div class="inputItem-group">
		{html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
	</div>
    {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
</div>
<div class="clear"></div>

<div class="form_row">
    <label for="{$TxtEgyeb.name}">Egyéb</label>
    <textarea id="{$TxtEgyeb.name}" name="{$TxtEgyeb.name}">{$TxtEgyeb.activ}</textarea>
    {if isset($TxtEgyeb.error)}<p class="error small">{$TxtEgyeb.error}</p>{/if}
</div>
<div class="clear"></div>