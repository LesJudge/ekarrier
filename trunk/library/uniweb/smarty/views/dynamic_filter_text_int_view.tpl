{extends file="library/uniweb/smarty/views/dynamic_filter_base_view.tpl"}
{block name="class"}uw-df-filter-int{/block}
{block name="content"}
<label for="{$item.name}">{$item_label}</label>
{if is_array($item.activ)}
<input id="{$item.name}" name="{$item.name}[value]" class="filter-input" type="text" value="{$item.activ['value']}" />
<select class="uw-df-like-select" name="{$item.name}[match]">
    <option value="{$opIntEqual}"{if $item.activ['match'] eq $opIntEqual} selected{/if}>{$select_labels['opIntEqual']}</option>
    <option value="{$opIntLessThan}"{if $item.activ['match'] eq $opIntLessThan} selected{/if}>{$select_labels['opIntLessThan']}</option>
    <option value="{$opIntLessThanOrEqual}"{if $item.activ['match'] eq $opIntLessThanOrEqual} selected{/if}>{$select_labels['opIntLessThanOrEqual']}</option>
    <option value="{$opIntGreaterThan}"{if $item.activ['match'] eq $opIntGreaterThan} selected{/if}>{$select_labels['opIntGreaterThan']}</option>
    <option value="{$opIntGreaterThanOrEqual}"{if $item.activ['match'] eq $opIntGreaterThanOrEqual} selected{/if}>{$select_labels['opIntGreaterThanOrEqual']}</option>
    {block name=matchOptionsActive}{/block}
</select>
{else}
<input id="{$item.name}" name="{$item.name}[value]" class="filter-input" type="text" value="{$item.activ}" />
<select name="{$item.name}[match]">
    <option value="{$opIntEqual}">{$select_labels['opIntEqual']}</option>
    <option value="{$opIntLessThan}">{$select_labels['opIntLessThan']}</option>
    <option value="{$opIntLessThanOrEqual}">{$select_labels['opIntLessThanOrEqual']}</option>
    <option value="{$opIntGreaterThan}">{$select_labels['opIntGreaterThan']}</option>
    <option value="{$opIntGreaterThanOrEqual}">{$select_labels['opIntGreaterThanOrEqual']}</option>
    {block name="matchOptions"}{/block}
</select>
{/if}
{/block}