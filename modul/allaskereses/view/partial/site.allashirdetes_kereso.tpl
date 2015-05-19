
<div class="jobFindList-title-cont"><div class="jobFindList-title">Munkakör kereső</div></div>
<div class="jobDataForm-cont">
        
		<div class="filter_row_cont">
			<div class="filter_row">		
			{html_options name=$FilterSector.name id=$FilterSector.name options=$FilterSector.values selected=$FilterSector.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
					
			<div class="filter_row">		
			{html_options name=$FilterPosition.name id=$FilterPosition.name options=$FilterPosition.values selected=$FilterPosition.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
				   
			<div class="filter_row">		
			{html_options name=$FilterJob.name id=$FilterJob.name options=$FilterJob.values selected=$FilterJob.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
					
			<div class="filter_row">		
			{html_options name=$FilterCounty.name id=$FilterCounty.name options=$FilterCounty.values selected=$FilterCounty.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
    	</div>  
		 
        <span class="size-1"><input type="text" name="{$FilterCity.name}" value="{$FilterCity.activ}" autocomplete="off" placeholder="Város" /></span>
		<button class="btn btn-danger" type="submit" name="{$BtnFilterDEL}" value="Feltételek törlése"><i class="icomoon icomoon-remove2"></i></button>                   
        <input class="submit btn-1" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="Keres" />
        
        <div class="clear"></div>
    </div>

</div>