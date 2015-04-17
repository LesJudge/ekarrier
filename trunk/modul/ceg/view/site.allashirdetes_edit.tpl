<style type="text/css">
.select-cont {
    width: 260px;
}
.ui-autocomplete {
    max-width: 360px;
    width: auto;
}
</style>
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
});

</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor regisztracio" enctype="multipart/form-data">
        {include file='page/all/view/page.message.tpl'}
        {*if $FormError*}
        <!--<a href="{$DOMAIN}ceg/allashirdetes/">Vissza az álláshirdetésekhez!</a>-->
        {*else*}        
			<div class="contentDataCont">
				<div class="siteTab-title">Alap adatok</div>					
				<button class="submit btn siteTab-save" name="{$BtnSave}" id="{$BtnSave}" value="submit" type="submit">Mentés</button>
				<div class="siteTabNext"><a href="javascript:;" class="btn btn-default">Tovább</a></div><div class="siteTabNext_cover"></div>                   
				<div class="siteTabBack"><a href="javascript:;" class="btn btn-default">Vissza</a></div><div class="siteTabBack_cover"></div>   
				<div class="contentData-bg">                                     
					<div class="contentData">
						<div class="siteTabContainer">									
							<div class="siteTab" siteTab-bredcrumb="Alap adatok">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_alap_adatok.tpl"}</div>
							<div class="siteTab" siteTab-bredcrumb="Tevékenységi körök">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_tevekenysegi_kor.tpl"}</div>
							<div class="siteTab" siteTab-bredcrumb="Elvárások">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_elvarasok.tpl"}</div>
							<div class="siteTab" siteTab-bredcrumb="Feladatok">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_feladatok.tpl"}</div>
                                                        <div class="siteTab" siteTab-bredcrumb="Kompetenciák">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_kompetenciak.tpl"}</div>
							<div class="siteTab" siteTab-bredcrumb="Amit kínálunk">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_amit_kinalunk.tpl"}</div>
							<!--div class="siteTab" siteTab-bredcrumb="Ismertető">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_ismerteto.tpl"}</div-->
							<div class="siteTab" siteTab-bredcrumb="Jelentkezés módja">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_jelentkezes_modja.tpl"}</div>
							<div class="siteTab" siteTab-bredcrumb="Munkavégzés helye">{include file="modul/ceg/view/partial/site.ceg_allashirdetes_munkavegzes_helye.tpl"}</div>							
						</div>
					</div>
				</div>	
			</div>	
			<div class="tabBreadcrumb-cont">
				<div class="tabBreadcrumb-title">Beküldés lépései</div>	
				<div class="tabBreadcrumb_cover"></div>
				<div class="tabBreadcrumb"></div>		
			</div>	
			<div class="clear" style="margin-bottom: 50px;"></div>
			
        {*/if*}
        <a href="{$DOMAIN}ceg/allashirdetes/" class="bigBtn-link" style="display: block; margin: 0 auto; text-align: center; width: 200px;">Vissza az álláshirdetésekhez!</a>
    </form>
</div><!--/.content.clearfix-->
{if not $FormError}
<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>

<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.clientBaseWidget.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/plugin/jquery.uniweb.jobSelect.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/modul/allashirdetes/uniweb.allashirdetes.helper.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/jquery.sheepItPlugin.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
var domain = "{$DOMAIN}",
    elvarasOptions = [],
    feladatOptions = [],
    amitKinalunkOptions = [];
$(function() {
    
    var date = new Date();
    date.setDate(date.getDate() + 7);
    
    $("#{$DateLejar.name}, #{$DateJelentkezesHatarideje.name}, #{$DateMunkakezdesIdeje.name}, #{$DateKezdes.name}").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: date
    });
    
    function onExists( mainId, subId ) {
        
        this.find(".job-select-main").val(mainId).trigger("change");
        var $subSelect = this.find(".job-select-sub"), 
            $subOption = $subSelect.find("option[value=\"" + subId + "\"]");
        $subOption.attr("selected", true);
        $subSelect.prev("span").prev("span").text($subOption.text());
    }
    
    function onNotExists() {
        // Callback arra az esetre, amikor inicializálni kell a select-et.
    }

    var tks = new tevekenysegiKor( {if $tkorok}{$tkorok}{else}{literal}{}{/literal}{/if}, 0 ),
        tkorForm = $("#tkorForm").sheepIt({
        separator: "",
        allowRemoveLast: true,
        allowRemoveCurrent: true,
        allowRemoveAll: true,
        allowAdd: true,
        allowAddN: true,
        maxFormsCount: 0,
        minFormsCount: 0,
        iniFormsCount: 0,
        afterAdd: function (source, newForm) {
            sheepItJobsAfterAdd(
                newForm, 
                tks,
                onExists,
                onNotExists, 
                "input[id$=\"_elvaras\"]", 
                "input[id$=\"_feladat\"]", 
                "a",
                "div[id='newMkCont_#index#']"
            );
    
        },
        data: {if $tkorok}{$tkorok}{else}[]{/if}
    }),
    elvarasForm = $("#elvarasForm").sheepIt({
        separator: "",
        allowRemoveLast: true,
        allowRemoveCurrent: true,
        allowRemoveAll: true,
        allowAdd: true,
        allowAddN: true,
        maxFormsCount: 0,
        minFormsCount: 0,
        iniFormsCount: 0,
        afterAdd: function (source, newForm) {
            newForm.find("input").autocomplete({
                source: elvarasOptions
            });
        },
        data: {if $elvarasok}{$elvarasok}{else}[]{/if}
    }),
    feladatForm = $("#feladatForm").sheepIt({
        separator: "",
        allowRemoveLast: false,
        allowRemoveCurrent: true,
        allowRemoveAll: false,
        allowAdd: true,
        allowAddN: false,
        maxFormsCount: 0,
        minFormsCount: 0,
        iniFormsCount: 0,
        afterAdd: function ( source, newForm ) {
            newForm.find("input").autocomplete({
                source: feladatOptions
            })
        },
        data: {if $feladatok}{$feladatok}{else}[]{/if}
    }),
    amitKinalunkForm = $("#amitKinalunkForm").sheepIt({
        separator: "",
        allowRemoveLast: false,
        allowRemoveCurrent: true,
        allowRemoveAll: false,
        allowAdd: true,
        allowAddN: false,
        maxFormsCount: 0,
        minFormsCount: 0,
        iniFormsCount: 0,
        afterAdd: function ( source, newForm ) {
            newForm.find("input").autocomplete({
                source: amitKinalunkOptions
            });
        },
        data: {if $amitKinalunk}{$amitKinalunk}{else}[]{/if}
    }),
    
    kompetenciaForm = $("#kompetenciaForm").sheepIt({
        separator: "",
        allowRemoveLast: false,
        allowRemoveCurrent: true,
        allowRemoveAll: false,
        allowAdd: true,
        allowAddN: false,
        maxFormsCount: 0,
        minFormsCount: 0,
        iniFormsCount: 0,
       /* afterAdd: function ( source, newForm ) {
            newForm.find("input").autocomplete({
                source: kompetenciaOptions
            });
        },*/
        data: {if $kompetenciak}{$kompetenciak}{else}[]{/if}
    });
    
    {if $kompetenciak}
    for(i = 0; i<{$kompetenciak}.length; i++)
    {
        $("#kompetenciaForm_"+i+"_kompetencia_id option[value='"+{$kompetenciak}[i]["kompetenciaForm_#index#_kompetencia_id"]+"']").attr("selected",true);
        
        var text = $("#kompetenciaForm_"+i+"_kompetencia_id").parent().find(".styled.customInput-text");
        text.text($("#kompetenciaForm_"+i+"_kompetencia_id option:selected").text());
    }
    {/if}
    $("#kompetenciaForm").on("change", "select",function() { 
        $(this).parent().find(".styled.customInput-text").text($(this).find("option:selected").text());
    });
    
    {if $isNewRecord eq false}
    $(".job-select").jobSelect();
    updateExpectationsAndTasks(findJobIds(".job-select-id"), "input[id$=\"_elvaras\"]", "input[id$=\"_feladat\"]");
    {/if}
});

/*]]>*/
</script>
{/if}

