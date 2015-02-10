<thead>
    <tr>
        <th class="checkers"><input type="checkbox" class="check_all_input" title="{php}echo LANG_AdminListTableHeader_osszes;{/php}"></th>
            {foreach from=$Fejlec key=id item=elem}
                <th class="align_left center"  width="{$elem.width}%">
					{if $elem.sort eq 'ASC'} <a onclick="$('#TxtSort').val('{$id}__DESC');$('#BtnRendez').click();" title="{php}echo LANG_AdminListTableHeader_csokkeno;{/php}" class="sorted_header tip">{$elem.label}<span class="ui-icon ui-icon ui-icon-carat-1-n header_sort_icon"/></span></a>
                    {elseif  $elem.sort eq 'DESC'} <a onclick="$('#TxtSort').val('{$id}__ASC');$('#BtnRendez').click();" title="{php}echo LANG_AdminListTableHeader_novekvo;{/php}" class="sorted_header tip">{$elem.label}<span class="ui-icon ui-icon-carat-1-s header_sort_icon"/></span></a>
                    {else} <a class="tip" onclick="$('#TxtSort').val('{$id}__ASC');$('#BtnRendez').click();" title="{php}echo LANG_AdminListTableHeader_novekvo;{/php}">{$elem.label}<span class="ui-icon ui-icon-carat-2-n-s header_sort_icon"/></span></a>                        
                    {/if}                                                                    
                </th>                 
            {/foreach}
    </tr>
</thead>