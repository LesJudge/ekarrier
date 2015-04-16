<script type="text/javascript" src="{$DOMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<!--script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script-->
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
{include file='modul/kompetencia/view/partial/site.kompetencia_commonbuttons.tpl'}
<div><a href="{$DOMAIN}kompetenciak/kompetenciarajz-keszites/">Új kompetencia rajz</a></div>

{if not empty($compRajzok)}
    {foreach from=$compRajzok item=rajz}
        <div><a href="{$DOMAIN}kompetenciak/kompetenciarajz-keszites/{$rajz.ID}/">{$rajz.nev}</a></div>
    {/foreach}
{else}
    Nincs még kompetenciarajz
{/if}
<style>
    .compQuestion{
    position: fixed;
    left: 20px;
    width: 70px;
    height: 30px;
    background-color: lightgrey;
    color: red;
    padding: 10px;
    }
    
    .compQuestionDetailed{
    position: fixed;
    left: 100px;
    width: auto;
    height: 30px;
    background-color: lightgrey;
    color: red;
    padding: 10px;
    display:none;
    }
    
    #q1, #q1Detailed{
    top: 450px;
    }
    
    #q2, #q2Detailed{
    top: 490px;
    }
    
    #q3, #q3Detailed{
    top: 530px;
    }
    
    #q4, #q4Detailed{
    top: 570px;
    }
    
    #questionQuestion{
    position: fixed;
    background-color: lightgrey;
    color: red;
    padding: 10px;
    width: auto;
    height: 30px;
    left: 20px;
    top: 400px;
    display: none;
    }
    
    
</style>


<div id="questionQuestion">Mindegyik kérdésre válaszolt?</div>
<div id="q1" class="compQuestion">Kérdés1</div>
<div id="q1Detailed" class="compQuestionDetailed">Melyik munkahelyen, milyen tevékenységen keresztül fejlesztette ezt a kompetenciáját?</div>
<div id="q2" class="compQuestion">Kérdés2</div>
<div id="q2Detailed" class="compQuestionDetailed">Milyen tanulmányok során mélyítette az ehhez kapcsolódó elméleti/szakmai tudását?</div>
<div id="q3" class="compQuestion">Kérdés3</div>
<div id="q3Detailed" class="compQuestionDetailed">Milyen társadalmi munka/hobbi/szabadidős tevékenységen keresztül fejlesztette?</div>
<div id="q4" class="compQuestion">Kérdés4</div>
<div id="q4Detailed" class="compQuestionDetailed">E kompetenciához kapcsolódó egyéb kiegészítő tudás, tapasztalat, élmény.</div>
<form id="compRajzForm" method="post">
<input type="text" name="CompRajzNev" value="{$compRajzNev}" style="width: 150px !important" />
{if $mode == "modify"}
<input type="hidden" name="CompRajzID" value="{$compRajzID}" />
<button id='updateCompRajzSbmt' name="{$BtnUpdateCompRajz}" type="submit" class="btn btn-sm btn-primary">Felülírás</button>
<button id='saveAsCompRajzSbmt' name="{$BtnSaveAsCompRajz}" type="submit" class="btn btn-sm btn-primary">Mentés másként</button>
<button id='deleteCompRajzSbmt' name="{$BtnDeleteCompRajz}" type="submit" class="btn btn-sm btn-primary">Kompetenciarajz törlése</button>
<button id='requestExpertOpinionSbmt' name="{$BtnRequestExpertOpinion}" type="submit" class="btn btn-sm btn-primary">Szakértő véleménye!</button>
<a class="btn btn-sm btn-primary" href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$compRajzID}/">Megtekintés</a>
<a class="btn btn-sm btn-primary" href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$compRajzID}/?forceforeign=1">Ezt látja rólam a munkáltató</a>
<a class="btn btn-sm btn-primary" href="{$DOMAIN}tevekenysegikor-kereso/">Hasonló tevékenységi körbe postolók rajzának megtekintése</a>


{elseif $mode == "new"}
<button id='saveCompRajzSbmt' name="{$BtnSaveCompRajz}" type="submit" class="btn btn-sm btn-primary">Mentés</button>    
{/if}

<div class="jobFindList-cont">
	
	<div class="jobFindList-data">	
		
		<div class="jobFindList-title textAlign-center">Kompetenciáim</div>	
		<ul id="myComps" class='sortable2 sortedUL'>
			{foreach from=$compRajzCompetences item=val}
			<li class='fixed'>
				<div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
				<div id='myComp_{$val['kompetencia_id']}' class='myComp {if $val['user_attr_kompetencia_tesztbol']=="1"}fromTest{/if}'>{$val['kompetencia_nev']}</div>
				{if $val['user_attr_kompetencia_tesztbol']=="1"}<div class='myComp-test'></div>{/if}
                                <div>{$val['kompetencia_leiras']}</div>
				<div id='myComp_{$val['kompetencia_id']}_operations' class="sortedUL-right">						
					<a id='delButt_{$val['kompetencia_id']}' class="delButt iconCont" title="Töröl"><i class="icomoon icomoon-remove2">&nbsp;</i></a>
				</div>
				<div class="clear"></div>
				<div>
                                <input type="hidden" name="CompRajzKompetenciak[]" value="{$val['kompetencia_id']}"/>
                                <textarea id="myComp_{$val['kompetencia_id']}_valasz" name="CompRajzValaszok[]" class="tinymce" cols="2" rows="2">{$val['valasz']}</textarea>
				</div>				
			</li>
			{/foreach}
		</ul>	
	</div>
	<div class="clear"></div>
</div> 

</form>

<div><a href="{$DOMAIN}kompetenciak/kompetenciarajz/">Kompetencia hozzáadása</a></div>                
<br/>
<h2>Szakértői vélemények</h2>
{if not empty($opinions)}
    {foreach from=$opinions item=opinion} 
    <div style="background-color: lightgray; margin-top: 2px;">
        {$opinion.valaszolo} - {$opinion.valasz_date}
        <br />
        {$opinion.velemeny}
    </div>    
    {/foreach}
{else}
    Nincs még szakértői vélemény
{/if}
<br/>
<a href="{$DOMAIN}uzeneteim/">Lépjen kapcsolatba szaktanácsadóinkkal!</a>
<script type='text/javascript'>
$(document).ready(function(){

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
        setup : function(ed) {
    ed.onInit.add(function(ed, evt) {

        var dom = ed.dom;
        var doc = ed.getDoc();

        tinymce.dom.Event.add(doc, 'focusout', function(e) {
            // Do something when the editor window is blured.
            $("#questionQuestion").fadeIn("slow");
            setTimeout(function() { $("#questionQuestion").fadeOut("slow"); }, 3000);
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
        $(this).closest('li').remove();
    });

});
</script>
