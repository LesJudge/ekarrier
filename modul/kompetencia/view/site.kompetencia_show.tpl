<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>

{if $FormError}
 <div class="info info-error">
    <p><img src="images/site/form-error.png" style="float:left; margin:5px;"/>{$FormError}</p>
</div> 
<div class="clear"></div>
{/if}
{if $FormMessage}
<div id="form_info" class="info info-success">
    <p>{$FormMessage}</p>
</div>
<div class="clear"></div>
{/if}

<style type="text/css">
.h1-table { display:none; }
.h1-table.visible { display:table;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="h1-table visible">
	<tr>
	<td class="h1-td">&nbsp;</td>
	<td class="h1-td-center"><h1>{$competence.kompetencia_nev}</h1></td>
	<td class="h1-td">&nbsp;</td>
	</tr>
</table>	
<div class="text-type-1">{$competence.kompetencia_create_date}</div>
<br />
{$competence.kompetencia_tartalom}

<div class="btn-nav-row">
	<div class="btn btn-primary btn-md" onClick="$('#EditorCont').toggle();">Írj hozzá!</div>
	<div id="EditorCont" style="display:none">
        <form action="" method="post" name="{$FormName}" id="{$FormName}">
            <div class="form-row">
				<label for="comment">Tartalom <span class="require">*</span></label>
				<textarea id="comment" name="comment" class="tinymce"></textarea>
			</div><div class="clear"></div>
			
			<div class="form-row" style="margin-top:5px;">					
				<button class="btn btn-primary btn-md pull-right" name="{$BtnAddComment}" id="{$BtnAddComment}" type="submit">Beküld</button>
			</div><div class="clear"></div>
        </form>  
	</div>    
</div>    
    
    
{if not empty($comments)}
{foreach from=$comments item=comment}    
<div class="commentItem">
	<div class="commentItem-name">{$comment.nev}</div>
	<div class="commentItem-date">{$comment.bekuldve}</div>
	<div class="commentItem-text">{$comment.text}</div>
</div>
{/foreach}
{else}
<div class="alert alert-info">Még senki nem írt hozzá!</div>
{/if}

{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}
