<div id="client-export-dialog" title="Ügyfél export">
    <div id="client-export-dialog-error" class="notice error" style="display: none;">
        <p>Nem választott mezőt!</p>
    </div>
    {foreach from=$exportAttributes key=key item=exportAttribute}
    <div>
        <label>
            <input name="{$exportNameXls}[{$key}]" type="checkbox" />
            {$exportAttribute.label}
        </label>
    </div>
    {foreachelse}
    <div>Nincs megjeleníthető attribútum!</div>
    {/foreach}
</div>