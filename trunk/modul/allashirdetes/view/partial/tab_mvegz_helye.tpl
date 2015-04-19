<div class="field tabField">
    <!--
    *******

    Valaki legyen kedves, magyarázza el, hogy az a két div miért kapott companyRow id-t, mert érdekel!
    Ha easter egg-nek szánta valaki, akkor nem jött át, mert csak debuggolni kellett miatta...

    *******
    -->

    
    <!--<div id="companyRow" class="form_row">-->
    <div class="form_row">
        <label for="{$SelMegye.name}">Megye <span class="require">*</span></label>
        {html_options name=$SelMegye.name options=$SelMegye.values selected=$SelMegye.activ}  
        {if isset($SelMegye.error)}<p class="error small">{$SelMegye.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <!--<div id="companyRow" class="form_row">-->
    <div class="form_row">
        <label for="{$SelVaros.name}">Város <span class="require">*</span></label>
        {html_options name=$SelVaros.name options=$SelVaros.values selected=$SelVaros.activ}  
        {if isset($SelVaros.error)}<p class="error small">{$SelVaros.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$TxtUtca.name}">Utca</label>
        <input id="{$TxtUtca.name}" name="{$TxtUtca.name}" type="text" value="{$TxtUtca.activ}" />
        {if isset($TxtUtca.error)}<p class="error small">{$TxtUtca.error}</p>{/if}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label for="{$TxtHazszam.name}">Házszám</label>
        <input id="{$TxtHazszam.name}" name="{$TxtHazszam.name}" type="text" value="{$TxtHazszam.activ}" />
        {if isset($TxtHazszam.error)}<p class="error small">{$TxtHazszam.error}</p>{/if}
    </div>
    <div class="clear"></div>
</div>