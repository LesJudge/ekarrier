<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        $("#{$TxtKulcsszo.name}").autoSuggest("",{ neverSubmit: true, showResultList:false, asHtmlID:'{$TxtKulcsszo.name}', preFill: '{$TxtKulcsszo.activ}', selectionRemoved: function(elem){ elem.remove();if($("li.as-selection-item").length == 0){ $("input[type='hidden']").attr("value", ""); }; } });
        $(".as-selection-item").addClass("ui-widget-content");
        $(".as-selections").addClass("ui-widget-content");
});
/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Infobox - [{$edit_mode}]</h2>
                        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
                </div>
                
                <div class="box_content padding">
                        {include file='page/admin/view/admin.message.tpl'}
                        {include file='page/admin/view/admin.edit_events.tpl'} 
                        <div class="field">
                                <div class="form_row">
                                        <label for="{$TxtNev.name}">Név <span class="require">*</span></label>
                                        <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
                                        {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$TxtKulcs.name}">Kulcs <span class="require">*</span></label>
                                        <input type="text" id="{$TxtKulcs.name}" name="{$TxtKulcs.name}" value="{$TxtKulcs.activ}"/>
                                        {if isset($TxtKulcs.error)}<p class="error small">{$TxtKulcs.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
                                        <textarea id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
                                        {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if} 
                                </div><div class="clear"></div>
                        </div>
                        
                        <div class="field">
                                <div class="form_row">
                                        <label>Publikus <span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                </div>
        </div>
        
        {if isset($infobox_create_date)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row"> <strong>Javítások száma:</strong> {$infobox_javitas_szama} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozva:</strong> {$infobox_create_date} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozó:</strong> {$infobox_letrehozo} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$infobox_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$infobox_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$infobox_allapot} </div><div class="clear"></div>
                </div>
        </div>
        {/if}
</form>