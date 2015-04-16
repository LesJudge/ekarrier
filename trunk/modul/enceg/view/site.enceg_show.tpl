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

<div onclick="$('#picFormCont').toggle();">Munkáltatói PROFILKÉP feltöltése</div>
<div id="picFormCont" style="display:none">
    <form name="" action="" method="post" enctype="multipart/form-data">              
        <div class="form_row">
            <label for="{$File.name}">Kép:&nbsp;</label>
            <input type="file" name="{$File.name}" id="{$File.name}" value="" style="width:300px;"/>
            {if isset($File.error)}
                <p class="error small">{$File.error}</p>
            {/if} 
            <br />
        </div>
        <button class="submit btn" name="{$BtnUploadPic}" type="submit">Kép feltöltése</button>
    </form>
</div>
<img src="{$DOMAIN}pic/{$APP_PATH}/{$companyData.ceg_kep}_380x265_2"/>  

<div onclick="$('#descriptionFormCont').toggle();">Cég leírásának szerkesztése</div>
<div id="descriptionFormCont" style="display:none">
    <form name="" action="" method="post">              
        <div class="form_row">
            <textarea name="companyDescription" id="companyDescription" class="tinymce">{$companyData.tartalom}</textarea>
        </div>
        <button class="submit btn" name="{$BtnUpdateDescription}" type="submit">Kész</button>
    </form>
</div>


    
{foreach from=$myJobs item=job}
    <a href="{$DOMAIN}allashirdetes/{$job.link}/{$job.ahID}/">{$job.munkakor} - {$job.subCat} - {$job.mainCat}</a><br/>
{/foreach}

{*foreach from=$myJobs item=job key=key}
    {$job.munkakor} - {$job.markerCnt} fő<br/>
{/foreach*}

{foreach from=$myJobs item=job key=key}
    <div id="folder1_{$key}" onclick="$('#clientsCont1_{$key}').toggle();">{$job.munkakor} - {$job.markerCnt} fő</div>
    <div id="clientsCont1_{$key}" style="display:none">
    {foreach from=$job.ugyfelek item=ugyfel}
            {if $ugyfel}
                <a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/">{$ugyfel.uID}/{$ugyfel.krID}</a>
                <br/>
            {/if}
    {/foreach}
    </div>
    <br/>
{/foreach}

<a class="btn btn-sm btn-primary" href="{$DOMAIN}ceg/profil/">Regisztrációs adatok módosítása</a>
<a class="btn btn-sm btn-primary" href="{$DOMAIN}munkaltato/{$companyData.link}">Ezt látja rólam az álláskereső</a>

<br/>

{foreach from=$myFolders item=folder key=key}
    <div id="folder_{$key}" onclick="$('#clientsCont_{$key}').toggle();">{$folder.mappaNev}</div>
    <div id="clientsCont_{$key}" style="display:none">
    {foreach from=$folder.ugyfelek item=ugyfel}
            {if $ugyfel}
                <a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$ugyfel.krID}/">{$ugyfel.uID}/{$ugyfel.krID}</a>
                <br/>
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
{if $stat|is_array || $activeClientsSum > 0}
    {$stat.ah}<br/>
    {$stat.profil}<br/>
    <div id="slider-vertical" style="height:200px; float:left; margin-top: 25px;"></div>
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
    var result = {$stat.ah + $stat.profil};
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
