<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}

        $("input[name=\"{$DateTimeFelvetel.name}\"]").datetimepicker();

});
/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_24">      
                <div class="box_top">
                        <h2 class="icon time">Kapcsolatfelvétel - [{$edit_mode}]</h2>
                        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'}
                </div>
                <div class="box_content padding">
                        {include file='page/admin/view/admin.message.tpl'}
                        {include file='page/admin/view/admin.edit_events.tpl'}
                        <div class="field">
                                <div class="form_row">                          
                                        <label for="{$SelUser.name}">Felhasználó <span class="require">*</span></label>
                                        {html_options name=$SelUser.name options=$SelUser.values selected=$SelUser.activ}
                                        {if isset($SelUser.error)}<p class="error small">{$SelUser.error}</p>{/if}
                                </div><div class="clear"></div>
                                <div class="form_row">
                                        <label for="{$DateTimeFelvetel.name}">Felvétel ideje <span class="require">*</span></label>
                                        <input type="text" id="{$DateTimeFelvetel.name}" name="{$DateTimeFelvetel.name}" value="{$DateTimeFelvetel.activ}"/>
                                        {if isset($DateTimeFelvetel.error)}<p class="error small">{$DateTimeFelvetel.error}</p>{/if}
                                </div><div class="clear"></div>
                                <div class="form_row">
                                        <label for="{$TxtMegjegyzes.name}">Megjegyzés</label>
                                        <textarea id="{$TxtMegjegyzes.name}" name="{$TxtMegjegyzes.name}">{$TxtMegjegyzes.activ}</textarea>
                                        {if isset($TxtMegjegyzes.error)}<p class="error small">{$TxtMegjegyzes.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                </div>
        </div>
</form>