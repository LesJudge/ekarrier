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

<div>{$pj.ismerteto}</div>
<div>{$pj.elvarasok}</div>
<div>{$pj.tevekenyseg}</div>

{if $markable}
<form name="{$FormName}" action="{$formUrl}" method="post" enctype="multipart/form-data">
    <input id="postingJobId" name="postingJobId" type="hidden" value="{$pjId}" />
    <button name="{if $isMarked}{$BtnUnmark}{else}{$BtnMark}{/if}" type="submit" value="1">{$markItText}</button>
</form>
{/if}