{extends file="library/uniweb/smarty/views/dynamic_filter_base_view.tpl"}
{block name="class"}uw-df-filter-radio{/block}
{block name="content"}
<label for="{$item.name}">{$item_label}</label>
{html_radios name=$item.name options=$item.values selected=$item.activ}
{/block}