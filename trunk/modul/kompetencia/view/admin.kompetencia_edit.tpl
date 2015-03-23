<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script src='../js/spectrum/spectrum.js'></script>
<link rel='stylesheet' href='../js/spectrum/spectrum.css'/>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        $("#{$TxtNev.name}").removeAccents({ target: $("#{$TxtLink.name}"), bind:"change" });
        $("#{$TxtLink.name}").removeAccents();
        $("#{$TxtKulcsszo.name}").autoSuggest("",{ neverSubmit: true, showResultList:false, asHtmlID:'{$TxtKulcsszo.name}', preFill: '{$TxtKulcsszo.activ}', selectionRemoved: function(elem){ elem.remove();if($("li.as-selection-item").length == 0){ $("input[type='hidden']").attr("value", ""); }; } });
        $(".as-selection-item").addClass("ui-widget-content");
        $(".as-selections").addClass("ui-widget-content");
        $('select[name="{$SelKapcsolodo.name}[]"]').multiselect().multiselectfilter();
        $('select[name="{$SelKategoria.name}[]"]').multiselect().multiselectfilter();
        
    $("#{$TxtSzinkod.name}").spectrum({
    color: "{$TxtSzinkod.activ}",
    change: function(color) {
        $("#{$TxtSzinkod.name}").attr('value',color.toHexString());
        console.log($("#{$TxtSzinkod.name}").attr('value'));
    }
});    
});

/*]]>*/
</script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Kompetencia - [{$edit_mode}]</h2>
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
                               
                                <div class="form_row" {if $ugyf == '1'} style='display:none'{/if}>
                                        <label for="{$TxtLink.name}">Link <span class="require">*</span></label>
                                        <input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}"/>
                                        <span class="ui-icon ui-icon-info tip" title="A link a böngésző címsorában szerepel (URL-ben). A linkben csak bizonyos karakterek megengedettek, ezért az ön által megadott szöveg  átalakításra kerül. A link a pontos azonosítás érdekében <strong>egyedi</strong>."></span>
                                        {if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row"{if $ugyf == '1'} style='display:none'{/if}>
                                        <label for="{$TxtKulcsszo.name}">Kulcsszavak <span class="require">*</span></label>
                                        <input type="text" id="{$TxtKulcsszo.name}" name="{$TxtKulcsszo.name}" value="{$TxtKulcsszo.activ}"/>
                                        <span class="ui-icon ui-icon-info tip" title="Az adott oldal kulcsszavai. Rövid, vesszővel elválasztott egyszavas jelzők az oldal tartalmára nézve. (<em>pl. Bemutatkozó oldal esetében: bemutatkozás, céginformáció</em>)"></span>
                                        <div class="clear"></div>
                                        <span class="info">Vesszővel hagyhatja jóvá a kulcsszavat.</span> 
                                        {if isset($TxtKulcsszo.error)}<p class="error small">{$TxtKulcsszo.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row"{if $ugyf == '1'} style='display:none'{/if}>
                                        <label for="{$TxtLeiras.name}">Leírás <span class="require">*</span></label>
                                        <textarea id="{$TxtLeiras.name}" name="{$TxtLeiras.name}">{$TxtLeiras.activ}</textarea>
                                        {if isset($TxtLeiras.error)}<p class="error small">{$TxtLeiras.error}</p>{/if} 
                                </div><div class="clear"></div>
                                
                                <div class="form_row"{if $ugyf == '1'} style='display:none'{/if}>
                                        <label for="{$TxtSzinkod.name}">Színkód <span class="require">*</span></label>
                                        <input type='text' id="{$TxtSzinkod.name}" name="{$TxtSzinkod.name}" value='{$TxtSzinkod.activ}'>
                                        {if isset($TxtSzinkod.error)}<p class="error small">{$TxtSzinkod.error}</p>{/if} 
                                </div><div class="clear"></div>
                                
                        </div>
                        
                        <div class="field">
                               
                                <div class="form_row"{if $ugyf == '1'} style='display:none'{/if} >
                                        <label for="{$SelKapcsolodo.name}">Szektor </label>
                                        {html_options multiple name=$SelKapcsolodo.name options=$SelKapcsolodo.values selected=$SelKapcsolodo.activ}
                                        {if isset($SelKapcsolodo.error)}<p class="error small">{$SelKapcsolodo.error}</p>{/if}
                                </div><div class="clear"></div>
                               
                                
                                    <div class="form_row"{if $ugyf != '1'}style='display:none'{/if}>
                                            <label>Ellenőrizve <span class="require">*</span></label>
                                            {html_radios name=$ChkChecked.name options=$ChkChecked.values selected=$ChkChecked.activ}
                                            {if isset($ChkChecked.error)}<p class="error small">{$ChkChecked.error}</p>{/if}
                                    </div><div class="clear"></div>
                                    <div class="form_row" style='display:none'>
                                        <label for="{$TxtTipus.name}">Név <span class="require">*</span></label>
                                        <input type="text" id="{$TxtTipus.name}" name="{$TxtTipus.name}" value="{$TxtTipus.activ}"/>
                                        {if isset($TxtTipus.error)}<p class="error small">{$TxtTipus.error}</p>{/if}
                                </div><div class="clear"></div>
                                    
                                
                                <div class="form_row">
                                        <label>Publikus <span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                         
                        <div class="field">
                                <div class="form_row" {if $ugyf == '1'}style='display:none'{/if}>
                                        <label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
                                        <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
                                        {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                             
                </div>
        </div>
        
        {if isset($kompetencia_create_date)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row">
                                <strong>Megtekintve:</strong> {$kompetencia_megtekintve} 
                                <input class="submit" style="margin-left: 10px; padding: 1px;" type="submit" name="{$BtnDeleteMegtekintes}" value="Törlés"/>
                        </div><div class="clear"></div>
                        <div class="form_row"> <strong>Javítások száma:</strong> {$kompetencia_javitas_szama} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozva:</strong> {$kompetencia_create_date} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozó:</strong> {$kompetencia_letrehozo} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$kompetencia_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$kompetencia_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$kompetencia_allapot} </div><div class="clear"></div>
                </div>
        </div>
        {/if}
</form>