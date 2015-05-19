<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>
<style type="text/css">
.h1-table { display:none; }
</style>
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

<div class="head-title-1">{$competence.kompetencia_nev} <div class="head-title-1-sub">{$competence.kompetencia_create_date}</div></div>	
{$competence.kompetencia_tartalom}
<div class="clear"></div>
<br />


<div onClick="$('#EditorCont').toggle();">Írj hozzá!</div>
<div id="EditorCont" style="display:none">
        <form action="" method="post" name="{$FormName}" id="{$FormName}">
            <div class="form-row">
                                        <label for="comment">Tartalom <span class="require">*</span></label>
                                        <textarea id="comment" name="comment" class="tinymce"></textarea>
                        </div><div class="clear"></div>

                        <div class="form-row">
                                        <label>&nbsp;</label>
                                        <button class="submit btn" name="{$BtnAddComment}" id="{$BtnAddComment}" type="submit">Beküld</button>
                    </div><div class="clear"></div>
        </form>  
</div>    
    
    
    
    
{if not empty($comments)}
{foreach from=$comments item=comment}    
<div class="commentItem">
	<div class="commentItem-name">{$comment.nev}</div>
	<div class="commentItem-date">{$comment.bekuldve}</div>
	<div class="commentItem-text">{$comment.text}
		<a href="javascript:;" onClick="$('#EditorCont').toggle();" class="commentItem-next">válaszlolok <i class="glyphicon glyphicon-menu-right"></i></a>
	</div>
</div>
{/foreach}

{else}
Még senki nem írt hozzá!
{/if}

    
{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}
