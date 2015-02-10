<script type="text/javascript">
$(function() {
    $('select[name="{$SelPagingLimit.name}"]').change(function() { $('#NumOnPage').click(); });
});
</script>
<div class="dataTables_wrapper">
    <div class="count">
    <label for="{$SelPagingLimit.name}">{php}echo LANG_AdminListPaging_tetel;{/php}</label>
        {html_options name=$SelPagingLimit.name options=$SelPagingLimit.values selected=$SelPagingLimit.activ}
    </div>
    <p style="display:none;"><input class="submit" id="NumOnPage" type="submit" name="{$BtnNumOnPage}" value="elem"></p>
    
    {if $Lapozas}
    <div class="dataTables_paginate paging_full_numbers">
        {if $Lapozas.prev_item}
        <a href="{$Lapozas.url}">
            <span class="first paginate_button">
                &lt;&lt;
            </span>
            </a>
            <a href="{$Lapozas.url}{if $Lapozas.prev_item neq 1}{$Lapozas.urlvar}={$Lapozas.prev_item}{/if}">
            <span class="previous paginate_button">
                {$Lapozas.prev_text}
            </span>
            </a>
        {else}
            <span class="first paginate_button paginate_button_disabled">
                &lt;&lt;
            </span>
            <span class="previous paginate_button paginate_button_disabled">
                {$Lapozas.prev_text}
            </span>
        {/if}
        {foreach from=$Lapozas.page key=id item=lap}
            {if $lap.activ}
                <span class="paginate_active paginate_button_disabled">
                    {$lap.value}
                </span>
            {else}
            <a href="{$Lapozas.url}{if $lap.value neq 1}{$Lapozas.urlvar}={$lap.value}{/if}">
                <span class="paginate_active">
                    {$lap.value}
                </span>
             </a>
            {/if}
        {/foreach}
        {if $Lapozas.next_item}
        <a href="{$Lapozas.url}{$Lapozas.urlvar}={$Lapozas.next_item}">
            <span class="next paginate_button">
                {$Lapozas.next_text}
            </span>
            </a>
            <a href="{$Lapozas.url}{$Lapozas.urlvar}={$Lapozas.last_page}">
            <span class="last paginate_button">
                &gt;&gt;
            </span>
            </a>
        {else}
            <span class="next paginate_button paginate_button_disabled">
                {$Lapozas.next_text}
            </span>
            <span class="last paginate_button paginate_button_disabled">
                &gt;&gt;
            </span>
        {/if}
        <span class="paginate_info"><strong>{php}echo LANG_AdminListPaging_oldal;{/php}: {$Lapozas.activ}</strong> / {$Lapozas.last_page}</span>
    {/if}
    </div>
</div>
<p style="display:none;">
    <input class="submit" id="BtnRendez" type="submit" name="{$BtnRendez}" value="Rendez">
    <input class="text" id="TxtSort" type="text" name="{$TxtSort.name}" value="{$TxtSort.activ}">
</p>
<div class="clear"></div>