<thead>
    <tr>
        <th class="checkers"><input type="checkbox" class="check_all_input" title="{php}echo LANG_AdminListTableHeader_osszes;{/php}"></th>
            {foreach from=$Fejlec key=id item=elem}
                <th class="align_left center"  width="{$elem.width}%">
                    {$elem.label}                                                            
                </th>                 
            {/foreach}
    </tr>
</thead>

