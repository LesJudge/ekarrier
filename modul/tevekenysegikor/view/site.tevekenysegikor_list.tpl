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
    
    for(i=0; i<data.length; i++){
        IDs.push(data[i]['ID']);
    }

    $('#{$FilterCsoport.name} option').each(function(){
        if(parseInt($(this).attr('value')) != -1){
            $(this).removeAttr("selected");
            if($.inArray($(this).attr('value'),IDs) == -1){
                $(this).attr('disabled',true);
                $(this).addClass('disabledItemGroup');
            }else{
                $(this).attr("selected",true);
            }   
        }
    });
    $('#{$FilterCsoport.name}').trigger('change');
}

function resetCircleOpts(){
    $('.disabledItemCircle').removeClass('disabledItemCircle');
    $('#{$FilterKor.name} option').attr('disabled', false);
}

function resetGroupOpts(){
    $('.disabledItemGroup').removeClass('disabledItemGroup');
    $('#{$FilterCsoport.name} option').attr('disabled', false);
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
    //display:none;
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
<form action="" method="POST" name="{$FormName}" id="{$FormName}" enctype="multipart/form-data">
    <div id="anc" class="jobDataForm-cont">
        
        <!--input type="text" name="{$TxtSearchByName.name}" value="{$TxtSearchByName.activ}"-->
        
        <div class="filter_row">
		<label for="{$FilterCsoport.name}">Csoport</label>
		{html_options id=$FilterCsoport.name name=$FilterCsoport.name options=$FilterCsoport.values selected=$FilterCsoport.activ}
		<div class="clear"></div> 
        </div>
                
        <div class="filter_row">
		<label for="{$FilterKor.name}">Kör</label>
		{html_options id={$FilterKor.name} name=$FilterKor.name options=$FilterKor.values selected=$FilterKor.activ}
		<div class="clear"></div> 
        </div>
               
        <div class="filter_row">
		<label for="{$FilterSzektor.name}">Szektor</label>
		{html_options name=$FilterSzektor.name options=$FilterSzektor.values selected=$FilterSzektor.activ}
		<div class="clear"></div> 
        </div>
                
        <div class="filter_row">
		<label for="{$FilterPozicio.name}">Pozíció</label>
		{html_options name=$FilterPozicio.name options=$FilterPozicio.values selected=$FilterPozicio.activ}
		<div class="clear"></div> 
        </div>
                
        <input class="submit" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="Keresés">
        <input class="submit" type="submit" name="{$BtnFilterDEL}" value="Feltételek törlése">
        <div class="clear"></div>
    </div>
        
            
</form>
<div class="jobFindList-cont">
    <div class="jobFindList-top"><i class='icomoon icomoon-file3'>&nbsp;</i></div>
    <div class="jobFindList-title">Találati eredmények</div>
    {include file='page/all/view/page.message.tpl'}
    {if not empty($Lista)}
    {foreach from=$Lista item=munkakor}
    <div class="jobFindList-block">
        {$munkakor.munkakor_nev} - <font color="red">{$munkakor.korCim}</font> - <font color="blue">{$munkakor.csoportCim}</font> - {$munkakor.subCatID}
        <a href="{$DOMAIN}tevekenysegikor/{$munkakor.tevkorLink}">Részletek</a>
        <div class="clear"></div>
    </div>
    {/foreach}
    {/if}
    <div class="clear"></div>
    {include file='page/all/view/page.paging.tpl'}
</div>
<a class="btn btn-sm btn-primary" href="{$DOMAIN}fooldal/">Vissza a főoldalra</a>

