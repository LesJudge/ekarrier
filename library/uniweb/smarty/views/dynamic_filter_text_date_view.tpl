{extends file="library/uniweb/smarty/views/dynamic_filter_text_int_view.tpl"}
{block name="class"}uw-df-filter-text uw-df-filter-text-date{/block}
{block name="matchOptions"}
    {if $interval}
    <option value="{$opSqlBetween}">intervallum</option>
    {/if}
{/block}
{block name="matchOptionsActive"}
    {if $interval}
    <option value="{$opSqlBetween}" {if $item.activ['match'] eq $opSqlBetween} selected{/if}>intervallum</option>
    {/if}
{/block}
{block name="content"}
    {$smarty.block.parent}
    {if $interval or ($item.activ['match'] eq $opSqlBetween)}
    <input 
        name="{$item.name}[value_to]" 
        class="uw-df-filter-text-date-to" 
        type="text" 
        value="{$item.activ['value_to']}"
        {if $item.activ['match'] eq $opSqlBetween} style="display: block;"{/if} 
    />
    {/if}
    <div class="clear"></div>
    <label>
        <input name="{$item.name}[use_dp]" class="uw-df-filter-text-date-use-dp" type="checkbox" value="{$item.activ['use_dp']}"{if $item.activ['use_dp'] eq 1} checked="checked"{/if} />
        Használok datepickert!
    </label>
{/block}
