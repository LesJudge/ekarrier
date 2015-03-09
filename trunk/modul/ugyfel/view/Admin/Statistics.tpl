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
