<style type="text/css">
.form-row input, .select-cont {
    width: 380px !important;
}
.jobFindList-name-anchor {
    cursor: pointer;
    float: none !important;
}

</style>
        <form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_editor" enctype="multipart/form-data">
             
                                <div class="form-row">
                                        <label for="{$FilterSzuro.name}">Név</label>
                                        <input id="{$FilterSzuro.name}" name="{$FilterSzuro.name}" type="text" value="{$FilterSzuro.activ}" />
                                </div><div class="clear"></div>

                                <div class="form-row">
                                        <label for="{$FilterCity.name}">Város</label>
                                        <input id="{$FilterCity.name}" name="{$FilterCity.name}" type="text" value="{$FilterCity.activ}" />
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                    <label for="{$FilterSector.name}">Szektor</label>
                                    {html_options name=$FilterSector.name options=$FilterSector.values selected=$FilterSector.activ} 
				</div><div class="clear"></div>
                                
                                <div class="form_row">
                                    <label for="{$FilterMunkakor.name}">Munkakör</label>
                                    {html_options name=$FilterMunkakor.name options=$FilterMunkakor.values selected=$FilterMunkakor.activ} 
				</div><div class="clear"></div>
                                
                                <div class="form-row">
										<label>&nbsp;</label>
                                        <button id="{$BtnFilter}" name="{$BtnFilter}" value="Filter" class="submit" style="float:left; margin-right:10px;">Szűrés</button>
                                        <button id="{$BtnFilterDEL}" name="{$BtnFilterDEL}" value="Clear"  class="submit" style="float:left;">Alaphelyzet</button>
                                </div><div class="clear"></div>
                  </form>       
        
        
                        
                        {include file='page/all/view/page.message.tpl'}

                        {if $Lista}
                       <div class="jobFindList-cont">
							<div class="jobFindList-top"><i id='jobFindList_icon--factory--48--48--S1.4,1.4,0,0--fff--fff' class='svgIcon'>&nbsp;</i></div>
							<div class="jobFindList-title">A keresési feltételeknek megfelelő találati eredmények</div>
							{foreach from=$Lista key=for_id item=company name=company}
							<div class="jobFindList-block">
								<div class="jobFindList-name">
                                                                        <a class="jobFindList-name-anchor" href="{$DOMAIN}munkaltato/{$company.link}">{$company.nev} </a>
									<a href="{$DOMAIN}munkaltato/{$company.link}" class="iconCont" title="Megtekintés"><i id='jobFindListEditBtn_{$smarty.foreach.company.index}--edit--24--24--S0.7:0.7:0:0--000--000' class='svgIcon'>&nbsp;</i></a>
									<div class="clear"></div>
								</div>
								<div class="jobFindList-content">{$company.tartalom}</div>			
								<div class="clear"></div>
							</div>
							{/foreach}
							<div class="clear"></div>
						</div>
						{include file='page/all/view/page.paging.tpl'} 
                        {/if}
              
