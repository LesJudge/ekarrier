<link type="text/css" rel="stylesheet" media="screen" href="../css/jquery.multiselect.css" />
<link type="text/css" rel="stylesheet" media="screen" href="../css/jquery.multiselect.filter.css" />
<script type="text/javascript" src="../js/admin/jquery.removeAccents.js"></script>
<script type="text/javascript" src="../js/jquery-multiselect/jquery.multiselect.min.js"></script>
<script type="text/javascript" src="../js/jquery-multiselect/jquery.multiselect.filter.min.js"></script>
<script type="text/javascript">
$(function() { {$FormScript} 
    $('select[name="{$SelDinamikusElem.name}[]"]').multiselect({  
        selectedList: 1,
        multiple: false,
        selectedText:""
    }).multiselectfilter();
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_24">
    	<div class="box_top">
			<h2 class="icon time">Site menü - [{$edit_mode}]</h2>
			{include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'}
		</div>
        <div class="box_content padding"> 
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'} 
        	<div class="field">
                {if !isset($no_view_parent)}
                	<div class="form_row">
						<label for="{$SelParent.name}">Menü</label>
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
					<label for="{$TxtCim.name}">Név</label>
					<input type="text" id="{$TxtCim.name}" name="{$TxtCim.name}" value="{$TxtCim.activ}"/>
					{if isset($TxtCim.error)}<p class="error small">{$TxtCim.error}</p>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<label for="{$TxtLink.name}">Link</label>
					<input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}"/>
					{if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<label for="{$SelDinamikusElem.name}">Dinamikus elemek</label>
					{html_options multiple name=$SelDinamikusElem.name options=$SelDinamikusElem.values selected=$SelDinamikusElem.activ}
					{if isset($SelDinamikusElem.error)}<p class="error small">{$SelDinamikusElem.error}</p>{/if}
				</div><div class="clear"></div> 
				<div class="form_row">
					<label for="{$SelGroup.name}">Jog csoport</label>
					{html_options name=$SelGroup.name options=$SelGroup.values selected=$SelGroup.activ} <span class="ui-icon ui-icon-info tip" title="Milyen csoportba tartozó külső oldali felhasználók láthatják ezt a menüt."></span> 
					{if isset($SelGroup.error)}<p class="error small">{$SelGroup.error}</p>{/if}
				</div><div class="clear"></div> 
				<div class="form_row">
					<label>Megjelenik</label>
					{html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
					{if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
        </div>
    </div>
</form>