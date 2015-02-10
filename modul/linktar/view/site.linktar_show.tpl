<div class="content">
{if $links}
{foreach from=$links item=link}
    <a href="{$link.linktar_link}" target="_blank">{$link.linktar_cim}</a>
    <br />
{/foreach}
{else}
    Nincs egyetlen link sem az adatbázisban!
{/if}
</div>