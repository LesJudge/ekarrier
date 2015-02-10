<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        
        $('select[name="{$FilterUser.name}"]').change(function() { $('#{$BtnFilter}').click(); });

});
/*]]>*/
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
        <div class="box_top">
                <h2 class="icon pages">Kapcsolatfelvétel</h2>
                <ul class="sorting">
                        {include file='page/admin/view/admin.list_events.tpl'} 
                </ul>
        </div>
        <div class="box_content">    
                {include file='page/admin/view/admin.message.tpl'}
                {include file='page/admin/view/admin.list_filter.tpl'}
                <div class="top_filtering" >
                        {html_options name=$FilterUser.name options=$FilterUser.values selected=$FilterUser.activ}
                        <div class="clear"></div>
                </div>
                <table class="sorting">
                        {include file='page/admin/view/admin.list_table_header.tpl'}  
                        {foreach from=$Lista key=for_id item=lista}
                        <tr class="data_row">
                                <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"></th>
                                <td class="align_left"><a href="{$APP_LINK}/edit/{$lista.ID}" title="Módosítás">{$lista.user_vnev} {$lista.user_knev}</a></td>
                                <td class="align_left center">{$lista.felvetel_ideje}</td>
                                <td class="align_left">{$lista.megjegyzes}</td>
                                <td class="align_left center">{$lista.letrehozas_timestamp}</td>
                                <td class="align_left center">
                                        {if $lista.modositas_szama gt 0}
                                        {$lista.modositas_timestamp}
                                        {else}
                                        Nem lett módosítva!
                                        {/if}
                                </td>
                        </tr>                             
                        {/foreach}
                </table>
                {include file='page/admin/view/admin.paging.tpl'} 
        </div>
</form>