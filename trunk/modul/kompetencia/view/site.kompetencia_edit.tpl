<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>
{include file='modul/kompetencia/view/partial/site.kompetencia_commonbuttons.tpl'}
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

<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-info2'>&nbsp;</i></div>
	<div class="jobFindList-title">{$question.infobox_nev}</div>	
	<div class="jobFindList-data">{$question.infobox_tartalom}</div>	
	<div class="clear"></div>
</div>

<form id="newCompForm" action="" method="post" hidden='hidden'>
<div class="dialog-form">
    <input type="text" id='newCompId' name="newCompId" value="" hidden="hidden" />
	<div class="btn-nav-row">
    <button id='addCompSbmt' name="{$BtnAddComp}" type="submit" class="btn btn-sm btn-primary">Mentés</button>
	</div>
</div>	
</form>



<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-tab'>&nbsp;</i></div>	
	<div class="jobFindList-title textAlign-center">Összes</div>	
	<div class="jobFindList-data">	
				
			<form id="newCompForm" action="" method="post">
				<ul id="allCompSelect" class='sortable1 sortedUL sortedUL-graggable'>
					{foreach from=$allCompetences item=val}
					<li id='allComp_{$val['kompetencia_id']}' class='allComp'>
						{if $val['tipus'] != 'ugyfel'}
                                                <div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
						<a href="{$DOMAIN}kompetenciak/{$val['kompetencia_link']}">{$val['kompetencia_nev']}</a>
                                                {else}
                                                {$val['kompetencia_nev']}
                                                {/if}
					</li>
					{/foreach}
				</ul>
			</form>			
		
		<div class="jobFindList-title textAlign-center">Kompetenciáim</div>	
		<ul id="myComps" class='sortable2 sortedUL' style="height: 50px;">
			{foreach from=$userCompetences item=val}
			<li class='fixed'>
				<div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
				<div id='myComp_{$val['kompetencia_id']}' class='myComp {if $val['ugyfel_attr_kompetencia_tesztbol']=="1"}fromTest{/if}'><a href="{$DOMAIN}kompetenciak/{$val['kompetencia_link']}">{$val['kompetencia_nev']}</a></div>
				{if $val['ugyfel_attr_kompetencia_tesztbol']=="1"}<div class='myComp-test'><font color="red">Tesztből</font></div>{/if}	
				<div id='myComp_{$val['kompetencia_id']}_operations' class="sortedUL-right">						
					<a id='delButt_{$val['kompetencia_id']}' class="delButt iconCont" title="Töröl"><i class="icomoon icomoon-remove2">&nbsp;</i></a>
				</div>
				<div class="clear"></div>
				<div class="display-none">
					<textarea id="myComp_{$val['kompetencia_id']}_valasz" cols="2" rows="2" readonly="readonly" hidden="hidden">{$val['user_attr_kompetencia_valasz']}</textarea>
					<input type="text" name="deleteCompId" value="{$val['kompetencia_id']}" hidden="hidden" />	
				</div>				
			</li>
			{/foreach}
		</ul>	
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
                
<div>
	<form id="{$FormName}" name="{$FormName}" method="post">
	<div class="dialog-form">
		<input type="text" id='addOwnComp' name="addOwnComp" value="" style="width: 200px; float:right"/>
		<div class="btn-nav-row">
		<button id='addOwnCompSbmt' name="{$BtnAddOwnComp}" type="submit" class="btn btn-sm btn-primary" style="float:right">Saját kompetencia hozzáadása</button>
		</div>
	</div>	
	</form>
</div>

<a href="{$DOMAIN}kompetenciak/kompetenciarajz-keszites/">Irány a következő lépéshez</a>

<script type='text/javascript'>
$(document).ready(function(){
    
    $('.myComp').each(function(){
        var a=this.id.split('_');
        $('#allComp_'+a[1]).remove();
    });

   
    
    $( ".sortable1" ).sortable({
        connectWith: ".sortedUL",
        cursor: "move"
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

});
</script>

{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}