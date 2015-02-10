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
                        <h2 class="icon time">SEO - [{$edit_mode}]</h2>
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
                                        <label for="{$TxtKulcsszo.name}">Kulcsszavak <span class="require">*</span></label>
                                        <input type="text" id="{$TxtKulcsszo.name}" name="{$TxtKulcsszo.name}" value="{$TxtKulcsszo.activ}"/>
                                        <span class="ui-icon ui-icon-info tip" title="Az adott oldal kulcsszavai. Rövid, vesszővel elválasztott egyszavas jelzők az oldal tartalmára nézve. (<em>pl. Bemutatkozó oldal esetében: bemutatkozás, céginformáció</em>)"></span>
                                        <div class="clear"></div>
                                        <span class="info">Vesszővel hagyhatja jóvá a kulcsszavat.</span> 
                                        {if isset($TxtKulcsszo.error)}<p class="error small">{$TxtKulcsszo.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$TxtLeiras.name}">Leírás <span class="require">*</span></label>
                                        <textarea id="{$TxtLeiras.name}" name="{$TxtLeiras.name}">{$TxtLeiras.activ}</textarea>
                                        {if isset($TxtLeiras.error)}<p class="error small">{$TxtLeiras.error}</p>{/if} 
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
        
        {if isset($seo_create_date)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row">
                                <strong>Megtekintve:</strong> {$seo_megtekintve} 
                                <input class="submit" style="margin-left: 10px; padding: 1px;" type="submit" name="{$BtnDeleteMegtekintes}" value="Törlés"/>
                        </div><div class="clear"></div>
                        <div class="form_row"> <strong>Javítások száma:</strong> {$seo_javitas_szama} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozva:</strong> {$seo_create_date} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozó:</strong> {$seo_letrehozo} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$seo_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$seo_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$seo_allapot} </div><div class="clear"></div>
                </div>
        </div>
        {/if}
</form>