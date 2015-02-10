<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}

});
/*]]>*/
</script>
<style type="text/css">
.select-cont {
    width: 260px;
}
</style>
<div class="content clearfix">
    <form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor regisztracio" enctype="multipart/form-data">
        {include file='page/all/view/page.message.tpl'}
        {if $FormError}
        <a href="{$DOMAIN}{$routes.telephely}">Vissza a telephelyekhez!</a>
        {else}
        <div class="form-row">
            <label for="{$SelOrszag.name}">Ország</label>
            {html_options id=$SelOrszag.name name=$SelOrszag.name options=$SelOrszag.values selected=$SelOrszag.activ}
            {if isset($SelOrszag.error)}<div class="ui-state-error">{$SelOrszag.error}</div>{/if}
        </div>
        <div class="clear"></div>
        <div class="form-row">
            <label for="{$SelMegye.name}">Megye</label>
            {html_options id=$SelMegye.name name=$SelMegye.name options=$SelMegye.values selected=$SelMegye.activ}
            {if isset($SelMegye.error)}<div class="ui-state-error">{$SelMegye.error}</div>{/if}
        </div>
        <div class="clear"></div>
        <div class="form-row">
            <label for="{$SelVaros.name}">Város</label>
            {html_options id=$SelVaros.name name=$SelVaros.name options=$SelVaros.values selected=$SelVaros.activ}
            {if isset($SelVaros.error)}<div class="ui-state-error">{$SelVaros.error}</div>{/if}
        </div>
        <div class="clear"></div>
        <div class="form-row">
            <label for="{$SelIranyitoszam.name}">Irányítószám</label>
            {html_options id=$SelIranyitoszam.name name=$SelIranyitoszam.name options=$SelIranyitoszam.values selected=$SelIranyitoszam.activ}
            {if isset($SelIranyitoszam.error)}<div class="ui-state-error">{$SelIranyitoszam.error}</div>{/if}
        </div>
        <div class="clear"></div>

        <div class="form-row">
            <label for="{$TxtUtca.name}">Utca, házszám&nbsp;<span class="require">*</span></label>
            <input id="{$TxtUtca.name}" name="{$TxtUtca.name}" type="text" value="{$TxtUtca.activ}" />
            {if isset($TxtUtca.error)}<div class="ui-state-error">{$TxtUtca.error}</div>{/if}
        </div>
        <div class="clear"></div>
        
        <div class="form-row">
            <label for="{$TxtHazszam.name}">Hazszam, házszám&nbsp;<span class="require">*</span></label>
            <input id="{$TxtHazszam.name}" name="{$TxtHazszam.name}" type="text" value="{$TxtHazszam.activ}" />
            {if isset($TxtHazszam.error)}<div class="ui-state-error">{$TxtHazszam.error}</div>{/if}
        </div>
        <div class="clear"></div>

        <div class="form-row">
            <label>Publikus&nbsp;<span class="require">*</span></label>
            <div class="inputItem-group">{html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}</div>
            {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
        </div>
        <div class="clear"></div>

        <div class="form-row">
            <label>&nbsp;</label>
            <button class="submit btn" name="{$BtnSave}" id="{$BtnSave}" value="submit" type="submit">Mentés</button>
        </div>
        {/if}
    </form>
</div>