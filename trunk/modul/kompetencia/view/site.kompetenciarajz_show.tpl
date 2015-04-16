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


<div>{$text}</div>

<div class="jobFindList-cont">
	<div class="jobFindList-data">	
		<ul id="myComps" class='sortable2 sortedUL'>
			{foreach from=$compRajzCompetences item=val}
			<li class='fixed'>
				<div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
				<div class='myComp'>{$val['kompetencia_nev']}</div>			
				<div class="clear"></div>
				<div>
                                {$val['valasz']}
				</div>				
			</li>
			{/foreach}
		</ul>	
	</div>
	<div class="clear"></div>
</div> 

<form id="compDraw" name="compDraw" action="" method="post">
    {if $loggedInAs == 'company'}
        <label for="folders">Mappa <span class="require">*</span></label>
            <select id="folders" name="folders">
                {foreach from=$folders item=folder key=key}
                    <option value="{$key}">{$folder}</option>
                {/foreach}
            </select>
        <button class="submit btn" name="{$BtnAddDraw}" type="submit">Hozzáadás</button>
        <input type="text" name="folderName">
        <button class="submit btn" name="{$BtnCreateFolder}" type="submit">Mappa létrehozása</button>
        
        <a class="btn btn-sm btn-primary" href="{$DOMAIN}kompetenciarajz-kereso/">Vissza</a>
    {/if}   
</form>

