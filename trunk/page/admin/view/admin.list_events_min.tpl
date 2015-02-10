<div class="form_muvelet">
    <a href="{$DOMAIN_ADMIN}{$APP_LINK}/edit{$LANG_PARAM}" ><span class="ui-button-text"><img class="tip" src="../images/admin/icons/add_data.png"  title="{php}echo LANG_AdminList_uj;{/php}"></span></a>
    <button class="submit tip" id="{$BtnMultipleDelete}" name="{$BtnMultipleDelete}" value="{php}echo LANG_AdminList_torol;{/php}" title="{php}echo LANG_AdminList_torol;{/php}" onclick="return confirmBox('{$BtnMultipleDelete}', '{php}echo LANG_AdminList_torol;{/php}', '{php}echo LANG_AdminList_torol_content;{/php}');"><img src="../images/admin/icons/trash_can.png"></button>
    <!--button class="submit" name="" value="Help" title="Help"><img src="../images/admin/icons/rescue.png"></button-->
</div>