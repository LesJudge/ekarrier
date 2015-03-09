<script type="text/html" id="{$filterTemplateId}" data-filter-key="{$filterKey}" data-script-type="filter">
<div class="dynamic-filter-filter dynamic-filter-text" data-role="filter" data-filter-key="{$filterKey}">
    <label>{$filterLabel}</label>
    <input name="filter[{$filterKey}][date]" type="text" />
    <input name="filter[{$filterKey}][date2]" type="text" disabled="disabled" style="display: none;" />
    <select name="filter[{$filterKey}][match]">
        <option value="lessThan">korábban, mint</option>
        <option value="lessThanOrEqual">korábban, vagy ekkor</option>
        <option value="equals">pontosan ekkor</option>
        <option value="greaterThanOrEquals">később, mint vagy ekkor</option>
        <option value="greaterThan">később, mint</option>
        <option value="between">intervallum</option>
    </select>
</div>
</script>