<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}
    $("#{$TxtCim.name}").removeAccents({ target: $("#{$TxtLink.name}"), bind:"change" });
    $("#{$TxtLink.name}").removeAccents();
    $("#{$TxtKulcsszo.name}").autoSuggest("",{ neverSubmit: true, showResultList:false, asHtmlID:'{$TxtKulcsszo.name}', preFill: '{$TxtKulcsszo.activ}', selectionRemoved: function(elem){ elem.remove();if($("li.as-selection-item").length == 0){ $("input[type='hidden']").attr("value", ""); }; } });
    $(".as-selection-item").addClass("ui-widget-content");
    $(".as-selections").addClass("ui-widget-content");
    $('#{$DateMegjelenes.name},#{$DateLejarat.name}').datetimepicker();
    $('select[name="{$SelKapcsolodo.name}[]"]').multiselect().multiselectfilter();
    $('select[name="{$SelKategoria.name}[]"]').multiselect().multiselectfilter();
}) 
</script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_18">
    	<div class="box_top">
            <h2 class="icon time">Hír - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
		</div>
        <div class="box_content padding">
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'} 
            <div class="field">
                <div class="form_row">
                    <label for="{$TxtCim.name}">Cím <span class="require">*</span></label>
                	<input type="text" id="{$TxtCim.name}" name="{$TxtCim.name}" value="{$TxtCim.activ}"/>
                    {if isset($TxtCim.error)}<p class="error small">{$TxtCim.error}</p>{/if}
				</div><div class="clear"></div>
                <div class="form_row">
                    <label for="{$TxtLink.name}">Link <span class="require">*</span></label>
					<input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}"/>
					<span class="ui-icon ui-icon-info tip" title="A link a böngésző címsorában szerepel (URL-ben). A linkben csak bizonyos karakterek megengedettek, ezért az ön által megadott szöveg  átalakításra kerül. A link a pontos azonosítás érdekében <strong>egyedi</strong>."></span>
					{if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if}
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
                <div class="form_row">
                	<label for="{$SelKategoria.name}">Kategória <span class="require">*</span></label>
                    {html_options multiple name=$SelKategoria.name options=$SelKategoria.values selected=$SelKategoria.activ}  
					{if isset($SelKategoria.error)}<p class="error small">{$SelKategoria.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
            <div class="field">
                <div class="form_row">
					<label for="{$File.name}">Kép </label>
					<input type="file" name="{$File.name}" id="{$File.name}" value="" style="width:300px;"/>
					{if isset($File.error)}<p class="error small">{$File.error}</p>{/if} 
					<br />
					<span class="info">Maximum: {$kep_max_size}</span> 
				</div><div class="clear"></div>
                {if $hir_kep_nev}
                    <div class="form_row">
                          <label>
                                <button title="Kép törlése" id="{$BtnDeleteFile}" name="{$BtnDeleteFile}" value="{$hir_kep_nev}" onclick="return confirmBox('{$BtnDeleteFile}', '{php}echo LANG_Cnfr_DeletePicTitle;{/php}', '{php}echo LANG_Cnfr_DeletePic;{/php}');">
									<span class="ui-icon ui-icon-circle-close">Kép törlése</span>
								</button>
                          </label>
                          <img class="form-pic" src="{$DOMAIN}pic/{$APP_PATH}/{$hir_kep_nev}_75x75"/> 
					</div><div class="clear"></div>
                {/if}
            </div>
            <div class="field">
            	<div class="form_row">
                	<label for="{$TxtSzerzo.name}">Szerző</label>
                    <input type="text" id="{$TxtSzerzo.name}" name="{$TxtSzerzo.name}" value="{$TxtSzerzo.activ}"/>
                    {if isset($TxtSzerzo.error)}<p class="error small">{$TxtSzerzo.error}</p>{/if}
				</div><div class="clear"></div>
                <div class="form_row_50">
					<label for="{$DateMegjelenes.name}">Megjelenési dátum</label>
					<input type="text" id="{$DateMegjelenes.name}" name="{$DateMegjelenes.name}" value="{$DateMegjelenes.activ}" readonly="readonly" class="date-input"/>
					{if isset($DateMegjelenes.error)}<p class="error small" style="width: 125px !important;">{$DateMegjelenes.error}</p>{/if}
				</div>
                <div class="form_row_50">
					<label for="{$DateLejarat.name}">Lejárati dátum</label>
					<input type="text" id="{$DateLejarat.name}" name="{$DateLejarat.name}" value="{$DateLejarat.activ}" class="date-input"/>
					<span class="ui-icon ui-icon-info tip" title="Törölje ki a mező értékét, ha azt szeretné, hogy a tartalom sosem járjon le."></span> 
					{if isset($DateLejarat.error)}<p class="error small" style="width: 125px !important;">{$DateLejarat.error}</p>{/if}
				</div><div class="clear"></div>
                <div class="form_row">
                    <label>Publikus</label>
                    {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                    {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
            <div class="field">
                <div class="form_row">
                    <label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
                    <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
                    {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if}
				</div><div class="clear"></div>
                <!--div class="form_row">
                	<label for="{$SelGroup.name}">Jog csoport</label>
                    {html_options name=$SelGroup.name options=$SelGroup.values selected=$SelGroup.activ} <span class="ui-icon ui-icon-info tip" title="Milyen csoportba tartozó külső oldali felhasználók láthatják ezt a hírt."></span> 
					{if isset($SelGroup.error)}<p class="error small">{$SelGroup.error}</p>{/if} 
				</div><div class="clear"></div-->
                <div class="form_row">
                	<label for="{$SelKapcsolodo.name}">Kapcsolódó hírek</label>
                    {html_options multiple name=$SelKapcsolodo.name options=$SelKapcsolodo.values selected=$SelKapcsolodo.activ}
                    {if isset($SelKapcsolodo.error)}<p class="error small">{$SelKapcsolodo.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
      </div>
	</div>
    {if isset($hir_create_date)}
    	<div class="grid_6"> 
    		<div class="box_top">
            	<h2 class="icon time">Információ</h2>
            </div>
            <div class="box_content padding">
                <div class="form_row"> <strong>Megtekintve:</strong> {$hir_megtekintve} 
                    <input class="submit" style="margin-left: 10px; padding: 1px;" type="submit" name="{$BtnDeleteMegtekintes}" value="Törlés"/>
                </div><div class="clear"></div>
				<div class="form_row"> <strong>Javítások száma:</strong> {$hir_javitas_szama} </div><div class="clear"></div>
				<div class="form_row"> <strong>Létrehozva:</strong> {$hir_create_date} </div><div class="clear"></div>
				<div class="form_row"> <strong>Létrehozó:</strong> {$hir_letrehozo} </div><div class="clear"></div>
				<div class="form_row"> <strong>Utoljára módosítva:</strong> {$hir_modositas_datum} </div><div class="clear"></div>
				<div class="form_row"> <strong>Utolsó módosító:</strong> {$hir_modosito} </div><div class="clear"></div>
				<div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$hir_allapot} </div><div class="clear"></div>
            </div>
    	</div>
    {/if}
</form>