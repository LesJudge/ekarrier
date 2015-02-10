{if $Error}
{$Error}
{else}
<input type="text" id="firstWordsResult" value="0" readonly hidden='hidden'>
<input type="text" id="firstWordsResultRemaining" value="0" readonly hidden='hidden'>

<div id='pointsZeroAlert'class="infobox" style='display: none'>
      <div class="alert-box"> {$pointsZero.infobox_tartalom} </div> 
</div>
<div id='orderFailAlert'class="infobox" style='display: none'>
      <div class="alert-box"> {$pointsZero.infobox_tartalom} </div> 
</div>
{foreach from=$MainResKat key=key item=val}
    <label for="res{$key}" style='display:none;'>{$MainResKat[$key]['szektor_nev']}</label>
    <input type="hidden" id="res{$key}" class="res" value="0" />
{/foreach}
<!--
<input type="button" onClick="test();" value="test">
<input type="button" onClick="calcSecondScores();" value="test2">
<input type="checkbox" id="validation" value="Val" checked>-->

<form id="finalScoreForm" method="post" action="">
    <input type="hidden" id="finalResults" name="finalResults" />
</form>


<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-tree'>&nbsp;</i></div>	
	<div class="jobFindList-title textAlign-center">{$pointsRemaining.infobox_tartalom}: <span id='remainingShow'></span></div>	
	<div class="jobFindList-data">	
		
			<div id="firstWords" class="firstWords-cont">   
				{foreach from=$FirstKat key=key item=val}           
				<div class="firstWords-item">
					   <div class='firstWords' id='firstWord_{$key}'>{$val}</div>		
					   <input type='text' class='firstWordsValues' value='0' onChange="calcScore()" id='firstWordValue_{$key}' />		
					{foreach from=$MainResKat key=key1 item=val1}		
					   <input type='hidden' class='firstWordsScores res{$key1}' value='0' id='first_{$key}_{$key1}' />		
					{/foreach}
				  </div>	
				{/foreach}
				<div class="clear"></div>
			</div>
	
	</div>	
	<div class="clear"></div>
</div> 


<div class="clear"></div>
<div class="jobFindList-cont">
	<div class="jobFindList-top"><i class='icomoon icomoon-tab'>&nbsp;</i></div>	
	<div class="jobFindList-title textAlign-center">Jellemző kompetenciák</div>	
	<div class="jobFindList-data">
	
		<div class="connectedSortable-cont">  			
			<ul id="sortable1" class="connectedSortable">
				{foreach from=$SecondKat key=key item=val name=total}
					<li id="secondWord_{$key}" class="secondWords" value="">{$val}
						{foreach from=$MainResKat key=key1 item=val1}
						<input type="hidden" class='secondWordsScores res{$key1}' value='0' id='second_{$key}_{$key1}' />
						{/foreach}
					</li>
				{/foreach}
			</ul>	
			<ul id="sortable2" class="connectedSortable"></ul>
			<div class="clear"></div>
		</div>
	
	</div>	
	<div class="clear"></div>
</div> 

<br/>

<div class="btn-nav-row">
<button type="submit" onClick="eval();" class="btn btn-lg btn-primary">Teszt mentése</button>

</div>

<script type=text/javascript>
$(function() {  
	var renderBoxHeightTimer = setTimeout(function(){
		renderBoxHeight("connectedSortable");
	},500);
	
    $( "#sortable1, #sortable2" ).sortable({
        connectWith: ".connectedSortable",
        cursor: "move"
    });
  
    $( "#sortable2" ).on( "sortover", function( event, ui ) {
        $('#'+ui.item[0].id).addClass("ordered");
    });
  
    $( "#sortable1" ).on( "sortout", function( event, ui ) {
        $('#'+ui.item[0].id).removeClass("ordered");
    });
  
    $( "#sortable2" ).on( "sortupdate", function( event, ui ) {
        calcOrder();
    });
});

var rulesArr=[];                                    
var rules2Arr=[];                                   
var katArr=[];                                      
var multipArr=[];                                   



{foreach from=$Rules key=key item=val}                          
    {foreach from=$Rules[$key] key=key1 item=val1}
        rulesArr["{$key}_{$key1}"]={$Rules[$key][$key1]};
    {/foreach}
{/foreach}
    
{foreach from=$Rules2 key=key item=val}
   {foreach from=$Rules2[$key] key=key1 item=val1}
        rules2Arr["{$key}_{$key1}"]={$Rules2[$key][$key1]};
   {/foreach}
{/foreach}

{foreach from=$MainResKat key=key item=val}
    katArr["{$key}"]="{$val}";
{/foreach}
    
{foreach from=$Multips key=key item=val}
    multipArr["{$key}"]="{$val}";
{/foreach}    

function calcPoints(){                                        
    var result=parseFloat(0);
    $('.firstWordsValues').each(function(index){
        result=result+parseFloat(this.value);
    });
    $('#firstWordsResult').val(result);
    $('#firstWordsResultRemaining').val(100-result);
    $('#remainingShow').text(100-result);
    
    if(result==100){
        $('#pointsZeroAlert').show();
    }else{
        $('#pointsZeroAlert').hide();
    }
}

function calcScore(){                                          
    var multip;
    var result;
    var ossz=0;
    var max=parseFloat($('#firstWordsResultRemaining').val())+parseFloat($('#firstWordsResult').val());
    
    $(".firstWordsValues").each(function(index){
        if($(this).val()=="" || $(this).val()<0 || isNaN($(this).val())){
            $(this).val(0);
        }
        ossz=ossz+parseFloat($(this).val());
        if(ossz > max){
            //if($('#validation').is(':checked')){
                $(this).val(0);
            //}
        }    
    });
    
    $('.firstWordsScores').each(function(index){
        var arr=this.id.split("_");
        var szo=arr[1];
        var kat=arr[2];
        
        if (rulesArr[szo+"_"+kat]!==undefined){
            multip=multipArr[rulesArr[szo+"_"+kat]];
            result=Math.round($("#firstWordValue_"+szo).val()*multip);
            $(this).val(result);
        }
    });

getFullScores();
}


var finalResults=""; 

function eval(){                                
    
    if($('#firstWordsResultRemaining').val()!=0){
        $('#pointsZeroAlert').show();
        //return false;
    }
    
    if($('#sortable1 li').length!=0){
        $('#orderFailAlert').show();
        //return false;
    }
    
    //if(($('#firstWordsResultRemaining').val()==0 && $('#sortable1 li').length==0) || !$('#validation').is(':checked')){
    if(($('#firstWordsResultRemaining').val()==0 && $('#sortable1 li').length==0)){
        for(i=0;i<$(".res").length;i++){
            finalResults+=i+"="+$("#res"+i).val()+"_";
        }
        $("#finalResults").val(finalResults);
        $( "#finalScoreForm" ).submit();
        return true;
    }else{
        
        return false;
    }
}

function getFullScores(){           
    calcPoints();
    var res=0;
    for(i=0;i<$(".res").length;i++){
        $('.res'+i).each(function(index){
            res=res+parseFloat($(this).val());
        });
        $('#res'+i).val(Math.round(res*10)/10);
        res=0;
    }
 }
 
 
function calcSecondScores(){      
    $('.secondWordsScores').each(function(index){
        
        var arr=this.id.split("_");
        var szo=arr[1];
        var kat=arr[2];
        var multip;
        var result;
        if($('#secondWord_'+szo).hasClass('ordered')){
        if (rules2Arr[szo+"_"+kat]!==undefined){
            multip=multipArr[rules2Arr[szo+"_"+kat]];
            result=Math.round($("#secondWord_"+szo).attr("value")*multip*10)/10;
            $(this).val(result);
        }
        }
  });
getFullScores(); 
}

function calcOrder(){                               
    $(".ordered").each(function(index,value){
        var z=this.id.split("_");
        var id=parseInt(z[1]);
        var score=($(".ordered").length)-index;
        $("#secondWord_"+id).val(score);
    });
    calcSecondScores();

}

function test(){                                    
    var score=0;
    
    $('.firstWordsValues').each(function(index){
        score=score+parseInt(10);
        $(this).val(score);
        if(score==90){
            score=0;
        }
    });
calcPoints();
calcScore();
}


calcPoints(); 

</script>
{/if}