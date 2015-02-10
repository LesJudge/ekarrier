<script type="text/javascript">
$(function() { {$FormScript}
    $("#{$TxtCim.name}").removeAccents({ target: $("#{$TxtLink.name}"), bind:"change" });
    $("#{$TxtLink.name}").removeAccents();
    $("#{$TxtKulcsszo.name}").autoSuggest("",{ neverSubmit: true, showResultList:false, asHtmlID:'{$TxtKulcsszo.name}', preFill: '{$TxtKulcsszo.activ}', selectionRemoved: function(elem){ elem.remove();if($("li.as-selection-item").length == 0){ $("input[type='hidden']").attr("value", ""); }; } });
    $(".as-selection-item").addClass("ui-widget-content");
    $(".as-selections").addClass("ui-widget-content");
    $('select[name="{$SelKapcsolodo.name}[]"]').multiselect().multiselectfilter();
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_18">
    	<div class="box_top">
            <h2 class="icon time">{$MODUL_NAME} - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
		</div>
        <div class="box_content padding"> 
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'} 
            <div class="field">
                {if !isset($no_view_parent)}
                    <div class="form_row">
                        <label for="{$SelParent.name}">Kategória</label>
                        {html_options name=$SelParent.name options=$SelParent.values selected=$SelParent.activ} 
                        {if isset($SelParent.error)}<p class="error small">{$SelParent.error}</p>{/if}
					</div><div class="clear"></div>
                {/if}
                <div style="display: none;">
                    <input type="text" id="{$KategoriaLeft.name}" name="{$KategoriaLeft.name}" value="{$KategoriaLeft.activ}"/>
                    <input type="text" id="{$KategoriaRight.name}" name="{$KategoriaRight.name}" value="{$KategoriaRight.activ}"/>
                    <input type="text" id="{$KategoriaLevel.name}" name="{$KategoriaLevel.name}" value="{$KategoriaLevel.activ}"/>
                </div>
                <div class="form_row">
                      <label for="{$TxtCim.name}">Név <span class="require">*</span></label>
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
					{if isset($TxtKulcsszo.error)}<p class="error small">{$TxtKulcsszo.error}</p>{/if}
                    <div class="clear"></div>
                    <span class="info">Vesszővel hagyhatja jóvá a kulcsszavat.</span>
				</div><div class="clear"></div>
                <div class="form_row">
					<label for="{$TxtLeiras.name}">Leírás <span class="require">*</span></label>
					<textarea id="{$TxtLeiras.name}" name="{$TxtLeiras.name}">{$TxtLeiras.activ}</textarea>
                	{if isset($TxtLeiras.error)}<p class="error small">{$TxtLeiras.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
            <!--div class="field">
                <div class="form_row">
                    <label for="{$File.name}">Kép </label>
                    <input type="file" name="{$File.name}" id="{$File.name}" value="" style="width:300px;"/>
                	{if isset($File.error)}<p class="error small">{$File.error}</p>{/if}
					<span class="info">Maximum: {$kep_max_size}</span> 
				</div><div class="clear"></div>
                {if $kategoria_kep_nev}
                	<div class="form_row">
                        <label>
                            <button title="Kép törlése" id="{$BtnDeleteFile}" name="{$BtnDeleteFile}" value="{$kategoria_kep_nev}" onclick="return confirmBox('{$BtnDeleteFile}', '{php}echo LANG_Cnfr_DeletePicTitle;{/php}', '{php}echo LANG_Cnfr_DeletePic;{/php}');">
								<span class="ui-icon ui-icon-circle-close">Kép törlése</span>
							</button>
                        </label>
                        <img class="form-pic" src="{$DOMAIN}pic/{$APP_PATH}/{$kategoria_kep_nev}_75x75"/> 
					</div><div class="clear"></div>
                {/if}
            </div-->
            <div class="field tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
            	<div class="form_row">
                    <label>Munkáltató</label>
                    {html_radios name=$ChkMunkaAdo.name options=$ChkMunkaAdo.values selected=$ChkMunkaAdo.activ}
                    {if isset($ChkMunkaAdo.error)}<p class="error small">{$ChkMunkaAdo.error}</p>{/if}
				</div><div class="clear"></div>  
                <div class="form_row">
                    <label>Publikus</label>
                    {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                    {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
				</div><div class="clear"></div>      
                <!--div class="form_row">
                    <label for="{$SelGroup.name}">Jog csoport</label>
                    {html_options name=$SelGroup.name options=$SelGroup.values selected=$SelGroup.activ} <span class="ui-icon ui-icon-info tip" title="Milyen csoportba tartozó külső oldali felhasználók láthatják ezt a tartalmat."></span> 
					{if isset($SelGroup.error)}<p class="error small">{$SelGroup.error}</p>{/if}
				</div><div class="clear"></div-->
                <!--div class="form_row">
                	<label for="{$SelKapcsolodo.name}">Kapcsolódó elemek</label>
                    {html_options multiple name=$SelKapcsolodo.name options=$SelKapcsolodo.values selected=$SelKapcsolodo.activ}
                    {if isset($SelKapcsolodo.error)}<p class="error small">{$SelKapcsolodo.error}</p>{/if}
				</div><div class="clear"></div-->
            </div>
      </div>
	</div>
    {if isset($kategoria_create_date)}
    	<div class="grid_6"> 
            <div class="box_top">
                <h2 class="icon time">Információ</h2>
            </div>
            <div class="box_content padding">
                <div class="form_row"> <strong>Megtekintve:</strong> {$kategoria_megtekintve} 
                	<input class="submit" style="margin-left: 10px; padding: 1px;" type="submit" name="{$BtnDeleteMegtekintes}" value="Törlés"/>
                </div><div class="clear"></div>
                <div class="form_row"> <strong>Javítások száma:</strong> {$kategoria_javitas_szama} </div><div class="clear"></div>
                <div class="form_row"> <strong>Létrehozva:</strong> {$kategoria_create_date} </div><div class="clear"></div>
                <div class="form_row"> <strong>Létrehozó:</strong> {$kategoria_letrehozo} </div><div class="clear"></div>
                <div class="form_row"> <strong>Utoljára módosítva:</strong> {$kategoria_modositas_datum} </div><div class="clear"></div>
                <div class="form_row"> <strong>Utolsó módosító:</strong> {$kategoria_modosito} </div><div class="clear"></div>
            </div>
      </div>
    {/if}
</form>