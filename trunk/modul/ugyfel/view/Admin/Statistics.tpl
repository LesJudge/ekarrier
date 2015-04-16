<div style="font-size: 18px; margin-bottom: 20px; margin-top: 10px;">
    <strong>Ügyfelek száma: {$countClients}</strong>
</div>
<table>
    <thead>
        <tr>
            <th colspan="2">Program információk</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$programInformations item=programInformation}
        <tr>
            <td>{$programInformation.nev}</td>
            <td>{$programInformation.cnt}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
    
<br />

<table>
    <thead>
        <tr>
            <th colspan="2">Munkarendek</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$workschedules item=workschedule}
        <tr>
            <td>{$workschedule.nev}</td>
            <td>{$workschedule.cnt}</td>
        </tr>
        {/foreach}
    </tbody>
</table>

<br />

<table>
    <thead>
        <tr>
            <th colspan="2">Végzettségek</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$educations item=education}
        <tr>
            <td>{$education.nev}</td>
            <td>{$education.cnt}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
