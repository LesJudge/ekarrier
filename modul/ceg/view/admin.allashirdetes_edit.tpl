<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        $("#{$TxtNev.name}").removeAccents({ target: $("#{$TxtLink.name}"), bind:"change" });
        $("#{$TxtLink.name}").removeAccents();
        $(".as-selection-item").addClass("ui-widget-content");
        $(".as-selections").addClass("ui-widget-content");
        $("#{$SelKompetencia.name}").multiselect().multiselectfilter();

});
/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Álláshirdetés - [{$edit_mode}]</h2>
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
                                        <label for="{$TxtLink.name}">Link <span class="require">*</span></label>
                                        <input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}"/>
                                        <span class="ui-icon ui-icon-info tip" title="A link a böngésző címsorában szerepel (URL-ben). A linkben csak bizonyos karakterek megengedettek, ezért az ön által megadott szöveg  átalakításra kerül. A link a pontos azonosítás érdekében <strong>egyedi</strong>."></span>
                                        {if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                        
                        <div class="field">
                                <div class="form_row">
                                        <label for="{$SelCeg.name}">Cég <span class="require">*</span></label>
                                        {html_options name=$SelCeg.name options=$SelCeg.values selected=$SelCeg.activ}  
                                        {if isset($SelCeg.error)}<p class="error small">{$SelCeg.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form-row">
                                        <label>Ellenőrzött álláshirdetés <span class="require">*</span></label>
                                        {html_radios name=$ChkEllenorzott.name options=$ChkEllenorzott.values selected=$ChkEllenorzott.activ}
                                        {if isset($ChkEllenorzott.error)}<p class="error small">{$ChkEllenorzott.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label>Publikus <span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                        
                        <div class="field">
                                <div class="form_row">
                                        <label for="{$TxtIsmerteto.name}">Tartalom <span class="require">*</span></label>
                                        <textarea class="tinymce" id="{$TxtIsmerteto.name}" name="{$TxtIsmerteto.name}">{$TxtIsmerteto.activ}</textarea>
                                        {if isset($TxtIsmerteto.error)}<p class="error small">{$TxtIsmerteto.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                </div>
        </div>
        
        {if isset($allashirdetes_create_date)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row">
                                <strong>Megtekintve:</strong> {$allashirdetes_megtekintve} 
                                <input class="submit" style="margin-left: 10px; padding: 1px;" type="submit" name="{$BtnDeleteMegtekintes}" value="Törlés"/>
                        </div><div class="clear"></div>
                        <div class="form_row"> <strong>Javítások száma:</strong> {$allashirdetes_javitas_szama} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozva:</strong> {$allashirdetes_create_date} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozó:</strong> {$allashirdetes_letrehozo} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$allashirdetes_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$allashirdetes_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$allashirdetes_allapot} </div><div class="clear"></div>
                </div>
        </div>
        {/if}
</form>