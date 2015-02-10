{if $menu} 
    {section name=TopMenu loop=$menu}
        <li class="icon dashboard {if isset($menu[TopMenu].aktiv)}active{/if}"><a href="{$menu[TopMenu].menu_link}">{$menu[TopMenu].menu_nev}</a></li>
    {/section}
{/if}