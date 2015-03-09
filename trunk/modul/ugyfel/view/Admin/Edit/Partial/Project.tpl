<div class="uw-ugyfelkezelo-form">
    {if count($client->projects) gt 0}
    <table id="client-projects-table">
        <thead><tr><th>Projekt neve</th><th>Megjegyzés</th></tr></thead>
        <tbody>
            {foreach from=$client->projects key=key item=cp}
            <tr>
                {assign var="project" value=$cp->project}
                <td><a href="{$DOMAIN_ADMIN}projekt/edit/{$project->projekt_id}" target="_blank">{$project->nev}</a></td>
                <td>
                    <input name="relationships[projects][{$cp->ugyfel_attr_projekt_id}][ugyfel_attr_projekt_id]" type="hidden" value="{$cp->ugyfel_attr_projekt_id}" />
                    <input name="relationships[projects][{$cp->ugyfel_attr_projekt_id}][megjegyzes]" type="text" value="{$cp->megjegyzes}" />
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
    {else}
    <div class="notice info"><p>Az ügyfél nem tartozik egyetlen projekthez sem!</p></div>
    {/if}
</div>