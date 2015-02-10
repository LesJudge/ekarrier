<script type="text/javascript" src="{$DOAMAIN}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOAMAIN}js/admin/add_tinymce_mini.js" ></script>


<div id="myCompEditDialog" title="Kompetencia szerkesztése">
	<br />
    <h5 class="infobox">{$question.infobox_nev} - {$question.infobox_tartalom} </h5>    
    <form id="editCompForm" action="" method="post">
	<div class="dialog-form">	
        <input type="text" id="editCompId" name="compId" hidden="hidden" />
        <textarea id="editComp_valasz" name="valasz" class="tinymce"></textarea>
		<br />
		<div class="btn-nav-row">
        <button name="{$BtnEditComp}" type="submit" class="btn btn-sm btn-primary">Mentés</button>
		</div>
	</div>	
    </form>
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
		<div id="newCompDialog" title="Kompetencia hozzáadása">			
			<form id="newCompForm" action="" method="post">
				<ul id="allCompSelect" class='sortable1 sortedUL sortedUL-graggable'>
					{foreach from=$allCompetences item=val}
					<li id='allComp_{$val['kompetencia_id']}' class='allComp'>
						<div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
						{$val['kompetencia_nev']}
					</li>
					{/foreach}
				</ul>
			</form>			
		</div>
		<div class="jobFindList-title textAlign-center">Kompetenciáim</div>	
		<ul id="myComps" class='sortable2 sortedUL'>
			{foreach from=$userCompetences item=val}
			<li class='fixed'>
				<div class="myComp-bg" style="background:{$val['kompetencia_szinkod']}">&nbsp;</div>
				<div id='myComp_{$val['kompetencia_id']}' class='myComp {if $val['user_attr_kompetencia_tesztbol']=="1"}fromTest{/if}'>{$val['kompetencia_nev']}</div>
				{if $val['user_attr_kompetencia_tesztbol']=="1"}<div class='myComp-test'></div>{/if}	
				<div id='myComp_{$val['kompetencia_id']}_operations' class="sortedUL-right">						
					<a id="editComp_{$val['kompetencia_id']}" class="myCompEditDialogOpener iconCont" title="Szerkesztés"><i class="icomoon icomoon-pencil">&nbsp;</i></a>
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

 

<script type='text/javascript'>
$(document).ready(function(){
    
    $('.myComp').each(function(){
        var a=this.id.split('_');
        $('#allComp_'+a[1]).remove();
    });

    $("#myCompEditDialog").dialog({ autoOpen: false, width: 600, modal:true });
    
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
    /*
    $(".myComp").click(function(){
        $('#'+$(this).attr('id')+'_operations').toggle();
    });
    */
    $(".myCompEditDialogOpener").click(function(){
        var a=$(this).attr('id').split("_");
        $("#editComp_valasz").text($("#myComp_"+a[1]+"_valasz").text());
        $("#editCompId").attr('value',a[1]);
        $("#myCompEditDialog").dialog('option', 'title', $("#myComp_"+a[1]).text()+' szerkesztése');
        $("#myCompEditDialog").dialog( "open" );
    });
    
    $(".delButt").click(function(){
        var a=$(this).attr('id').split("_");
        $("#deleteCompId").val(a[1]);
        $("#deleteCompSbmt").trigger("click");
    });
/*
    var json_data={$testCompetences};
    var result = [];

    for(var i in json_data)
        result.push([i, json_data [i]]);

    for(var i=0; i<result.length; i++ ){
        if($('#myComp_'+result[i][0]).length){
            $('#myComp_'+result[i][0]).addClass('fromTest');
        }
        if($('#allComp_'+result[i][0]).length){
            $('#allComp_'+result[i][0]).addClass('fromTest');
        }
    }*/
});
</script>
