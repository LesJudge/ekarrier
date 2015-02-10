{extends file="library/uniweb/smarty/views/dynamic_filter_base_view.tpl"}
{block name="class"}uw-df-filter-select{/block}
{block name="content"}
<label for="{$item.name}">{$item_label}</label>
{html_options name=$item.name options=$item.values selected=$item.activ}
{/block}