<div class="field">
    <div class="form_row">
        <label>Pályakezdő</label>
        <label>
            <input 
                id="lmPalyakezdo0" 
                name="laborMarket[palyakezdo]" 
                type="radio" 
                value="0"
                {if $laborMarket->palyakezdo === 0} checked="checked"{/if} 
            /><!--/#lmPalyakezdo0-->
            Nem
        </label>
        <label>
            <input 
                id="lmPalyakezdo1" 
                name="laborMarket[palyakezdo]" 
                type="radio" 
                value="1"
                {if $laborMarket->palyakezdo === 1} checked="checked"{/if} 
            /><!--/#lmPalyakezdo1-->
            Igen
        </label>
            
        {ar_error model=$laborMarket property='palyakezdo' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label>Regisztrált munkanélküli</label>
        <label>
            <input 
                id="lmRegMunkanelkuli0" 
                name="laborMarket[regisztralt_munkanelkuli]" 
                type="radio" 
                value="0"
                {if $laborMarket->regisztralt_munkanelkuli === 0} checked="checked"{/if} 
            /><!--/#lmRegMunkanelkuli0-->
            Nem
        </label>
        <label>
            <input 
                id="lmRegMunkanelkuli1" 
                name="laborMarket[regisztralt_munkanelkuli]" 
                type="radio" 
                value="1"
                {if $laborMarket->regisztralt_munkanelkuli === 1} checked="checked"{/if} 
             /><!--/#lmRegMunkanelkuli1-->
            Igen
        </label>
        {ar_error model=$laborMarket property='regisztralt_munkanelkuli' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label for="lmMikorRegisztralt">Mikor regisztrált</label>
        <input id="lmMikorRegisztralt" name="laborMarket[mikor_regisztralt]" type="text" value="{$laborMarket->mikor_regisztralt}" /><!--/#lmMikorRegisztralt-->
        {ar_error model=$laborMarket property='mikor_regisztralt' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label>GYES-ről, GYED-ről visszatérő ?</label>
        <label>
            <input 
                id="lmGYESGYEDVisszatero0" 
                name="laborMarket[gyes_gyed_visszatero]" 
                type="radio" value="0"
                {if $laborMarket->gyes_gyed_visszatero === 0} checked="checked"{/if} 
            /><!--/#lmGYESGYEDVisszater0-->
            Nem
        </label>
        <label>
            <input 
                id="lmGYESGYEDVisszatero1" 
                name="laborMarket[gyes_gyed_visszatero]" 
                type="radio" value="1"
                {if $laborMarket->gyes_gyed_visszatero === 1} checked="checked"{/if} 
            /><!--/#lmGYESGYEDVisszatero1-->
            Igen
        </label>
        {ar_error model=$laborMarket property='gyes_gyed_visszatero' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label for="lmGYESLejarMikor">Mikor jár le a GYES, GYED ?</label>
        <input id="lmGYESLejarMikor" name="laborMarket[gyes_gyed_lejar_datum]" type="text" value="{$laborMarket->gyes_gyed_lejar_datum}" /><!--/#lmGYESLejarMikor-->
        {ar_error model=$laborMarket property='gyes_gyed_lejar_datum' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label>Megváltozott munkaképességű-e ?</label>
        <label>
            <input 
                id="lmMegvMunkakepessegu0" 
                name="laborMarket[megvaltozott_mkepessegu]" 
                type="radio" 
                value="0"
                {if $laborMarket->megvaltozott_mkepessegu === 0} checked="checked"{/if} 
            /><!--/#lmMegvMunkakepessegu0-->
            Nem
        </label>
        <label>
            <input 
                id="lmMegvMunkakepessegu1" 
                name="laborMarket[megvaltozott_mkepessegu]" 
                type="radio" 
                value="1"
                {if $laborMarket->megvaltozott_mkepessegu === 1} checked="checked"{/if} 
            /><!--/#lmMegvMunkakepessegu1-->
            Igen
        </label>
        {ar_error model=$laborMarket property='megvaltozott_mkepessegu' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label for="lmKovFelulvIdeje">Következő felülvizsgálat ideje</label>
        <input id="lmKovFelulvIdeje" name="laborMarket[kov_felulv_date]" type="text" value="{$laborMarket->kov_felulv_date}" /><!--/#lmKovFelulvIdeje-->
        {ar_error model=$laborMarket property='kov_felulv_date' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label for="lmMunkvKorlOkok">Munkavégzést korlátozó egyéb okok (pl. bármilyen betegség, ápolási díjban részesül)</label>
        <textarea id="lmMunkvKorlOkok" name="laborMarket[mvegzes_keok]" cols="50" rows="5">{$laborMarket->mvegzes_keok}</textarea><!--/#lmMunkvKorlOkok-->
        {ar_error model=$laborMarket property='mvegzes_keok' view='admin_ar_error.tpl'}
    </div><!--/.form-row-->
    <div class="clear"></div>
    <div class="form_row">
        <label>Dolgozik</label>
        <label>
            <input 
                id="lmDolgozik0" 
                name="laborMarket[dolgozik]" 
                type="radio" 
                value="0"
                {if $laborMarket->dolgozik === 0} checked="checked"{/if} 
            /><!--/#lmDolgozik0-->
            Nem
        </label>
        <label>
            <input 
                id="lmDolgozik1" 
                name="laborMarket[dolgozik]" 
                type="radio" 
                value="1"
                {if $laborMarket->dolgozik === 1} checked="checked"{/if} 
            /><!--/#lmDolgozik1-->
            Igen
        </label>
        {ar_error model=$laborMarket property='dolgozik' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
</div><!--/.field-->
<style type="text/css">
.ui-datepicker-trigger {
    left: 5px;
    position: relative;
    top: 8px;
}
</style>
<script type="text/javascript">
/*<![CDATA[*/
$(function(){

    $("#lmMikorRegisztralt, #lmGYESLejarMikor, #lmKovFelulvIdeje").datepicker();

});
/*]]>*/
</script>