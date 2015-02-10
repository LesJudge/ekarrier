<div class="uw-ugyfelkezelo-form">
    <table id="client-projects-table">
        <thead>
            <tr>
                <th>Projekt neve</th>
                <th>Megjegyzés</th>
            </tr>
        </thead>
        <tbody>
            {if count($client->projects) gt 0}
            {foreach from=$client->projects key=key item=cp}
            <tr>
                {assign var="project" value=$cp->project}
                <td>
                    <a href="{$DOMAIN_ADMIN}projekt/edit/{$project->projekt_id}" target="_blank">{$project->nev}</a>
                </td>
                <td>
                    <input name="models[client_project][{$key}][projekt_id]" type="hidden" value="{$project->projekt_id}" />
                    <input name="models[client_project][{$key}][megjegyzes]" type="text" value="{$cp->megjegyzes}" />
                </td>
            </tr>
            {/foreach}
            {else}
            <tr>
                <td colspan="2">Az ügyfél nem tartozik egyetlen projekthez sem!</td>
            </tr>
            {/if}
        </tbody>
    </table>
</div>
<style type="text/css">
#client-projects-table tr td {
    width: 50%;
}
#client-projects-table tr td input[type="text"] {
    width: 96%;
}
</style>