<table class="sorting">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th class="align_left center"><a>Ügyfélkód</a></th>
            <th class="align_left center"><a>Vezetéknév</a></th>
            <th class="align_left center"><a>Keresztnév</a></th>
            <th class="align_left center"><a>E-mail cím</a></th>
            <th class="align_left center"><a>Születési idő</a></th>
            <th class="align_left center"><a>Születési hely</a></th>
            <th class="align_left center"><a>Felvétel ideje</a></th>
            <th class="align_left center">Törlés</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$clients key=for_id item=client}
        <tr class="data_row">
            <td class="checkers">&nbsp;</td>                    
            <td class="align_left">
                <a href="{$DOMAIN_ADMIN}ugyfel/{$client.ugyfel_id}/edit" title="Módosítás">{$client.ugyfel_id}</a>
            </td>
            <td class="align_left center">
                <a href="{$DOMAIN_ADMIN}ugyfel/{$client.ugyfel_id}/edit" title="Módosítás">{$client.vezeteknev}</a>
            </td>
            <td class="align_left center">
                <a href="{$DOMAIN_ADMIN}ugyfel/{$client.ugyfel_id}/edit" title="Módosítás">{$client.keresztnev}</a>
            </td>
            <td class="align_left center">
                {if $client.email}
                <a href="{$DOMAIN_ADMIN}ugyfel/{$client.ugyfel_id}/edit" title="Módosítás">{$client.email}</a>
                {else}<i>Nincs megadva!</i>{/if}
            </td>
            <td class="align_left center">
                {if $client.birthdate}{$client.birthdate}{else}<i>Nincs megadva!</i>{/if}
            </td>
            <td class="align_left center">
                {if $client.birthplace}{$client.birthplace}{else}<i>Nincs megadva!</i>{/if}
            </td>
            <td class="align_left center">{$client.letrehozas_timestamp}</td>
            <td class="align_left center">
                <button class="clientDeleteBtn" type="button" value="{$client.ugyfel_id}"></button>
            </td>
       </tr>                             
       {/foreach}
    </tbody>
</table>