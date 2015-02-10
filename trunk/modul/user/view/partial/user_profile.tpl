{if not empty($userMenu)}
<div id="user-profile">
    <p id="user-profile-heading">Menü</p>
    <ul>
        {foreach from=$userMenu item=um}
        <li>
            <a href="{$DOMAIN}{$um.menu_link}">{$um.menu_nev}</a>
        </li>
        {/foreach}
        <li style="padding-top: 14px;">
            <a href="{$DOMAIN}kijelentkezes">Kijelentkezés</a>
        </li>
    </ul>
</div>
{/if}
<style type="text/css">
#user-profile {
    background: #fff;
    border: 1px solid #D8D8D8;
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
    min-height: 200px;
    padding: 10px;
    position: fixed;
    right: 0;
    top: 15%;
    width: 200px;
    z-index: 11;
}
#user-profile #user-profile-heading {
    background: #ff6004;
    border-top-left-radius: 15px;
    color: #fff;
    margin: -10px;
    margin-bottom: 10px;
    padding: 8px;
    text-align: center;
}
</style>