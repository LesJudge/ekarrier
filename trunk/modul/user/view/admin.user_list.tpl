<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    $('select[name="{$FilterStatus.name}"]').change(function() { $('#{$BtnFilter}').click(); });
});
/*]]>*/
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    <div class="box_top">
        <h2 class="icon pages">Felhasználók</h2>
        <!-- Ezt itt ASAP javítani kell, mert retek ronda és invalid! -->
        <ul class="sorting">
            <div class="form_muvelet">
                <a  href="{$DOMAIN_ADMIN}{$APP_LINK}/edit{$LANG_PARAM}">
                    <span class="ui-button-text">
                        <img class="tip" title="{php}echo LANG_AdminList_uj;{/php}" src="../images/admin/icons/add_data.png">
                    </span>
                </a>
                <button class="submit tip" id="{$BtnMultiplePublish}" name="{$BtnMultiplePublish}" value="{php}echo LANG_AdminList_publikal;{/php}" title="{php}echo LANG_AdminList_publikal;{/php}" onclick="return confirmBox('{$BtnMultiplePublish}', '{php}echo LANG_AdminList_publikal;{/php}', '{php}echo LANG_AdminList_publikal_content;{/php}');" ><img src="../images/admin/icons/table_accept.png"></button>
                <button class="submit tip" id="{$BtnMultipleUnpublish}" name="{$BtnMultipleUnpublish}" value="{php}echo LANG_AdminList_visszavon;{/php}" title="{php}echo LANG_AdminList_visszavon;{/php}" onclick="return confirmBox('{$BtnMultipleUnpublish}', '{php}echo LANG_AdminList_visszavon;{/php}', '{php}echo LANG_AdminList_visszavon_content;{/php}');"><img src="../images/admin/icons/table_remove.png"></button>
                <button class="submit tip" id="{$BtnMultipleDelete}" name="{$BtnMultipleDelete}" value="{php}echo LANG_AdminList_torol;{/php}" title="{php}echo LANG_AdminList_torol;{/php}" onclick="return confirmBox('{$BtnMultipleDelete}', '{php}echo LANG_AdminList_torol;{/php}', '{php}echo LANG_AdminList_torol_content;{/php}');"><img src="../images/admin/icons/trash_can.png"></button>
                {block name="EventBtns"}{/block}
            </div>
        </ul>
    </div>
    <div class="box_content">
        <div style="padding: 10px 20px;">
            {include file='page/admin/view/admin.message.tpl'}
        </div>
        {include file='page/admin/view/admin.list_filter.tpl'}
        <div class="top_filtering" >
            {html_options name=$FilterStatus.name options=$FilterStatus.values selected=$FilterStatus.activ}
            <div class="clear"></div>
        </div>
        <table class="sorting">
            {include file='page/admin/view/admin.list_table_header.tpl'}  
            {foreach from=$Lista key=for_id item=lista}
            <tr class="data_row">
                <th class="checkers"><input type="checkbox" class="select_row" name="{$SelRow.name}[{$lista.ID}]" value="{$lista.ID}"></th>
                <td class="align_left">
                    <a href="{$APP_LINK}/edit/{$lista.ID}" title="Módosítás">
                        {if $lista.elso}
                        {$lista.elso}
                        {else}
                        <i>Regisztrált ügyfél, de nem felhasználó!</i>
                        {/if}
                    </a>
                </td>
                <td class="align_left center">
                    <a href="{$APP_LINK}/edit/{$lista.ID}" title="Módosítás">{$lista.user_email}</a>
                </td>
                <td class="align_left center">{$lista.Nev}</td>
                <td class="align_left center">{$lista.user_reg_date}</td>
                <td class="align_left center">
                    {if $lista.user_last_login eq 0}
                    <i>Még nem jelentkezett be!</i>    
                    {else}
                    {$lista.user_last_login}
                    {/if}
                </td>
                <td class="align_left center">
                    {if $lista.user_megerositve eq 0}
                    <i>Még nem erősítette meg!</i>
                    {else}
                    {$lista.user_megerositve_date}
                    {/if}
                </td>
                {block name="BlockCols"}{/block}
                <td>
                {if $lista.Aktiv}
                <button id="statusz_{$for_id}" title="Visszavonás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan visszavonja a felhasználót', 'Visszavonja a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnUnpublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-locked"/>Visszavonás</span></button>
                {else}
                <button id="statusz_{$for_id}" title="Publikálás" class="statusz" onclick="return confirmBox('statusz_{$for_id}', 'Biztosan publikussá teszi a felhasználót', 'Publikussá teszi a(z) <strong>{$lista.elso}</strong> tételt?');" name="{$BtnPublish}" value="{$lista.ID}"><span class="ui-icon ui-icon-unlocked"/>Publikálás</span></button>
                {/if}
                </td>
            </tr>                             
            {/foreach}
        </table>
        {include file='page/admin/view/admin.paging.tpl'} 
    </div>
</form>