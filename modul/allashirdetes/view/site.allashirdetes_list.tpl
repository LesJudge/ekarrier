<script type="text/javascript" src="../js/pajinate/jquery.pajinate.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
     $('#paging_container1').pajinate({ items_per_page : 10,
                                       nav_label_first : 'Első',
                                       nav_label_prev : 'Előző',
                                       nav_label_next : 'Következő',
                                       nav_label_last : 'Utolsó' 
                                   });
                                   
     $('#paging_container2').pajinate({ items_per_page : 10,
                                       nav_label_first : 'Első',
                                       nav_label_prev : 'Előző',
                                       nav_label_next : 'Következő',
                                       nav_label_last : 'Utolsó' 
                                   });

      
     $(".letter").each(function(){
        var val = $("#{$FilterLetter.name}").attr('value');
        if(val == $(this).text().toLowerCase()){
            $(this).addClass("activeLetter");
        }
     });
     
     $('#{$FilterTevCsoport.name}').on('change',function(){
        var selectedID = $(this).find('option:selected').attr('value');
        
        if(parseInt(selectedID) > 0){
            $.ajax({
                url: '{$DOMAIN}ajax.php?m=tevekenysegikor&al=ajax&todo=filterbygroup&gid='+selectedID, 
                dataType: 'json', 
                success: function(data){
                    resetCircleOpts();
                    filterByGroup(data);
                }, 
                error: function(){
                    resetCircleOpts();
                }
            });
        }else{
            resetCircleOpts();
        }
    });
    
    
    $('#{$FilterTevKor.name}').on('change',function(){
        var selectedID = $(this).find('option:selected').attr('value');
        
        if(parseInt(selectedID) > 0){
            $.ajax({
                url: '{$DOMAIN}ajax.php?m=tevekenysegikor&al=ajax&todo=filterbycircle&cid='+selectedID, 
                dataType: 'json', 
                success: function(data){
                    resetGroupOpts();
                    filterByCircle(data);
                }, 
                error: function(){
                    resetGroupOpts();
                }
            });
        }else{
            resetGroupOpts();
        }
    });
    
    $(".letter").on('click',function(){
        $('.activeLetter').removeClass('activeLetter');
        $(this).addClass('activeLetter');
        var letter = $(this).text().toLowerCase();
        $('#{$FilterLetter.name}').attr('value',letter);
    
});
    
    
 });
 



function filterByGroup(data){
    var IDs = new Array();
    
    for(i=0; i<data.length; i++){
        IDs.push(data[i]['ID']);
    }

    $('#{$FilterTevKor.name} option').each(function(){
        if(parseInt($(this).attr('value')) != -1){
            if($.inArray($(this).attr('value'),IDs) == -1){
                $(this).attr('disabled',true);
                $(this).addClass('disabledItemCircle');
            }
        }
    });
}

function filterByCircle(data){
    var IDs = new Array();
    
    for(i=0; i<data.length; i++){
        IDs.push(data[i]['ID']);
    }

    $('#{$FilterTevCsoport.name} option').each(function(){
        if(parseInt($(this).attr('value')) != -1){
            $(this).prop("selected", false);
            if($.inArray($(this).attr('value'),IDs) == -1){
                $(this).attr('disabled',true);
                $(this).addClass('disabledItemGroup');
            }else{
                $(this).prop("selected",true);
            }   
        }
    });
}

function resetCircleOpts(){
    $('.disabledItemCircle').removeClass('disabledItemCircle');
    $('#{$FilterTevKor.name} option').attr('disabled', false);
}

function resetGroupOpts(){
    $('.disabledItemGroup').removeClass('disabledItemGroup');
    $('#{$FilterTevCsoport.name} option').attr('disabled', false);
}
 </script>
{if not $isArchive}
<!--div>
    <a href="{$DOMAIN}allaskereses/archivum/" class="bigBtn-link">Archívum</a>
</div>
<br /-->
{/if}
<div>{$text}</div>

<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
<div class="jobFindList-title-cont">
	<div class="jobFindList-title jobFindList-title-2">Keress az álláshírdetések és a munkáltatók között</div>
	<div class="jobDataForm-cont">        
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1">
				<div class="form-row">		
				{html_options name=$FilterSector.name id=$FilterSector.name options=$FilterSector.values selected=$FilterSector.activ class='select-type-1'}
				<div class="clear"></div> 
				</div>
						
				<div class="form-row">		
				{html_options name=$FilterPosition.name id=$FilterPosition.name options=$FilterPosition.values selected=$FilterPosition.activ class='select-type-1'}
				<div class="clear"></div> 
				</div>
				
				<!--
				<div class="form-row">		
				{html_options name=$FilterJob.name id=$FilterJob.name options=$FilterJob.values selected=$FilterJob.activ class='select-type-1'}
				<div class="clear"></div> 
				</div>	
				-->
					   
				<div class="form-row">		
				{html_options name=$FilterTevCsoport.name id=$FilterTevCsoport.name options=$FilterTevCsoport.values selected=$FilterTevCsoport.activ class='select-type-1'}
				<div class="clear"></div> 
				</div>
				
				<div class="form-row">		
				<input type="text" name="{$FilterCity.name}" value="{$FilterCity.activ}" autocomplete="off" placeholder="Város" />
				<div class="clear"></div> 
				</div>
			</div>	
			<div class="col-lg-11 col-lg-offset-1">		
				<div class="form-row">		
				{html_options name=$FilterTevKor.name id=$FilterTevKor.name options=$FilterTevKor.values selected=$FilterTevKor.activ class='select-type-1'}
				<div class="clear"></div> 
				</div>
				
				<div class="form-row">		
				{html_options name=$FilterCounty.name id=$FilterCounty.name options=$FilterCounty.values selected=$FilterCounty.activ class='select-type-1'}
				<div class="clear"></div> 
				</div>
				
				<div class="form-row">		
				{html_options name=$FilterEllenorzott.name id=$FilterEllenorzott.name options=$FilterEllenorzott.values selected=$FilterEllenorzott.activ class='select-type-1'}
				<div class="clear"></div> 
				</div>
				
				<div class="form-row" style="padding-top:0.4em;">		
				<button class="btn btn-danger" type="submit" name="{$BtnFilterDEL}" value="Feltételek törlése">Feltételek törlése</button>                   
				<input class="btn btn-primary" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="Keres" />        
				<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>				
		</div> 
		
		<br/>
		<div class="row search-letter-cont">
			<strong>Keress ABC szerint</strong>
			<div class="clear"></div>
			<div class="letter">A</div>
			<div class="letter">B</div>
			<div class="letter">C</div>
			<div class="letter">D</div>
			<div class="letter">E</div>
			<div class="letter">F</div>
			<div class="letter">G</div>
			<div class="letter">H</div>
			<div class="letter">I</div>
			<div class="letter">J</div>
			<div class="letter">K</div>
			<div class="letter">L</div>
			<div class="letter">M</div>
			<div class="letter">N</div>
			<div class="letter">O</div>
			<div class="letter">P</div>
			<div class="letter">Q</div>
			<div class="letter">R</div>
			<div class="letter">S</div>
			<div class="letter">T</div>
			<div class="letter">U</div>
			<div class="letter">V</div>
			<div class="letter">W</div>
			<div class="letter">X</div>
			<div class="letter">Y</div>
			<div class="letter">Z</div>
			<div class="letter">1</div>
			<div class="letter">2</div>
			<div class="letter">3</div>
			<div class="letter">4</div>
			<div class="letter">5</div>
			<div class="letter">6</div>
			<div class="letter">7</div>
			<div class="letter">8</div>
			<div class="letter">9</div>
			<div class="letter">0</div>
        	<div class="clear"></div>
		</div>
    </div>
</div>


<br/>
{include file='page/all/view/page.message.tpl'}
{include file='modul/allashirdetes/view/partial/site_allashirdetes_list.tpl'}
{*include file='page/all/view/page.paging.tpl'*} 
<input id="{$FilterLetter.name}" name="{$FilterLetter.name}" type="hidden" value="{$FilterLetter.activ}" />
<div class="clear"></div>
<br />
<a class="btn btn-sm btn-default" href="{$DOMAIN}fooldal/">Vissza a főoldalra</a>


		
    
       

        
 <style>
 .letter{
 float: left;
 }
 
 .letter:hover{
 cursor: pointer;
 }
 
 .activeLetter{
 color: green;
 font-weight: 800;
 }
 
 .disabledItemCircle, .disabledItemGroup{
    color: darkgrey !important;
    //display:none;
}
 </style>   
        
 
        
    
</form>
