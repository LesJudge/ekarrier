<div>
    <form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
        {include file='page/all/view/page.message.tpl'}
        <table>
            <thead>
                <th>Iskola</th>
                <th>Végzettség</th>
                <th>Tól</th>
                <th>Ig</th>
                <th>Szak</th>
                <th>Publikus</th>
                <th>Szerkesztés</th>
            </thead>
            
            <tbody>
                {if $Lista}
                {foreach from=$Lista key=for_id item=education}
                <tr>
                    <td>{$education.iskola}</td>
                    <td>{$education.vegzettseg_nev}</td>
                    <td>{$education.kezdet}</td>
                    <td>{$education.veg}</td>
                    <td>{$education.szak}</td>
                    <td>{if $education.aktiv eq 1}Igen{else}Nem{/if}</td>
                    <td><a href="{$DOMAIN}{$routes.vegzettsegedit}{$education.pk}">Szerkesztés</a></td>
                </tr>
                {/foreach}
                {/if}
            </tbody>
            
            <tfoot>
                <tr>
                    <td>{include file='page/all/view/page.paging.tpl'}</td>
                </tr>
            </tfoot>
        </table>
                
        <div>
            <ul class="uw-nav-list uw-nav-list-block">
                <li>
                    <a title="Vissza az Én oldalra!" href="{$DOMAIN}{$routes.en}">Vissza a profilomra!</a>
                </li>
            </ul>
        </div>
    </form>
</div>