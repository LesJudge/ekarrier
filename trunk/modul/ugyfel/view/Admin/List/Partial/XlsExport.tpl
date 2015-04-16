<div id="clientExportDialog" title="Szűrési eredmény exportálás .xml fájlba">
    {foreach from=$xlsExportConfig key=xlsExportConfigKey item=xlsExportConfigItem}
    <div class="client-xls-export-dialog-item">
        <label>
            <input name="xlsexport[{$xlsExportConfigKey}]" type="checkbox" />
            {$xlsExportConfigItem.label}
        </label>
    </div>
    {/foreach}
</div>
<form id="clientExportForm" method="post" action="{$DOMAIN_ADMIN}ugyfel/xlsexport" style="display: none;"></form>