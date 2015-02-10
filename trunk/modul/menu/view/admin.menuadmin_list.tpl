<script type="text/javascript" src="../js/jquery.ui.nestedSortable.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}
$("div.tabs").tabs({ cookie: { expires: 30 } });
	$('ol.tree').nestedSortable({
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: '.tree-icon',
			helper:	'clone',
			items: 'li',
			maxLevels: 30,
			opacity: .8,
			placeholder: 'ui-state-highlight',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div'
	});

	$('#{$BtnSave}').click(function(e){
		arraied = $('.ui-tabs-panel ol').nestedSortable('toArray', { startDepthCount: -1 });
		$.post(
			location.href+"?{$BtnSave}=1", 
			{ item: arraied },
			function(data) {
				location.reload();
			}
		);	
	})
});
</script>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
   	<div class="box_top">
		<h2 class="icon pages">Admin menü</h2>
		<ul class="sorting">
            <div class="form_muvelet">
            	<a><button type="button" class="submit tip" name="{$BtnSave}" id="{$BtnSave}" value="{php}echo LANG_AdminEdit_mentes;{/php}" title="{php}echo LANG_AdminEdit_mentes;{/php}"><img src="../images/admin/icons/save.png"/></button></a>
                <a href="{$DOMAIN_ADMIN}{$APP_LINK}/edit{$LANG_PARAM}"  title="{php}echo LANG_AdminList_uj;{/php}"><span class="ui-button-text"><img src="../images/admin/icons/add_data.png"/></span></a>
            </div>
		</ul>
	</div>
    <div class="box_content">    
        {include file='page/admin/view/admin.message.tpl'}
        <div class="tabs">
			{$kategoriaTabs}
	        {$kategoriaList}
   		</div>	
    </div>
</form>