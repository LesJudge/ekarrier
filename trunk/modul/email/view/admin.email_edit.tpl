<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}
tinymce.create('tinymce.plugins.example', { createControl: function(n, cm) { switch (n) {
                                        case 'mymenubutton': 
                                        var c = cm.createSplitButton('mymenubutton', { title : 'Változó beillesztése', image : '../images/admin/valtozo.gif' }); c.onRenderMenu.add(function(c, m) { var sub;
                                        {foreach from=$valtozok key=for_id item=lista}
											m.add({ title : '{$lista.nev}', onclick : function() { tinyMCE.activeEditor.execCommand('mceInsertContent', false, '&#123;${$lista.nev}&#125;'); }});                                        
          								{/foreach}
                                }); return c;
                } return null; }
    });
    tinymce.PluginManager.add('example', tinymce.plugins.example);
}); 
</script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_24">
    	<div class="box_top">
        	<h2 class="icon time">Rendszerüzenet - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
		</div>
        <div class="box_content padding">
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'} 
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
					<label for="{$TxtTartalom.name}">Tartalom <span class="require">*</span></label>
	                <textarea class="tinymce" id="{$TxtTartalom.name}" name="{$TxtTartalom.name}">{$TxtTartalom.activ}</textarea>
	                {if isset($TxtTartalom.error)}<p class="error small">{$TxtTartalom.error}</p>{/if} 
				</div>
                <div class="clear"></div>
            </div>
    	</div>
    </div>
</form>