<style type="text/css">
.uw-ui-state-settings-state
{
        padding:5px 10px !important;
}
</style>

<div class="box_top">
        <h2 class="icon pages">Beállítások</h2>
</div>

<div class="box_content padding">
        {if $features}
                <p class="ui-state-default uw-ui-state-settings-state">Az alábbi műveletek közül választhat!</p>
                <ul>
                {foreach from=$features item=feature}
                        <li><a href="{$DOMAIN_ADMIN}{$APP_PATH}/{$feature.modul_function_azon}">{$feature.modul_function_nev}</a></li>
                {/foreach}
                </ul>
        {else}
                <p class="ui-state-error uw-ui-state-settings-state" style="margin:0 auto;text-align:center;width:50%;"><strong>Nincs megjeleníthető feature!</strong></p>
        {/if}
</div>