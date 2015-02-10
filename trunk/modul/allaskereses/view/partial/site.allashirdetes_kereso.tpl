<div class="jobDataForm-cont hiddenLabels">
    <div class="jobDataForm-top"><i class='icomoon icomoon-search'>&nbsp;</i></div>
    <div class="form-cell-1">
		<div>
			<label>Szektor</label>
			{html_options name=$FilterSector.name id=$FilterSector.name options=$FilterSector.values selected=$FilterSector.activ}
		</div>
		<div>
			<label>Pozíció</label>
			{html_options name=$FilterPosition.name id=$FilterPosition.name options=$FilterPosition.values selected=$FilterPosition.activ}
		</div>
	</div>
	<div class="form-cell-1">	
		<div>
			<label>Munkakör</label>
			{html_options name=$FilterJob.name id=$FilterJob.name options=$FilterJob.values selected=$FilterJob.activ}
		</div>
		<div>
			<label>Megye</label>
			{html_options name=$FilterCounty.name id=$FilterCounty.name options=$FilterCounty.values selected=$FilterCounty.activ}			
		</div>	
	</div>
	
    <div class="form-cell-1">	
		<div>
			<label for="{$FilterCity.name}">Város</label>    
			<input id="{$FilterCity.name}" name="{$FilterCity.name}" type="text" value="Város" alt="Város" class="labelInField"  />
		</div>
	</div>	
	<div class="form-cell-1">	    
		<!--<div class="clear"></div>-->
		<input type="submit" value="Keres" class="submit btn-1" />			
    </div>
    <div class="clear"></div>
	
</div>