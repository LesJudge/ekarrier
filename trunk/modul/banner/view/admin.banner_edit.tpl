<script type="text/javascript">
$(function() { {$FormScript}
    $('#{$DateMegjelenes.name},#{$DateLejarat.name}').datetimepicker();
    $('select[name="{$SelPozicio.name}[]"]').multiselect().multiselectfilter();
    $('select[name="{$SelSorrend.name}[]"]').multiselect().multiselectfilter();
    $('select[name="{$SelOldal.name}[]"]').multiselect().multiselectfilter();
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_24">
		<div class="box_top">
        	<h2 class="icon time">Banner - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
		</div>
        <div class="box_content padding"> 
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'} 
            <div class="field">
                <div class="form_row">
					<label for="{$TxtNev.name}">Megnevezés <span class="require">*</span></label>
					<input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
					{if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if} 
				</div><div class="clear"></div>
				<div class="form_row">
					<label for="{$TxtLink.name}">Link <span class="require">*</span></label>
					<input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}"/>
					{if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if} 
				</div><div class="clear"></div>
				<div class="form_row">
					<label for="{$TxtKod.name}">Kód <span class="require">*</span></label>
					<textarea id="{$TxtKod.name}" name="{$TxtKod.name}">{$TxtKod.activ}</textarea>
					{if isset($TxtKod.error)}<p class="error small">{$TxtKod.error}</p>{/if} 
				</div><div class="clear"></div>
				<div class="form_row">
					<label for="{$File.name}">Kép <span class="require">*</span></label>
					<input type="file" name="{$File.name}" id="{$File.name}" value="" style="width:300px;"/>
					{if isset($File.error)}<p class="error small">{$File.error}</p>{/if} 
					<br />
					<span class="info">Maximum: {$kep_max_size}</span>
				</div><div class="clear"></div>
                {if $banner_kep_nev}
                    <div class="form_row">
						<label>
							<button title="Kép törlése" id="{$BtnDeleteFile}" name="{$BtnDeleteFile}" value="{$banner_kep_nev}" onclick="return confirmBox('{$BtnDeleteFile}', '{php}echo LANG_Cnfr_DeletePicTitle;{/php}', '{php}echo LANG_Cnfr_DeletePic;{/php}');">
								<span class="ui-icon ui-icon-circle-close">Kép törlése</span>
							</button>
						</label>
                        <img class="form-pic" src="{$DOMAIN}pic/{$APP_PATH}/{$banner_kep_nev}_75x75"/>
					</div><div class="clear"></div>
                {/if}
				<div class="form_row">                         
                    <label for="{$SelOldal.name}">Oldal <span class="require">*</span></label>
                    {html_options multiple name=$SelOldal.name options=$SelOldal.values selected=$SelOldal.activ}
					{if isset($SelOldal.error)}<p class="error small">{$SelOldal.error}</p>{/if}
				</div><div class="clear"></div>
				<div class="form_row">                          
                    <label for="{$SelPozicio.name}">Pozíció <span class="require">*</span></label>
                    {html_options name=$SelPozicio.name options=$SelPozicio.values selected=$SelPozicio.activ}
					{if isset($SelPozicio.error)}<p class="error small">{$SelPozicio.error}</p>{/if}
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
                    <label for="{$SelSorrend.name}">Sorrend <span class="require">*</span></label>
                    {html_options name=$SelSorrend.name options=$SelSorrend.values selected=$SelSorrend.activ}
					{if isset($SelSorrend.error)}<p class="error small">{$SelSorrend.error}</p>{/if}
				</div><div class="clear"></div>                                                                  
                <div class="form_row">
					<label>Publikus</label>
					{html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
					{if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
				</div><div class="clear"></div>
                <div class="form_row">
					<label>Munkaadói oldal</label>
					{html_radios name=$ChkMunkaAdo.name options=$ChkMunkaAdo.values selected=$ChkMunkaAdo.activ}
					{if isset($ChkMunkaAdo.error)}<p class="error small">{$ChkMunkaAdo.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
        </div>
	</div>
</form>