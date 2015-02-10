<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}
    $('#{$DateKikuldes.name}').datetimepicker();
    tinyMCESablon = {$sablon};
    tinymce.create('tinymce.plugins.example', { createControl: function(n, cm) { switch (n) {
                                        case 'mymenubutton': 
                                        var c = cm.createSplitButton('mymenubutton', { title : 'Változó beillesztése', image : '../images/admin/valtozo.gif' }); c.onRenderMenu.add(function(c, m) { var sub;
                                        m.add({ title : 'Domain', onclick : function() { tinyMCE.activeEditor.execCommand('mceInsertContent', false, '&#123;$domain&#125;'); }});                                        
                                        m.add({ title : 'Leiratkozasilink', onclick : function() { tinyMCE.activeEditor.execCommand('mceInsertContent', false, '&#123;$leiratkozas_link&#125;'); }});
                                        sub = m.addMenu({ title : 'Címlista személy'});
                                        sub.add({ title : 'Neve', onclick : function() { tinyMCE.activeEditor.execCommand('mceInsertContent', false, '&#123;$cimlista_szemely_nev&#125;'); }});
                                        sub.add({ title : 'E-mail címe', onclick : function() { tinyMCE.activeEditor.execCommand('mceInsertContent', false, '&#123;$cimlista_szemely_email&#125;'); }});
                                }); return c;
                } return null; }
    });
    tinymce.PluginManager.add('example', tinymce.plugins.example);
});

</script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
    	<div class="box_top">
            <h2 class="icon time">Hírlevél - [{$edit_mode}]</h2>
        </div>
        <div class="box_content padding"> 
			{include file='page/admin/view/admin.message.tpl'}
			<div class="form_muvelet">
				{if !$hirlevel_lezarva}    
					<a><button class="submit" name="{$BtnSave}" id="{$BtnSave}" value="sendHirlevel" title="Kiküldés"><img src="../images/admin/icons/send.png" /></button></a>				
					<a><button class="submit" name="{$BtnSave}" id="{$BtnSave}" value="{php}echo LANG_AdminEdit_mentes;{/php}" title="{php}echo LANG_AdminEdit_mentes;{/php}"><img src="../images/admin/icons/save.png"/></button></a>
				{/if}
                <a href="{$DOMAIN_ADMIN}{$APP_LINK}" id="{$FormName}_close" class="submit ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text"><img class="tip" title="{php}echo LANG_AdminEdit_megse;{/php}" src="../images/admin/icons/cancel.png"/></span></a>
            </div>
            <div class="field"> 
                <div class="form_row">
                    <label for="{$TxtTargy.name}">Tárgy <span class="require">*</span></label>
                    <input type="text" id="{$TxtTargy.name}" name="{$TxtTargy.name}" value="{$TxtTargy.activ}"/>
                    {if isset($TxtTargy.error)}<p class="error small">{$TxtTargy.error}</p>{/if} 
                </div><div class="clear"></div>
                <div class="form_row">
                    <label for="{$TxtFeladoNev.name}">Feladó neve <span class="require">*</span></label>
                    <input type="text" id="{$TxtFeladoNev.name}" name="{$TxtFeladoNev.name}" value="{$TxtFeladoNev.activ}"/>
                	{if isset($TxtFeladoNev.error)}<p class="error small">{$TxtFeladoNev.error}</p>{/if} 
                </div><div class="clear"></div>
                <div class="form_row">
                    <label for="{$TxtFeladoEmail.name}">Feladó e-mail címe <span class="require">*</span></label>
                    <input type="text" id="{$TxtFeladoEmail.name}" name="{$TxtFeladoEmail.name}" value="{$TxtFeladoEmail.activ}"/>
                    {if isset($TxtFeladoEmail.error)}<p class="error small">{$TxtFeladoEmail.error}</p>{/if} 
                </div><div class="clear"></div>
                <div class="form_row">
                    <label for="{$SelCsoport.name}">Csoport</label>
                    {html_checkboxes name=$SelCsoport.name options=$SelCsoport.values selected=$SelCsoport.activ separator=''}
                    {if isset($SelCsoport.error)}<p class="error small">{$SelCsoport.error}</p>{/if}
				</div><div class="clear"></div>
                <div class="form_row">
                	<label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
                    <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
                    {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if}
				</div><div class="clear"></div>
                <div class="form_row_50">
                    <label for="{$DateKikuldes.name}">Kiküldés dátuma</label>
                    <input type="text" id="{$DateKikuldes.name}" name="{$DateKikuldes.name}" value="{$DateKikuldes.activ}" class="date-input" readonly="readonly"/>
                    {if isset($DateKikuldes.error)}<p class="error small">{$DateKikuldes.error}</p>{/if}
				</div><div class="clear"></div>
                <div class="form_row">
                    <label>Próba küldés</label>
                    {html_radios name=$ChkProba.name options=$ChkProba.values selected=$ChkProba.activ}
                    {if isset($ChkProba.error)}<p class="error small">{$ChkProba.error}</p>{/if}
				</div><div class="clear"></div>  
            </div>
        </div>
	</div>
	{if isset($hirlevel_create_date)}
		<div class="grid_6"> 
			<div class="box_top">
				<h2 class="icon time">Információ</h2>
			</div>
			<div class="box_content padding">
			      <div class="form_row"> <strong>Javítások száma:</strong> {$hirlevel_javitas_szama} </div><div class="clear"></div>
			      <div class="form_row"> <strong>Létrehozva:</strong> {$hirlevel_create_date} </div><div class="clear"></div>
			      <div class="form_row"> <strong>Létrehozó:</strong> {$hirlevel_letrehozo} </div><div class="clear"></div>
			      <div class="form_row"> <strong>Utoljára módosítva:</strong> {$hirlevel_modositas_datum} </div><div class="clear"></div>
			      <div class="form_row"> <strong>Utolsó módosító:</strong> {$hirlevel_modosito} </div><div class="clear"></div>
			      <div class="form_row"> <strong>Címzettek (db):</strong> {$hirlevel_cimzett_szum} </div><div class="clear"></div>
			      <div class="form_row"> <strong>Kiküldve (db):</strong> {$hirlevel_kikuldve} </div><div class="clear"></div>
			      <div class="form_row"> <strong>Megnyitva (db):</strong> {$hirlevel_megnyitva} </div><div class="clear"></div>
			</div>
      	</div>
	{/if}
</form>