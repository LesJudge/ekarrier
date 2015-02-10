<div class="field">
        <div class="form_row">
                <label for="{$TxtNev.name}">Név <span class="require">*</span></label>
                <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
                {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if}
        </div><div class="clear"></div>

        <div class="form_row">
                <label for="{$TxtLink.name}">Link <span class="require">*</span></label>
                <input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}"/>
                <span class="ui-icon ui-icon-info tip" title="A link a böngésző címsorában szerepel (URL-ben). A linkben csak bizonyos karakterek megengedettek, ezért az ön által megadott szöveg  átalakításra kerül. A link a pontos azonosítás érdekében <strong>egyedi</strong>."></span>
                {if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if}
        </div><div class="clear"></div>

        <div class="form_row">
                <label for="{$TxtKulcsszo.name}">Kulcsszavak <span class="require">*</span></label>
                <input type="text" id="{$TxtKulcsszo.name}" name="{$TxtKulcsszo.name}" value="{$TxtKulcsszo.activ}"/>
                <span class="ui-icon ui-icon-info tip" title="Az adott oldal kulcsszavai. Rövid, vesszővel elválasztott egyszavas jelzők az oldal tartalmára nézve. (<em>pl. Bemutatkozó oldal esetében: bemutatkozás, céginformáció</em>)"></span>
                <div class="clear"></div>
                <span class="info">Vesszővel hagyhatja jóvá a kulcsszavat.</span> 
                {if isset($TxtKulcsszo.error)}<p class="error small">{$TxtKulcsszo.error}</p>{/if}
        </div><div class="clear"></div>

        <div class="form_row">
                <label for="{$TxtLeiras.name}">Leírás <span class="require">*</span></label>
                <textarea id="{$TxtLeiras.name}" name="{$TxtLeiras.name}">{$TxtLeiras.activ}</textarea>
                {if isset($TxtLeiras.error)}<p class="error small">{$TxtLeiras.error}</p>{/if} 
        </div><div class="clear"></div>
</div>

<div class="field">
        <div class="form_row">
                <label for="{$SelKategoria.name}">Kategória <span class="require">*</span></label>
                {html_options multiple name=$SelKategoria.name options=$SelKategoria.values selected=$SelKategoria.activ}  
                {if isset($SelKategoria.error)}<p class="error small">{$SelKategoria.error}</p>{/if}
        </div><div class="clear"></div>

        <div class="form_row">
                <label for="{$SelKapcsolodo.name}">Kapcsolódó munkakörök</label>
                {html_options multiple name=$SelKapcsolodo.name options=$SelKapcsolodo.values selected=$SelKapcsolodo.activ}
                {if isset($SelKapcsolodo.error)}<p class="error small">{$SelKapcsolodo.error}</p>{/if}
        </div><div class="clear"></div>

        <div class="form_row">
                <label>Publikus <span class="require">*</span></label>
                {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
        </div><div class="clear"></div>
</div>