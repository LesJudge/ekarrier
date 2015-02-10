<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    {include file='page/all/view/page.message.tpl'}
    <div class="jobFindList-cont">
        <div class="jobFindList-top">
            <i class='icomoon icomoon-file3'>&nbsp;</i>
        </div>
        {if $editMode == "1"}
        <div class="jobFindList-title">
            <a href="{$DOMAIN}ceg/allashirdetes/szerkesztes/" class="bigBtn-link">Új álláshirdetés</a>
        </div>
        {/if}
        <br />
        {if $Lista}
			<table class="DTable">
				<tr class="DTable-head">
					<th class="textAlign-center">Megnevezés</th>
					<th class="textAlign-center">Szektor</th>
					<th class="textAlign-center">Pozíció</th>					
					{if $editMode == "1"}<th class="textAlign-center">Szerkeszt</th>{/if}
                                        {if $editMode == "0"}<th class="textAlign-center">Megjelölve</th>{/if}
				</tr>				
				{foreach from=$Lista item=job name=job}				
				<tr class="DTable-tr {if $job.allashirdetes_tartalom} DTable-tr-noBottomBorder {/if}">
					<td class="textHighlighting-1"> {$job.megnevezes}</td>
					<td class="textAlign-center"> {$job.szektor_nev}</td>					
					<td class="textAlign-center">{$job.pozicio_nev}</td>
					{if $editMode == "1"}<td class="textAlign-center"><a href="{$DOMAIN}ceg/allashirdetes/szerkesztes/{$job.allashirdetes_id}" class="iconCont" title="Szerkesztés"><i class='icomoon icomoon-pencil'>&nbsp;</i></a></td>	
                                        {/if}
                                        {if $editMode == "0"}<td class="textAlign-center"><a href="" class="iconCont" title="Szerkesztés">{$job.megjelolesDB}</a></td>	
                                        {/if}
                                </tr>	
				{if $job.allashirdetes_tartalom}			
				<tr class="DTable-tr">
					<td colspan="4"> {$job.allashirdetes_tartalom} </td>
				</tr>	
				{/if}			
				{/foreach}
			</table>		
        {/if}
        <div class="clear"></div>
    </div> 
    {include file='page/all/view/page.paging.tpl'} 
</form>
