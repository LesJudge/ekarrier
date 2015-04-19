<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/admin/add_tinymce_mini.js"></script>

<a onClick="$('#compEditorCont').toggle();" href="javascript:;" class="btn btn-primary">Írj hozzá!</a>

<div id="compEditorCont" style="display:none">
	<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title">Tartalom</div>
	<div class="jobFindList-cont jobFindList-cont-2">   
		
			<form action="" method="post" name="{$FormName}" id="{$FormName}">
				<div class="form-row">	
					<textarea id="compComment" name="compComment" class="tinymce">{$content}</textarea>				
				</div>
				<div class="form-row textAlign-center" style="margin:0.5em 0;">					
					<button class="btn btn-md btn-primary" name="{$BtnAddCompComment}" id="{$BtnAddCompComment}" type="submit">Beküld</button>
				</div><div class="clear"></div>
			</form>
				
	</div>
</div>			
         
            
{if not empty($compComments)}
{foreach from=$compComments item=compComment}    

    <div>{$compComment.bekuldve} - {$compComment.nev}</div>
    <div>{$compComment.text}</div>

{/foreach}

{else}
<div class="no-content">Még senki nem írt hozzá!</div>
{/if}
