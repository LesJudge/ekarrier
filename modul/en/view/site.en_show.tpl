<script type="text/javascript">
$(document).ready(function(){
	
	tabPager=new siteTabPager();
	tabPager.start();
	
	$(".siteTabNext").click(function(){
	  tabPager.next($(this));
	});
	$(".siteTabBack").click(function(){
	  tabPager.prev($(this));
	});
	$(".siteTab-bredcrumb").click(function(){
	  tabPager.toSlide($(this));
	});	 
	
	/*
    {if $myPositionTestResult[0].pont}
        var result = {$myPositionTestResult[0].pont};    
        $( "#slider-vertical" ).slider({
          orientation: "vertical",
          range: false,
          disabled: true,
          min: 0,
          max: 18,
          value: result
        });
    {/if}
	*/
});
</script>
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




<div class="tabBreadcrumb-cont">			
	<div class="tabBreadcrumb_cover"></div>
	<div class="tabBreadcrumb">
		<a class="btn btn-sm btn-primary" href="{$DOMAIN}uzeneteim/">Üzeneteim {if $newMessage > 0}({$newMessage} új){/if}</a>
	</div>		
</div>	      
<div class="contentDataCont">	
	<div class="siteTabNext"><a href="javascript:;" class="btn btn-default">Tovább</a></div><div class="siteTabNext_cover"></div>                   
	<div class="siteTabBack"><a href="javascript:;" class="btn btn-default">Vissza</a></div><div class="siteTabBack_cover"></div>   
	<div class="contentData-bg">                                     
		<div class="contentData">
			<div class="siteTabContainer">					
				<div class="siteTab" siteTab-bredcrumb="Adatlapom">
					<div class="col-data-3">{$text1}</div>
				</div>
				<div class="siteTab" siteTab-bredcrumb="Tevékenységi körök">		
					<div class="col-data-3">
						<br/>	 					
						{if not empty($myTevkorok)}			
							{foreach from=$myTevkorok item=tevkor} 					  
								<div class="row box-block-1">
									<div class="col-lg-20">
										<div class="designedText-1">{$tevkor.nev} - {$tevkor.datum} </div>
									</div>
									<div class="col-lg-4"><a href="{$DOMAIN}tevekenysegikor/{$tevkor.link}" class="btn btn-primary btn-sm pull-right">Megtekintés</a>
										<div class="clear"></div>																
									</div>
									<div class="clear"></div>		
								</div>	
							{/foreach}
						{else}
							<div class="alert alert-info">Még nincs megjelölt tevékenységi kör!</div>
						{/if}
					</div>
				</div>
				<div class="siteTab" siteTab-bredcrumb="Álláshirdetések">	
					<div class="col-data-3">
						<br/>	 						
						{if not empty($myMarkedJobs)}			
							{foreach from=$myMarkedJobs item=job} 		  
								<div class="row box-block-1">
									<div class="col-lg-20">
										<div class="designedText-1">{$job.mkNev} - {$job.cegNev}- {$job.datum}</div>
									</div>
									<div class="col-lg-4"><a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.ID}/" class="btn btn-primary btn-sm pull-right">Megtekintés</a>
										<div class="clear"></div>																
									</div>
									<div class="clear"></div>		
								</div>	
							{/foreach}
						{else}
							<div class="alert alert-info">Még nincs megjelölt álláshirdetés!</div>
						{/if}
					</div>	
				</div>
				<div class="siteTab" siteTab-bredcrumb="Kedvenc Álláshírdetések">
					<div class="col-data-3">	
						<br/>					
						{if not empty($myFavouriteJobs)}
							{foreach from=$myFavouriteJobs item=job}	  
								<div class="row box-block-1">
									<div class="col-lg-20">
										<div class="designedText-1">{$job.allasNev} - {$job.cegNev} - {$job.datum}</div>
									</div>
									<div class="col-lg-4"><a href="{$DOMAIN}allashirdetes/{$job.allasLink}/{$job.allasID}/" class="btn btn-primary btn-sm pull-right">Megtekintés</a>
										<div class="clear"></div>																
									</div>
									<div class="clear"></div>		
								</div>	
							{/foreach}
						{else}
							<div class="alert alert-info">Még nincs kedvencként megjelölt álláshirdetés!</div>
						{/if}
					</div>	
				</div>
				<div class="siteTab" siteTab-bredcrumb="Kompetenciarajzaim">		
					<div class="col-data-3">
						<br/>				
						{if not empty($myCompDraws)}
							{foreach from=$myCompDraws item=draw}  
								<div class="row box-block-1">
									<div class="col-lg-20">
										<div class="designedText-1">{$draw.nev}</div>
									</div>
									<div class="col-lg-4"><a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$draw.ID}/" class="btn btn-primary btn-sm pull-right">Megtekintés</a>
										<div class="clear"></div>																
									</div>
									<div class="clear"></div>		
								</div>	
							{/foreach}
						{else}
							<div class="alert alert-info">Még nincs elkészítve kompetenciarajz!</div>
						{/if}
					</div>	
				</div>
				<div class="siteTab" siteTab-bredcrumb="Kompetenciáim">		
					<div class="col-data-3">
						<br/>				
						{if not empty($myComps)}
							{foreach from=$myComps item=comp} 
								<div class="row box-block-1">
									<div class="col-lg-20">
										<div class="designedText-1">{$comp.kompetencia_nev}</div>
									</div>
									<div class="col-lg-4">
										<a href="{$DOMAIN}kompetenciak/{$comp.kompetencia_link}" class="btn btn-primary btn-sm pull-right">Megtekintés</a>
										<div class="clear"></div>			
										<span class="itemActive-{if $comp.ugyfel_attr_kompetencia_tesztbol=="1"}1{else}0{/if}"><i class="itemActive-i"></i>{if $comp.ugyfel_attr_kompetencia_tesztbol=="1"}Tesztből{else}Programból{/if}</span>															
									</div>
									<div class="clear"></div>		
								</div>	
							{/foreach}
						{else}
							<div class="alert alert-info">Még nincs felvéve kompetencia!</div>
						{/if}
					</div>	
				</div>
				<div class="siteTab" siteTab-bredcrumb="Szektorteszt eredmény">	
					<div class="col-data-3">
						<br/>					
						{if not empty($mySectorTestResult)}
							{foreach from=$mySectorTestResult item=result} 
								<div class="row box-block-1">
									<div class="col-lg-20">
										<div class="designedText-1">{$result.szektorNev}</div>
									</div>
									<div class="col-lg-4">									
										 <form method="post" action="{$DOMAIN}szektorteszt/">
											<input type="hidden" name="view" value="1">
											<input type="hidden" name="finalResults" value="{$result.eredmeny}">
											<button type="submit"  class="btn btn-primary btn-sm pull-right">Eredmény megtekintése</button>
										</form>									
										<div class="clear"></div>			
									</div>
									<div class="clear"></div>		
								</div>	
							{/foreach}
						{else}
							<div class="alert alert-info">Nincs pozícióteszt eredmény!</div>
						{/if}
					</div>	
				</div>
				<div class="siteTab" siteTab-bredcrumb="Pozíció eredmény">	
					<div class="col-data-3">
						<br/>					
						{if not empty($mySectorTestResult)}						
								<div class="row box-block-1">
									<div class="col-lg-20">
										<div class="designedText-1">
										{if $myPositionTestResult[0].pont >= 9 && $myPositionTestResult[0].pont <= 18}
											Vezető
										 {elseif $myPositionTestResult[0].pont < 9 && $myPositionTestResult[0].pont >= 0}
											Alkalmazott
										 {/if}
										</div>
									</div>
									<div class="col-lg-4">									
										<form method="post" action="{$DOMAIN}pozicioteszt/">
											<input type="hidden" name="view" value="1">
											<input type="hidden" name="result" value='{$myPositionTestResult[0].eredmeny}'>
											<button type="submit"  class="btn btn-primary btn-sm pull-right">Eredmény megtekintése</button>
										</form>							
										<div class="clear"></div>			
									</div>
									<div class="clear"></div>		
								</div>
								<div id="slider-vertical" style="height:200px; float:left; margin-top: 25px;"></div>						
						{else}
							<div class="alert alert-info">Nincs pozícióteszt eredmény!</div>
						{/if}
					</div>	
				</div>
				<div class="siteTab" siteTab-bredcrumb="Statisztikáim">	
					<div class="col-data-3">
						<br/>					
						{if $compRajzViewsAll > 0}		
							<div class="row box-block-1">								
								<div class="designedText-1">
								 Összesen {$compRajzViewsAll} tekintette meg kompetenciarajzaimat!
								</div>															
								<div class="clear"></div>		
							</div>
						{else}
						{/if}
						{if not empty($compRajzViews)}
							{foreach from=$compRajzViews key=key item=view}
							<div class="row box-block-1">								
								<div class="designedText-1">
								 {$view} Munkáltató tekintette meg a "{$key}" nevű kompetenciarajzomat
								</div>															
								<div class="clear"></div>		
							</div>
							{/foreach}
						{else}
							<div class="alert alert-info">Nincs megjeleníthető statisztika!</div>
						{/if}
						{if not empty($tevkorStats)}
							{foreach from=$tevkorStats key=key item=stat}   
							<div class="row box-block-1">								
								<div class="designedText-1">
								 A(z) {$stat.nev} tevékenységi körhöz {$stat.ahDB} db álláshirdetés tartozik {if $stat.uj > 0} ({$stat.uj} új) {/if}
								</div>															
								<div class="clear"></div>		
							</div>
							{/foreach}
						{else}
							<div class="alert alert-info">Nincs megjeleníthető statisztika!</div>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>		

<div class="clear"></div>
<br/>		
				
				
