<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    
    $('select[name="{$SelKomps.name}[]"]').multiselect().multiselectfilter();
});
/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Szektor - [{$edit_mode}]</h2>
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
                                        <label for="{$TxtLeiras.name}">Leírás <span class="require">*</span></label>
                                        <textarea id="{$TxtLeiras.name}" class="tinymce" name="{$TxtLeiras.name}">{$TxtLeiras.activ}</textarea>
                                        {if isset($TxtLeiras.error)}<p class="error small">{$TxtLeiras.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                
                                <div class="form_row">
                                        <label for="{$SelKomps.name}">Kompetenciák </label>
                                        {html_options multiple name=$SelKomps.name options=$SelKomps.values selected=$SelKomps.activ}
                                        {if isset($SelKomps.error)}<p class="error small">{$SelKomps.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label>Publikus <span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                </div>
        </div>
        {if isset($pozicio_create_date)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row"> <strong>Javítások száma:</strong> {$javitas_szama} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozva:</strong> {$pozicio_create_date} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozó:</strong> {$pozicio_letrehozo} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$pozicio_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$pozicio_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$pozicio_allapot} </div><div class="clear"></div>
                </div>
        </div>
        {/if}
</form>