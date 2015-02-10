<div class="field">
        <div class="form_row">
                <label>
                        Pályakezdő
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="lmPalyakezdo0" name="laborMarket[palyakezdo]" type="radio" value="0"{if $laborMarket->palyakezdo eq 0} checked="checked"{/if} /><!--/#lmPalyakezdo0-->
                        Nem
                </label>
                <label>
                        <input id="lmPalyakezdo1" name="laborMarket[palyakezdo]" type="radio" value="1"{if $laborMarket->palyakezdo eq 1} checked="checked"{/if} /><!--/#lmPalyakezdo1-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label>
                        Regisztrált munkanélküli
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="lmRegMunkanelkuli0" name="laborMarket[regisztralt_munkanelkuli]" type="radio" value="0"{if $laborMarket->regisztralt_munkanelkuli eq 0} checked="checked"{/if} /><!--/#lmRegMunkanelkuli0-->
                        Nem
                </label>
                <label>
                        <input id="lmRegMunkanelkuli1" name="laborMarket[regisztralt_munkanelkuli]" type="radio" value="1"{if $laborMarket->regisztralt_munkanelkuli eq 1} checked="checked"{/if} /><!--/#lmRegMunkanelkuli1-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="lmMikorRegisztralt">
                        Mikor regisztrált
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="lmMikorRegisztralt" name="laborMarket[mikor_regisztralt]" type="text" value="{$laborMarket->mikor_regisztralt}" /><!--/#lmMikorRegisztralt-->
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label>
                        GYES-ről, GYED-ről visszatérő?
                        <span class="require"></span><!--/.require-->
                </label>
                <label>
                        <input id="lmGYESGYEDVisszatero0" name="laborMarket[gyes_gyed_visszatero]" type="radio" value="0"{if $laborMarket->gyes_gyed_visszatero eq 0} checked="checked"{/if} /><!--/#lmGYESGYEDVisszater0-->
                        Nem
                </label>
                <label>
                        <input id="lmGYESGYEDVisszatero1" name="laborMarket[gyes_gyed_visszatero]" type="radio" value="1"{if $laborMarket->gyes_gyed_visszatero eq 1} checked="checked"{/if} /><!--/#lmGYESGYEDVisszatero1-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="lmGYESLejarMikor">
                        Mikor jár le a GYES, GYED ?
                </label>
                <input id="lmGYESLejarMikor" name="laborMarket[gyes_gyed_lejar_datum]" type="text" value="{$laborMarket->gyes_gyed_lejar_datum}" /><!--/#lmGYESLejarMikor-->
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label>
                        Megváltozott munkaképességű-e ?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="lmMegvMunkakepessegu0" name="laborMarket[megvaltozott_mkepessegu]" type="radio" value="0"{if $laborMarket->megvaltozott_mkepessegu eq 0} checked="checked"{/if} /><!--/#lmMegvMunkakepessegu0-->
                        Nem
                </label>
                <label>
                        <input id="lmMegvMunkakepessegu1" name="laborMarket[megvaltozott_mkepessegu]" type="radio" value="1"{if $laborMarket->megvaltozott_mkepessegu eq 1} checked="checked"{/if} /><!--/#lmMegvMunkakepessegu1-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="lmKovFelulvIdeje">
                        Következő felülvizsgálat ideje
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="lmKovFelulvIdeje" name="laborMarket[kov_felulv_date]" type="text" value="{$laborMarket->kov_felulv_date}" /><!--/#lmKovFelulvIdeje-->
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="lmMunkvKorlOkok">Munkavégzést korlátozó egyéb okok (pl. bármilyen betegség, ápolási díjban részesül)</label>
                <textarea id="lmMunkvKorlOkok" name="laborMarket[mvegzes_keok]" cols="50" rows="5">{$laborMarket->mvegzes_keok}</textarea><!--/#lmMunkvKorlOkok-->
        </div><!--/.form-row-->
        <div class="clear"></div>
        <div class="form_row">
                <label>
                        Dolgozik
                        <span class="require">*</span>
                </label>
                <label>
                        <input id="lmDolgozik0" name="laborMarket[dolgozik]" type="radio" value="0"{if $laborMarket->dolgozik eq 0} checked="checked"{/if} /><!--/#lmDolgozik0-->
                        Nem
                </label>
                <label>
                        <input id="lmDolgozik1" name="laborMarket[dolgozik]" type="radio" value="1"{if $laborMarket->dolgozik eq 1} checked="checked"{/if} /><!--/#lmDolgozik1-->
                        Igen
                </label>
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