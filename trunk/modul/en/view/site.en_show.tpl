<style>
.fromTest{

float:left;
}
.IMG{
background-image: url('images/site/tests-icon.png');
background-size: contain;
width: 30px;
height: 30px;
float:left;
}

</style>
{foreach from=$myComps key=key item=val}
    <div style="color:{$val.kompetencia_szinkod}};" class='{if $val['user_attr_kompetencia_tesztbol']=="1"}fromTest{/if}'>{$val.kompetencia_nev} ({$val.user_attr_kompetencia_valasz})</div>
    {if $val['user_attr_kompetencia_tesztbol']=="1"}<div class='IMG'></div>{/if}
    <div class="clear"></div>
{/foreach}
<a href="{$DOMAIN}kompetenciak/kompetenciarajz/">Tovább a kompetenciarajzra</a>

<br />
<br />
Munkaköreim
<br />
{foreach from=$myMunkakorok key=key item=val}
    <a href="{$DOMAIN}munkakorok/{$val.munkakor_link}">{$val.munkakor_nev}</a>
    <div class="clear"></div>
{/foreach}

<br />
<br />
Megjelölt álláshirdetések
<br />
{foreach from=$myMegjeloltek key=key item=val}
    <a href="{$DOMAIN}allashirdetes/{$val.link}/{$val.id}/">{$val.nev}</a>
    <div class="clear"></div>
{/foreach}