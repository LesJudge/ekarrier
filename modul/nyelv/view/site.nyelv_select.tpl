{foreach from=$nyelvek key=nyelv_select_id item=nyelv}
   <a href="{$nyelv.nyelv_link}" title="{$nyelv.nyelv_nev}" class="{if isset($nyelv.aktiv)}active{/if}">
   <img src="{$DOMAIN}pic/{$APP_PATH}/{$nyelv.nyelv_zaszlo_nev}_15x10" alt="{$nyelv.nyelv_nev}"/></a>
{/foreach}