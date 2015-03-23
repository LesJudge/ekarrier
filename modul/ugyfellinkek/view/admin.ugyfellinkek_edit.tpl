<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        
        $(".as-selection-item").addClass("ui-widget-content");
        $(".as-selections").addClass("ui-widget-content");

 

    jQuery.each($(".mceNonEditable"), function() {
        tinyMCE.init({ mode : "exact", elements : this.id, theme : "advanced", skin : "o2k7", skin_variant : "silver", language : "hu", theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom", gecko_spellcheck : "true", plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
    	theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,link,unlink,forecolor,backcolor,cleanup,|",    	
		theme_advanced_resizing : true,			
		document_base_url : $("#DOMAIN").val(),			
		width : "630",  
		height : "300", 
		paste_auto_cleanup_on_paste : true, 
		plugin_preview_width : "1000", 
		theme_advanced_resize_horizontal : false,
                readonly : 1,
        theme_advanced_path : false,theme_advanced_statusbar_location : 0,
		});
        }); 


});

/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Link - [{$edit_mode}]</h2>
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
                                        <label for="{$TxtUrl.name}">URL <span class="require">*</span></label>
                                        <input type="text" id="{$TxtUrl.name}" name="{$TxtUrl.name}" value="{$TxtUrl.activ}"/> <a href='{$TxtUrl.activ}' target='_blank'>Megtekintés</a>
                                        {if isset($TxtUrl.error)}<p class="error small">{$TxtUrl.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label for="{$SelKat.name}">Kategória <span class="require">*</span></label>
                                        {if $ugyf == '1'}
                                            <input type="text" id="{$SelKat.name}" name="{$SelKat.name}" value="{$SelKat.activ}" readonly />
                                        {else}
                                            {html_options name=$SelKat.name options=$SelKat.values selected=$SelKat.activ}
                                        {/if}
                                        {if isset($SelKat.error)}<p class="error small">{$SelKat.error}</p>{/if}
                                </div><div class="clear"></div>
                                 <br/>
                                {if $ugyf == '1'}
                                    <label>{$content.nev|ucfirst}: </label>
                                    <br/>
                                    <textarea id='relContent' class='mceNonEditable'>{$content.leiras}</textarea>
                                {/if}
                                
                        </div>
                        
                        <div class="field">
                               
                                    <div class="form_row" style="{if $ugyf != '1'}display:none{/if}">
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