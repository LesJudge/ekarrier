<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}

	jQuery.each($(".tinymce"), function() {
        tinyMCE.init({ mode : "exact", elements : this.id, theme : "advanced", skin : "o2k7", skin_variant : "silver", language : "hu", theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom", gecko_spellcheck : "true", plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
    	theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,link,unlink,forecolor,backcolor,cleanup,|",    	
		theme_advanced_resizing : true,			
		document_base_url : $("#DOMAIN").val(),			
		width : "630",  
		height : "300", 
		paste_auto_cleanup_on_paste : true, 
		plugin_preview_width : "1000", 
		theme_advanced_resize_horizontal : false,
        theme_advanced_path : false,theme_advanced_statusbar_location : 0,
		});
    });
	
	
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
	<br/><br/>	 			
	<div class="tabBreadcrumb_cover"></div>
	<div class="tabBreadcrumb">
		<img src="{$DOMAIN}pic/{$APP_PATH}/{$companyData.ceg_kep}_380x265_2" class="tabBreadcrumb-profilImg"/>
	</div>		
</div>	      
<div class="contentDataCont">	
	<div class="siteTabNext"><a href="javascript:;" class="btn btn-default">Tovább</a></div><div class="siteTabNext_cover"></div>                   
	<div class="siteTabBack"><a href="javascript:;" class="btn btn-default">Vissza</a></div><div class="siteTabBack_cover"></div>   
	<div class="contentData-bg">                                     
		<div class="contentData">
			<div class="siteTabContainer">					
				<div class="siteTab" siteTab-bredcrumb="Cégleírás">
					<form name="" action="" method="post">              
						<div class="form-row">
							<textarea name="companyDescription" id="companyDescription" class="tinymce">{$companyData.tartalom}</textarea>
						</div>
						<div class="form-row">
							<br/>
							<button class="btn btn-primary btn-md" name="{$BtnUpdateDescription}" type="submit">Mentés</button>
						</div>
					</form>
				</div>
				<div class="siteTab" siteTab-bredcrumb="Cégprofil" siteTab-bredCumbHref="{$DOMAIN}ceg/profil/"></div>
				<div class="siteTab" siteTab-bredcrumb="Adatok" siteTab-bredCumbHref="{$DOMAIN}munkaltato/{$companyData.link}"></div>							
				<div class="siteTab" siteTab-bredcrumb="Profilkép">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-data-3">
								<img src="{$DOMAIN}pic/{$APP_PATH}/{$companyData.ceg_kep}_380x265_2" class="img-responsive"/> 			
							</div>
						</div>
						<div class="col-lg-12">
							<div class="col-data-3">		
								<form name="" action="" method="post" enctype="multipart/form-data">              
									<div class="form-row">
										<div class="text-type-2" for="{$File.name}">Kép:&nbsp;</div>
										<input type="file" name="{$File.name}" id="{$File.name}" value="" />
										{if isset($File.error)}
											<p class="error small">{$File.error}</p>
										{/if} 
										<br />
									</div>
									<div class="form-row">
										<button class="btn btn-primary btn-md" name="{$BtnUploadPic}" type="submit">Kép feltöltése</button>
									</div>
								</form>							
							</div>
						</div>	
						<div class="clear"></div>
					</div>	
				</div>
				<div class="siteTab" siteTab-bredcrumb="Álláshírdetéseim">					
					{foreach from=$myJobs item=job}
					   {*$activ = true}	{$helyseg = 'Debrecen'*} 
						<div class="row box-block-1">
							<div class="col-lg-20">
								<a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.ahID}/" class="designedText-1">{$job.munkakor} - {$job.subCat} - {$job.mainCat} </a><br/>
                                                                {$job.varos}
							</div>
							<div class="col-lg-4"><a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.ahID}/" class="btn btn-primary btn-sm pull-right">Megtekintés</a>
								<div class="clear"></div>
								<span class="itemActive-{if $job.aktiv=='true'}1{else}0{/if}"><i class="itemActive-i"></i>{if $job.aktiv=='true'}Aktív{else}Passzív{/if}</span>								
							</div>
							<div class="clear"></div>		
						</div>	
					{/foreach}
				</div>
				<div class="siteTab" siteTab-bredcrumb="Mappáim">
					{foreach from=$myFolders item=folder key=key}						
						<div id="folder_{$key}" class="folderItem" onclick="$('#clientsCont_{$key}').toggle();">
							<div class="folderItem-label">{$folder.mappaNev}</div>		
							<div class="clear"></div>									
						</div>						
						<div id="clientsCont_{$key}" style="display:none" class="folderItem-content">
						{foreach from=$folder.ugyfelek item=ugyfel}
								{if $ugyfel}
									<div class="folderItem-sub">		
										<a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/" class="folderItem-sub-map">{$ugyfel.uID}/{$ugyfel.krID}</a>
									</div>
								{/if}
						{/foreach}
						</div>
						<br/>
					{/foreach}
					<!-- Majd, ha kell kivesszük
					<form id="compDraws" name="compDraws" action="" method="post">        
							<input type="text" name="folderName">
							<button class="submit btn" name="{$BtnCreateFolder}" type="submit">Mappa létrehozása</button>
					</form>
					-->
				</div>
			    <div class="siteTab" siteTab-bredcrumb="Mentett kereséseim">					
					{*foreach from=$myJobs item=job key=key}
						{$job.munkakor} - {$job.markerCnt} fő<br/>
					{/foreach*}					
					{foreach from=$myJobs item=job key=key}
						<div id="folder1_{$key}" onclick="$('#clientsCont1_{$key}').toggle();" class="folderItem">
							<div class="folderItem-label">{$job.munkakor} - {$job.markerCnt} fő</div>		
							<div class="clear"></div>									
						</div>
						<div id="clientsCont1_{$key}" style="display:none" class="folderItem-content">
						{foreach from=$job.ugyfelek item=ugyfel}
								{if $ugyfel}
									<div class="folderItem-sub">
										<a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/" class="folderItem-sub-map">{$ugyfel.uID}/{$ugyfel.krID}</a>
									</div>
								{/if}
						{/foreach}
						</div>
						<br/>
					{/foreach}
				</div>	
								
			</div>
		</div>
	</div>	
</div>			
<div class="clear"></div>
<br/>

<!--
{if $stat|is_array || $activeClientsSum > 0}
    <div id="slider-vertical" style="height:400px; float:left; margin-top: 25px;"></div>
{/if}


<form id="statForm" name="statForm" action="" method="post">        
        <input type="text" name="startDate" id="startDate" value="{$startDate}">
        <input type="text" name="endDate" id="endDate" value="{$endDate}">
        {if $stat == 'Hiba' || $activeClientsSum == 'Hiba'}Hiba történt!{/if}
        <button class="submit btn" name="" type="submit">Kész</button>
</form>

<script type="text/javascript">
$(document).ready(function(){
    $('#startDate').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date('{$companyCreateDate}'),
        maxDate: +0,
        defaultDate: new Date('{$companyCreateDate}')
    });
    
    $('#endDate').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date('{$companyCreateDate}'),
        maxDate: +0,
        defaultDate: +0
    });
    
{if $stat|is_array && $activeClientsSum > 0}
    var maxValue = {$activeClientsSum};
    var result = {$stat|@count};
    $( "#slider-vertical" ).slider({
              orientation: "vertical",
              range: false,
              disabled: true,
              min: 0,
              max: maxValue,
              step: 1,
              value: result
            });
{/if}
    
});
</script>
-->