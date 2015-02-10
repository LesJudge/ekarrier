{extends file="library/uniweb/smarty/views/dynamic_filter_base_view.tpl"}
{block name="class"}uw-df-filter-text{/block}
{block name="content"}
<label for="{$item.name}">{$item_label}</label>
<input id="{$item.name}" name="{$item.name}" class="filter-input" type="text" value="{$item.activ}" />
{/block}