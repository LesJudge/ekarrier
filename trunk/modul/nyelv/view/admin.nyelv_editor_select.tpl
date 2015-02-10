<div class="lang-selector">
    <div class="szerkeszto">
    {foreach from=$NyelvSelect key=nyelv_select_id item=nyelv}
	   <a href="{$nyelv.nyelv_link}" title="{$nyelv.nyelv_nev}" class="{if isset($nyelv.aktiv)}active{/if}">
	   <img src="{$DOMAIN}pic/nyelv/{$nyelv.nyelv_zaszlo_nev}_15x10" /></a>
	{/foreach}
    </div>
</div>