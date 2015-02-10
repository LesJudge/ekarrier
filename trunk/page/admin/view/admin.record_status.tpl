<div class="grid_6"> 
    <div class="box_top">
        <h2 class="icon time">Információ</h2>
    </div>
    <div class="box_content padding">
        <div class="form_row">
            <strong>Módosítások száma:</strong> {$modositas_szama}
        </div>
        <div class="clear"></div>
        <div class="form_row">
            <strong>Létrehozva:</strong> {$letrehozas_timestamp}
        </div>
        <div class="clear"></div>
        <div class="form_row">
            <strong>Létrehozó:</strong>
            <a href="{$DOMAIN_ADMIN}user/edit/{$letrehozo_id}">
                {$letrehozo_nev}&nbsp;({$letrehozo_username})
            </a>
        </div>
        <div class="clear"></div>
        {if $modositas_szama gt 0}
        <div class="form_row">
            <strong>Utoljára módosítva:</strong> {$modositas_timestamp}
        </div>
        <div class="clear"></div>
        <div class="form_row">
            <strong>Módosító:</strong>
            <a href="{$DOMAIN_ADMIN}user/edit/{$modosito_id}">
                {$modosito_nev}&nbsp;({$modosito_username})
            </a>
        </div>
        <div class="clear"></div>
        {else}
        <div class="form_row">
            <strong>Utoljára módosítva:</strong> Nem lett módosítva!
        </div>
        <div class="clear"></div>
        <div class="form_row">
            <strong>Módosító:</strong> Még senki sem módosította!
        </div>
        <div class="clear"></div>            
        {/if}
        {if isset($active)}
        <div class="form_row">
            <strong>Pillanatnyi állapot:</strong>
            {if $active}
            <span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>
            {else}
            <span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong>'></span>
            {/if}
        </div>
        <div class="clear"></div>
        {/if}
    </div>
</div>