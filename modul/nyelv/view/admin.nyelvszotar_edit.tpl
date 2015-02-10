<script type="text/javascript">
$(function() { {$FormScript}
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_24">
        <div class="box_top">
          	<h2 class="icon time">Nyelv szótár - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'}
		</div>
        <div class="box_content padding">
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'} 
            <div class="field">
				<div class="form_row">
					<label for="{$TxtAzon.name}">Azonosító <span class="require">*</span></label>
					<input type="text" id="{$TxtAzon.name}" name="{$TxtAzon.name}" value="{$TxtAzon.activ}" readonly="readonly"/>
					{if isset($TxtAzon.error)}<p class="error small">{$TxtAzon.error}</p>{/if}
				</div><div class="clear"></div>
				<div class="form_row">
					<label for="{$TxtSzo.name}">Szó <span class="require">*</span></label>
					<input type="text" id="{$TxtSzo.name}" name="{$TxtSzo.name}" value="{$TxtSzo.activ}"/>
					{if isset($TxtSzo.error)}<p class="error small">{$TxtSzo.error}</p>{/if}
				</div><div class="clear"></div>
                <div style="display:none;">
                <input type="text" id="{$TxtModul.name}" name="{$TxtModul.name}" value="{$TxtModul.activ}"/>
                </div>
			</div>
        </div>
    </div>
</form>