<script type="text/javascript" src="../js/uwLocationFinder.js"></script>
<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        
        var locationFinder=new $.uwLocationFinder($("#{$TxtIrszam.name}"),{
                zipCodeIdInput:"#{$HiddenIrszamId.name}",
                shireInput:"#{$TxtMegye.name}",
                cityInput:"#{$TxtVaros.name}",
                ajaxUrl:"{$DOMAIN}iranyitoszam-kereso/"
        });
});
/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Telephely - [{$edit_mode}]</h2>
                        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
                </div>
                
                <div class="box_content padding">
                        {include file='page/admin/view/admin.message.tpl'}
                        {include file='page/admin/view/admin.edit_events.tpl'} 
                        <div class="field">
                                <div class="form_row">
                                        <label for="{$SelCeg.name}">Cég&nbsp;<span class="require">*</span></label>
                                        {html_options id=$SelCeg.name name=$SelCeg.name options=$SelCeg.values selected=$SelCeg.activ}
                                        {if isset($SelCeg.error)}<p class="error small">{$SelCeg.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$SelOrszag.name}">Ország&nbsp;<span class="require">*</span></label>
                                        {html_options id=$SelOrszag.name name=$SelOrszag.name options=$SelOrszag.values selected=$SelOrszag.activ}
                                        {if isset($SelOrszag.error)}<p class="error small">{$SelOrszag.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$SelIrsz.name}">Irányítószám&nbsp;<span class="require">*</span></label>
                                        {html_options id=$SelIrsz.name name=$SelIrsz.name options=$SelIrsz.values selected=$SelIrsz.activ}
                                        {if isset($SelIrsz.error)}<p class="error small">{$SelIrsz.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$SelMegye.name}">Megye&nbsp;<span class="require">*</span></label>
                                        {html_options id=$SelMegye.name name=$SelMegye.name options=$SelMegye.values selected=$SelMegye.activ}
                                        {if isset($SelMegye.error)}<p class="error small">{$SelMegye.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$SelVaros.name}">Város&nbsp;<span class="require">*</span></label>
                                        {html_options id=$SelVaros.name name=$SelVaros.name options=$SelVaros.values selected=$SelVaros.activ}
                                        {if isset($SelVaros.error)}<p class="error small">{$SelVaros.error}</p>{/if}
                                </div><div class="clear"></div>
                                <!--
                                
                                <div class="form_row">
                                        <label for="{$TxtIrszam.name}">Irányítószám&nbsp;<span class="require">*</span></label>
                                        <input id="{$TxtIrszam.name}" name="{$TxtIrszam.name}" type="text" value="{$TxtIrszam.activ}" />
                                        <input id="{$HiddenIrszamId.name}" name="{$HiddenIrszamId.name}" type="hidden" value="{$HiddenIrszamId.activ}" />
                                        {if isset($TxtIrszam.error)}<p class="error small">{$TxtIrszam.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$TxtMegye.name}">Megye&nbsp;<span class="require">*</span></label>
                                        <input id="{$TxtMegye.name}" name="{$TxtMegye.name}" readonly="readonly" type="text" value="{$TxtMegye.activ}" />
                                        {if isset($TxtMegye.error)}<p class="error small">{$TxtMegye.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$TxtVaros.name}">Város&nbsp;<span class="require">*</span></label>
                                        <input id="{$TxtVaros.name}" name="{$TxtVaros.name}" readonly="readonly" type="text" value="{$TxtVaros.activ}" />
                                        {if isset($TxtVaros.error)}<p class="error small">{$TxtVaros.error}</p>{/if}
                                </div><div class="clear"></div>
                                -->
                                <div class="form_row">
                                        <label for="{$TxtUtca.name}">Utca&nbsp;<span class="require">*</span></label>
                                        <input type="text" id="{$TxtUtca.name}" name="{$TxtUtca.name}" value="{$TxtUtca.activ}"/>
                                        {if isset($TxtUtca.error)}<p class="error small">{$TxtUtca.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$TxtHsz.name}">Házszám&nbsp;<span class="require">*</span></label>
                                        <input type="text" id="{$TxtHsz.name}" name="{$TxtHsz.name}" value="{$TxtHsz.activ}"/>
                                        {if isset($TxtHsz.error)}<p class="error small">{$TxtHsz.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                        
                        <div class="field">
                                <div class="form_row">
                                        <label>Publikus&nbsp;<span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                </div>
        </div>
        
        {if isset($ceg_telephely_letrehozas_datum)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row"> <strong>Javítások száma:</strong> {$ceg_telephely_modositas_szama} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozva:</strong> {$ceg_telephely_letrehozas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozó:</strong> {$ceg_telephely_letrehozo} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$ceg_telephely_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$ceg_telephely_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$ceg_telephely_allapot} </div><div class="clear"></div>
                </div>
        </div>
        {/if}
</form>