{include file="page/all/view/partial/jobTooltips.tpl"}
<script type="text/javascript">
$(document).ready(function(){

    $('#{$FilterCsoport.name}').on('change',function(){
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
    
    
    $('#{$FilterKor.name}').on('change',function(){
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
   
    {if $jumpToAnc == '1'}
        $('html, body').animate({
            scrollTop: $('#anc').offset().top
        }, 1);
    {/if}
 
});

function filterByGroup(data){
    var IDs = new Array();
    
    for(i=0; i<data.length; i++){
        IDs.push(data[i]['ID']);
    }

    $('#{$FilterKor.name} option').each(function(){
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
    console.log(data);
    for(i=0; i<data.length; i++){
        IDs.push(data[i]['ID']);
    }

    $('#{$FilterCsoport.name} option').each(function(){
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
    $('#{$FilterCsoport.name}').trigger('change');
}

function resetCircleOpts(){
    $('.disabledItemCircle').removeClass('disabledItemCircle');
    $('#{$FilterKor.name} option').prop('disabled', false);
}

function resetGroupOpts(){
    $('.disabledItemGroup').removeClass('disabledItemGroup');
    $('#{$FilterCsoport.name} option').prop('disabled', false);
}

</script>



<style type="text/css">
.ek-job-main {
    clear: both;
    font-size: 16px;
    font-weight: bold;
    display: block;
    margin-bottom: 15px;
    margin-top: 10px;
}
.ek-job-sub {
    
}

.disabledItemCircle, .disabledItemGroup{
    color: darkgrey !important;
    //display: none;
}
</style>

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

<form action="" method="POST" name="{$FormName}" id="{$FormName}" enctype="multipart/form-data">
    <div class="jobFindList-title-cont"><div class="jobFindList-title">Munkakör kereső</div></div>
	<div id="anc" class="jobDataForm-cont">
        
		<div class="filter_row_cont">
			<div class="filter_row">		
			{html_options id=$FilterCsoport.name name=$FilterCsoport.name options=$FilterCsoport.values selected=$FilterCsoport.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
					
			<div class="filter_row">		
			{html_options id={$FilterKor.name} name=$FilterKor.name options=$FilterKor.values selected=$FilterKor.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
				   
			<div class="filter_row">		
			{html_options name=$FilterSzektor.name options=$FilterSzektor.values selected=$FilterSzektor.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
					
			<div class="filter_row">		
			{html_options name=$FilterPozicio.name options=$FilterPozicio.values selected=$FilterPozicio.activ class='select-type-1'}
			<div class="clear"></div> 
			</div>
    	</div>  
		 
        <span class="size-1"><input type="text" name="{$TxtSearchByName.name}" value="{$TxtSearchByName.activ}" autocomplete="off" placeholder="Keress konkrét tevékenységi kört..." /></span>
		<button class="btn btn-danger" type="submit" name="{$BtnFilterDEL}" value="Feltételek törlése"><i class="icomoon icomoon-remove2"></i></button>                   
        <input class="submit" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="Keresés" />
        
        <div class="clear"></div>
    </div>
                    
</form>

<br/>
{include file='page/all/view/page.message.tpl'}
{if not empty($Lista)}
<div class="jobFindList-title-cont"><div class="jobFindList-title">Találati lista</div></div>
<div class="jobFindList-cont"> 
	{foreach from=$Lista item=munkakor}
	<div class="jobFindList-block">
		<span class="jobFindList-item-type-1">{$munkakor.munkakor_nev}</span> - {$munkakor.korCim} - {$munkakor.csoportCim}
		<a href="{$DOMAIN}tevekenysegikor/{$munkakor.tevkorLink}" class="btn btn-primary btn-sm">Részletek</a>
		<div class="clear"></div>
	</div>
	{/foreach}
</div>	
{/if}
<div class="clear"></div>
{include file='page/all/view/page.paging.tpl'}


<br />
<a class="btn btn-sm btn-default" href="{$DOMAIN}fooldal/">Vissza a főoldalra</a>

