<script type="text/html" id="{$filterTemplateId}" data-filter-key="{$filterKey}" data-script-type="filter">
<div class="dynamic-filter-filter dynamic-filter-text" data-role="filter" data-filter-key="{$filterKey}">
    <label>{$filterLabel}</label>
    <input name="filter[{$filterKey}][text]" type="text" />
    <select name="filter[{$filterKey}][match]">
        <option value="anywhere">bárhol</option>
        <option value="startsWith">elején</option>
        <option value="endsWith">végén</option>
        <option value="equals">teljes egyezés</option>
    </select>
</div>
</script>