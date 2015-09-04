<script type="text/javascript" src="{$DOMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<!--script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script-->
{if $FormError}
 <div class="info info-error">
    <p>{$FormError}</p>
</div> 
<div class="clear"></div>
{/if}
{if $FormMessage}
<div id="form_info" class="info info-success">
    <p>{$FormMessage}</p>
</div>
<div class="clear"></div>
{/if}

{include file='modul/kompetencia/view/partial/site.kompetencia_commonbuttons.tpl'}
<div class="clear"></div><br/>
<div>{$text}</div>

<div class="row">
	<a href="{$DOMAIN}kompetenciak/kompetenciarajz-keszites/" class="btn btn-md btn-default">Új kompetencia rajz</a>
	{if not empty($compRajzok)}		
		{foreach from=$compRajzok item=rajz}
			<a href="{$DOMAIN}kompetenciak/kompetenciarajz-keszites/{$rajz.ID}/" class="btn btn-md btn-primary">{$rajz.nev}</a>
		{/foreach}		
	{else}
		<div class="info info-success"><p>Nincs még kompetenciarajz</p></div>
	{/if}
</div>	
<br/>

<div class="compQuestion-cont">
	<div id="questionQuestion"><i class="icomoon icomoon-arrow-up"></i>Mindegyik kérdésre válaszolt?</div>
	<div class="clear"></div>
	<div id="q1" class="compQuestion">K1</div>
	<div id="q1Detailed" class="compQuestionDetailed">Melyik munkahelyen, milyen tevékenységen keresztül fejlesztette ezt a kompetenciáját?</div>
	<div class="clear"></div>
	<div id="q2" class="compQuestion">K2</div>
	<div id="q2Detailed" class="compQuestionDetailed">Milyen tanulmányok során mélyítette az ehhez kapcsolódó elméleti/szakmai tudását?</div>
	<div class="clear"></div>
	<div id="q3" class="compQuestion">K3</div>
	<div id="q3Detailed" class="compQuestionDetailed">Milyen társadalmi munka/hobbi/szabadidős tevékenységen keresztül fejlesztette?</div>
	<div class="clear"></div>
	<div id="q4" class="compQuestion">K4</div>
	<div id="q4Detailed" class="compQuestionDetailed">E kompetenciához kapcsolódó egyéb kiegészítő tudás, tapasztalat, élmény.</div>
	<div class="clear"></div>
</div>

<form id="compRajzForm" method="post">
<input type="text" name="CompRajzNev" id="CompRajzNev" value="{$compRajzNev}" style="width: 150px !important" />
<div id="ui-state-error"></div>
	{if $mode == "modify"}
	<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Kompetenciák kezelése</div><i class="write-icon"></i></div>
		<div class="jobDataForm-cont">
			<div class="compControl">
				<input type="hidden" name="CompRajzID" value="{$compRajzID}" />
				<button id='updateCompRajzSbmt' name="{$BtnUpdateCompRajz}" type="submit" class="btn btn-sm btn-default">Mentés</button>
				<button id='saveAsCompRajzSbmt' name="{$BtnSaveAsCompRajz}" type="submit" class="btn btn-sm btn-default">Mentés másként</button>
				<button id='deleteCompRajzSbmt' name="{$BtnDeleteCompRajz}" type="submit" class="btn btn-sm btn-default">Kompetenciarajz törlése</button>
				<button id='requestExpertOpinionSbmt' name="{$BtnRequestExpertOpinion}" type="submit" class="btn btn-sm btn-default">Szakértő véleménye!</button>
				<a class="btn btn-sm btn-default" href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$compRajzID}/">Megtekintés</a>
				<a class="btn btn-sm btn-default" href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$compRajzID}/?forceforeign=1">Ezt látja rólam a munkáltató</a>
				<a class="btn btn-sm btn-default" href="{$DOMAIN}tevekenysegikor-kereso/">Hasonló tevékenységi körbe postolók rajzának megtekintése</a>
			</div>  
		<div class="clear"></div>
	</div>	
	<br/>		
	{elseif $mode == "new"}
		<button id='saveCompRajzSbmt' name="{$BtnSaveCompRajz}" type="submit" class="btn btn-sm btn-primary">Mentés</button>    
	{/if}	
	
	
<div class="clear"></div>	
{foreach from=$compRajzCompetences item=val}	
	<div class='compCont'>
        <div class="jobFindList-title-cont">
			<div class="jobFindList-title">{$val['kompetencia_nev']}</div> 
			<a id='delButt_{$val['kompetencia_id']}' class="delButt iconCont" title="Töröl"><i class="del-icon"></i></a>
		</div>		
		<div class="jobFindList-cont jobFindList-cont-3">	
			<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title">Kompetencia általános leírása</div></div>
			<div class="jobFindList-cont jobFindList-cont-2">   
					<div class="padding-4">{$val['kompetencia_leiras']}</div>							
			</div>
			
			<div class="jobFindList-title-cont">
				<div class="jobFindList-title jobFindList-title">Kompetencia alátámasztása</div>
			</div>
			<div class="jobFindList-cont jobFindList-cont-2" style="margin:0;">   
					<!--
					<div id='myComp_{$val['kompetencia_id']}' class='myComp {if $val['user_attr_kompetencia_tesztbol']=="1"}fromTest{/if}'>{$val['kompetencia_nev']}</div>
					{if $val['user_attr_kompetencia_tesztbol']=="1"}<div class='myComp-test'></div>{/if}
					-->				
					<div class="clear"></div>
					<div class="form-row">	
						<input type="hidden" name="CompRajzKompetenciak[]" value="{$val['kompetencia_id']}"/>
						<textarea id="myComp_{$val['kompetencia_id']}_valasz" name="CompRajzValaszok[]" class="tinymce">{$val['valasz']}</textarea>				
					</div>						
			</div>
			
		</div>
   </div>
{/foreach}

</form>

<div><a href="{$DOMAIN}kompetenciak/kompetenciarajz/" class="btn btn-md btn-primary">Kompetencia hozzáadása</a></div>                
<br/>
{if $mode == "modify"}
    {if not empty($opinions)}
    <div class="jobFindList-title-cont"><div class="jobFindList-title">Szakértői vélemények</div></div>
    <div class="jobFindList-cont"> 
        {foreach from=$opinions item=opinion} 
            <div class="jobFindList-block">
                    <span class="jobFindList-item-type-1">{$opinion.valaszolo}</span> - {$opinion.valasz_date} 
                    {$opinion.velemeny}
                    <div class="clear"></div>
            </div>
            {/foreach}
    </div>	
    {else}    
            <div class="info info-success"><p>Nincs még szakértői vélemény</p></div>
    {/if}
{/if}
<div class="clear"></div>


<p><br/></p>	 
<a class="btn btn-lg btn-default pull-right" href="{$DOMAIN}uzeneteim/" style="margin-right:-10px;">Lépjen kapcsolatba szaktanácsadóinkkal!
<span class="btn-next-icon"><img src="images/site/next-bub-icon-1.png" alt="" /></span></a>
<div class="clear"></div>	
<p><br/><br/></p>



<script type='text/javascript'>
$(document).ready(function(){

jQuery.each($(".tinymce"), function() {
        tinyMCE.init({ mode : "exact", elements : this.id, theme : "advanced", skin : "o2k7", skin_variant : "silver", language : "hu", theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left", theme_advanced_statusbar_location : "bottom", gecko_spellcheck : "true", plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,preview,example",
    	theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,link,unlink,forecolor,backcolor,cleanup,|",    	
		theme_advanced_resizing : true,			
		document_base_url : $("#DOMAIN").val(),			
		width : "100%",  
		height : "150", 
		paste_auto_cleanup_on_paste : true, 
		plugin_preview_width : "1000", 
		theme_advanced_resize_horizontal : false,
        theme_advanced_path : false,theme_advanced_statusbar_location : 0,
        setup : function(ed) {
    ed.onInit.add(function(ed, evt) {

        var dom = ed.dom;
        var doc = ed.getDoc();

        tinymce.dom.Event.add(doc, 'focusout', function(e) {
           $("#questionQuestion").css( { 'top':parseInt($("#"+$(ed).attr('id')).offset().top)+"px","display":"block" } );			
			$("#questionQuestion").animate(
				{ top:  parseInt($("#"+$(ed).attr('id')).offset().top-50)+"px" }, 
				{
					duration: 500, 
					easing: 'easeInOutBounce',
					complete: function() { 							
						setTimeout(function() { $("#questionQuestion").fadeOut("slow"); }, 3000);					
					}
				}
			);
        });
    });
},
		});
    });


$(".compQuestion").mouseenter(function() {
    var id = $(this).attr('id');
    $("#"+id+"Detailed").show();
  })
  .mouseleave(function() {
   var id = $(this).attr('id');
    $("#"+id+"Detailed").hide();
  });
    
    $(".delButt").click(function(){
        $(this).closest('.compCont').remove();
    });


$("#saveCompRajzSbmt").click(function (){
     
          
			$("#compRajzForm").validate( { rules: {
                'CompRajzNev': { required: 1 }
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.next('#ui-state-error'));					
            }
			
        });
        	
    });

});
</script>
