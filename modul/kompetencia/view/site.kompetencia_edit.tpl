<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>
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

<div>{$text}</div>
<div>{$text2}</div>
<div>{$text3}</div>
<div>{include file='modul/kompetencia/view/partial/site.kompetencia_commonbuttons.tpl'}</div>
<form id="newCompForm" action="" method="post" hidden='hidden'>
<div class="dialog-form">
    <input type="text" id='newCompId' name="newCompId" value="" hidden="hidden" />
	<div class="btn-nav-row">
    <button id='addCompSbmt' name="{$BtnAddComp}" type="submit" class="btn btn-sm btn-primary">Mentés</button>
	</div>
</div>	
</form>

<br />
<div class="row komtetenciaSzerkesztes">	
	<div class="col-lg-12" style="z-index:20;">
		<div class="padding-2">
			<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Összes</div></div>
			<div class="jobFindList-cont jobFindList-cont-1"> 			
				<form id="newCompForm" action="" method="post">
				<ul id="allCompSelect" class='sortable1 sortedUL sortedUL-graggable'>
					{foreach from=$allCompetences['sajat'] item=val}
					<li id='allComp_{$val['kompetencia_id']}' class='allComp'>
							{$val['kompetencia_nev']}
					</li>
					{/foreach}
				</ul>
				<br>
				<h3 style="font-size:1.4em;">Álláskeresők által felvitt kompetenciák</h3>
				<ul id="allCompSelect" class='sortable2 sortedUL sortedUL-graggable'>
					{foreach from=$allCompetences['ugyfel'] item=val}
					<li id='allComp_{$val['kompetencia_id']}' class='allComp'>
							{$val['kompetencia_nev']}
					</li>
					{/foreach}
				</ul>
				</form>			
			</div>	
		</div>	
	</div>
	<div class="col-lg-12">	
		<div class="padding-3">
			<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Kompetenciáim</div></div>
			<div class="jobFindList-cont jobFindList-cont-4"> 			
				<ul id="myComps" class='sortable2 sortedUL'>
					{foreach from=$userCompetences item=val}
					<li class='fixed'>
						<!--
						<div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
						<div id='myComp_{$val['kompetencia_id']}' class='myComp {if $val['ugyfel_attr_kompetencia_tesztbol']=="1"}fromTest{/if}'></div>
						-->
						<a href="{$DOMAIN}kompetenciak/{$val['kompetencia_link']}">{$val['kompetencia_nev']}</a>
						<!-- {if $val['ugyfel_attr_kompetencia_tesztbol']=="1"}<div class='myComp-test'><font color="red">Tesztből</font></div>{/if} -->	
						<div id='myComp_{$val['kompetencia_id']}_operations' class="sortedUL-right">						
							<a id='delButt_{$val['kompetencia_id']}' class="delButt iconCont" title="Töröl"><i class="icomoon icomoon-remove2">&nbsp;</i></a>
						</div>
						<div class="clear"></div>
						<div class="display-none">
							<textarea id="myComp_{$val['kompetencia_id']}_valasz" cols="2" rows="2" readonly hidden="hidden">{$val['user_attr_kompetencia_valasz']}</textarea>
							<input type="text" name="deleteCompId" value="{$val['kompetencia_id']}" hidden="hidden" />	
						</div>				
					</li>
					{/foreach}
				</ul>	
			</div>
		</div>	
	</div>	
	<div class="clear"></div>	
</div>
	
<div class="display-none">
	<form id="{$FormName}" name="{$FormName}" method="post">
	<div class="dialog-form">
		<input type="text" id='deleteCompId' name="deleteCompId" value="" hidden="hidden" />
		<div class="btn-nav-row">
		<button id='deleteCompSbmt' name="{$BtnDeleteComp}" type="submit" hidden='hidden' class="btn btn-sm btn-primary">Törlés</button>
		</div>
	</div>	
	</form>
</div>
                
<div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-2">Kompetenciák hozzáadása</div></div>
<div class="jobFindList-cont"> 
	<form id="{$FormName}" name="{$FormName}" method="post">
	<div class="dialog-form">
		 <input type="text" id='addOwnComp' name="addOwnComp" value="" />	
		<button id='addOwnCompSbmt' name="{$BtnAddOwnComp}" type="submit" class="btn btn-md btn-primary">Saját kompetencia hozzáadása</button>		
	</div>	
	</form>
</div>	
	


<p><br/></p>	 
<a class="btn btn-lg btn-default pull-right" href="{$DOMAIN}kompetenciak/kompetenciarajz-keszites/" style="margin-right:-10px;">Irány a következő lépéshez
<span class="btn-next-icon"><img src="images/site/next-bub-icon-1.png" alt="" /></span></a>
<div class="clear"></div>	
<p><br/><br/></p>


<script type='text/javascript'>
$(document).ready(function(){
    
    $('.myComp').each(function(){
        var a=this.id.split('_');
        $('#allComp_'+a[1]).remove();
    });

   
    renderDraggable();
    $( ".sortable1, .sortable2" ).sortable({
        connectWith: ".sortedUL",
        cursor: "move",
		change: function( event, ui ) {
			renderDraggable();
		}
    });
    
    $( " .sortable2" ).sortable({
        receive: function( event, ui ) { 
            $('#'+ui.item[0].id).addClass("fixed");
            var a=$('#'+ui.item[0].id).attr('id').split("_");
            $("#newCompId").attr('value',a[1]);
            $("#addCompSbmt").trigger("click");
            },
        cancel: ".fixed",
        cursor: "move"
    });
    
    
    
    $(".delButt").click(function(){
        var a=$(this).attr('id').split("_");
        $("#deleteCompId").val(a[1]);
        $("#deleteCompSbmt").trigger("click");
    });

	function renderDraggable(){
		setTimeout(function(){ 
			var o_1 = ".jobFindList-cont-1";
			var o_4 = ".jobFindList-cont-4";	
			$(o_1+", "+o_4).css("min-height","10");		
			if ( $(o_1).height() >= $(o_4).height() ) {
				$(o_1+", "+o_4).css("min-height", parseInt($(o_1).height()+38.5)+"px"); 
			}else {			
				$(o_1+", "+o_4).css("min-height", parseInt($(o_4).height()+38.5)+"px"); 
			}
		},300);
	}

});
</script>

{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}