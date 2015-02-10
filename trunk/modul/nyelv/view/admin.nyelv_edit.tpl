<script type="text/javascript">
$(function() { {$FormScript}
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_24">
    	<div class="box_top">
            <h2 class="icon time">Nyelv - [{$edit_mode}]</h2>
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
					<label for="{$TxtAzon.name}">Rövidítés <span class="require">*</span></label>
					<input type="text" id="{$TxtAzon.name}" name="{$TxtAzon.name}" value="{$TxtAzon.activ}"/> 
					{if isset($TxtAzon.error)}<p class="error small">{$TxtAzon.error}</p>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<label for="{$File.name}">Zászló </label>
					<input type="file" name="{$File.name}" id="{$File.name}" value="" style="width:300px;"/>
					{if isset($File.error)}<p class="error small">{$File.error}</p>{/if}
					<span class="info">Maximum: {$kep_max_size}</span>
				</div><div class="clear"></div>
				{if $nyelv_zaszlo_nev}
					<div class="form_row">
						<label>
							<button title="Kép törlése" id="{$BtnDeleteFile}" name="{$BtnDeleteFile}" value="{$nyelv_zaszlo_nev}" onclick="return confirmBox('{$BtnDeleteFile}', '{php}echo LANG_Cnfr_DeletePicTitle;{/php}', '{php}echo LANG_Cnfr_DeletePic;{/php}');">
								<span class="ui-icon ui-icon-circle-close">Kép törlése</span>
							</button>
						</label>
						<img class="form-pic" src="{$DOMAIN}pic/{$APP_PATH}/{$nyelv_zaszlo_nev}_75x75"/>
					</div><div class="clear"></div>
				{/if}
				<div class="form_row">
					<label>Publikus</label>
					{html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
					{if isset($ChkAktiv.error)}<p class="error small">{$DateMegjelenes.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
        </div>
    </div>
</form>