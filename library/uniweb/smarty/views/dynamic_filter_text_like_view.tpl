{extends file="library/uniweb/smarty/views/dynamic_filter_base_view.tpl"}
{block name="class"}uw-df-filter-text uw-df-filter-text-like{/block}
{block name="content"}
<label for="{$item.name}">{$item_label}</label>
{if is_array($item.activ)}
<input id="{$item.name}" name="{$item.name}[value]" class="filter-input" type="text" value="{$item.activ['value']}" />
<select class="uw-df-like-select" name="{$item.name}[match]">
    <option value="{$opLikeAnywhere}"{if $item.activ['match'] eq $opLikeAnywhere} selected{/if}>bárhol</option>
    <option value="{$opLikePre}"{if $item.activ['match'] eq $opLikePre} selected{/if}>elején</option>
    <option value="{$opLikeEqual}"{if $item.activ['match'] eq $opLikeEqual} selected{/if}>teljes egyezés</option>
    <option value="{$opLikePost}"{if $item.activ['match'] eq $opLikePost} selected{/if}>végén</option>
</select>
{else}
<input id="{$item.name}" name="{$item.name}[value]" class="filter-input" type="text" value="{$item.activ}" />
<select name="{$item.name}[match]">
    <option value="{$opLikeAnywhere}">bárhol</option>
    <option value="{$opLikePre}">elején</option>
    <option value="{$opLikeEqual}">teljes egyezés</option>
    <option value="{$opLikePost}">végén</option>
</select>
{/if}
{/block}