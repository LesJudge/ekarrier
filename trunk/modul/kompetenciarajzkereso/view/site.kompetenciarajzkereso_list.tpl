<script type="text/javascript" src="../js/pajinate/jquery.pajinate.js"></script>
{include file="page/all/view/partial/jobTooltips.tpl"}
<script type="text/javascript">
$(document).ready(function(){
    $('#paging_container1').pajinate({ items_per_page : 10,
                                       nav_label_first : 'Első',
                                       nav_label_prev : 'Előző',
                                       nav_label_next : 'Következő',
                                       nav_label_last : 'Utolsó' 
                                   });
			

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


   var selectState = "none";
  $('#select-all').click(function(){
    if(selectState === "none"){
       $('.compDraws').prop('checked', true);
       selectState = 'all';
       $('#select-all').text('Egyik sem');
       return true;
    }
    
    if(selectState === "all"){
       $('.compDraws').prop('checked', false);
       selectState = 'none';
       $('#select-all').text('Összes kijelölése');
       return true;
    }
  });
  
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

<div class="text-type-1">Ez a 3 lépés hozzájárul ahhoz, hogy megtaláld a számodra legideálisabb munkaerőt!</div>


<div onclick="$('#cont1').toggle()" class="accordionItem-title">1. lépés - Hogyan keress?</div>
<div id="cont1" {if $jumpToAnc == '1'}style="display:none"{/if}>
	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's 
	standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to 
	make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, 
	remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing 
	Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
</div>
<div id="anc"></div>
<div onclick="$('#cont2').toggle()" class="accordionItem-title">2. lépés - Böngészés</div>
<div id="cont2" {if $jumpToAnc != '1'}style="display:none"{/if}>
    <form action="" method="POST" name="{$FormName}" id="{$FormName}" enctype="multipart/form-data">
        <div id="anc" class="accordionItem-cont">
			<div class="text-type-1">Minden álláshirdetés egyben munkakör is, így ezáltal kap eredményt a munkáltató, amikor munkakörre keres.</div>

            <!--input type="text" name="{$TxtSearchByName.name}" value="{$TxtSearchByName.activ}"-->

            <div class="filter_row">
                    <!-- <label for="{$FilterCsoport.name}">Csoport</label> -->
                    {html_options id=$FilterCsoport.name name=$FilterCsoport.name options=$FilterCsoport.values selected=$FilterCsoport.activ class='select-type-1'}
                    <div class="clear"></div> 
            </div>

            <div class="filter_row">
                    <!-- <label for="{$FilterKor.name}">Kör</label> -->
                    {html_options id={$FilterKor.name} name=$FilterKor.name options=$FilterKor.values selected=$FilterKoractiv class='select-type-1'}
                    <div class="clear"></div> 
            </div>

            <div class="filter_row">
                    <!-- <label for="{$FilterSzektor.name}">Szektor</label> -->
                    {html_options name=$FilterSzektor.name options=$FilterSzektor.values selected=$FilterSzektor.activ class='select-type-1'}
                    <div class="clear"></div> 
            </div>

            <div class="filter_row">
                    <!-- <label for="{$FilterPozicio.name}">Pozíció</label> -->
                    {html_options name=$FilterPozicio.name options=$FilterPozicio.values selected=$FilterPozicio.activ class='select-type-1'}
                    <div class="clear"></div> 
            </div>

            <input type="text" name="{$FilterMunkakor.name}" value="{$FilterMunkakor.activ}" class="form-control size-1"> &nbsp;
            <input class="btn btn-sm btn-primary" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="Keresés">
            <input class="btn btn-sm btn-primary" type="submit" name="{$BtnFilterDEL}" value="Feltételek törlése">
            <div class="clear"></div>
        </div>

    </form>

    <form id="compDraws" name="compDraws" action="" method="post">        
        <hr class="line-type-1" />
		<div class="accordionItem-cont">            
            <div class="text-type-1">Keresés eredménye</div>
            {if not empty($Lista)}
                <div id="paging_container1">                   
                    <ul>
                        {foreach from=$Lista item=krajz}
                            <li class="accordionItem-block">                                
								<input type="checkbox" name="draws[]" class="compDraws" value="{$krajz.krID}">
								<a href="{$DOMAIN}kompetenciak/kompetenciarajz-nezet/{$krajz.krID}/">{$krajz.uID}/{$krajz.krID}</a>
								<div class="clear"></div>                               
                            </li>    
                        {/foreach}
						 <div class="clear"></div>
                    </ul>
					 <div class="page_navigation"></div>
                </div>
            {/if}
            <div class="clear"></div>
        </div>
        {if $loggedInAs == 'company'}
			<hr class="line-type-1" />
			<div class="text-type-1">Mappa kezelése</div>
			<div class="accordionItem-cont">
				<div class="accordionItem-select-cont">
				<select id="folders" name="folders" class="select-type-1">
					{foreach from=$folders item=folder key=key}
						<option value="{$key}">{$folder}</option>
					{/foreach}
				</select>
				</div>
				<button class="btn btn-sm btn-primary" id="select-all" type="button">Összes kijelölése</button>
				<button class="btn btn-sm btn-primary" name="{$BtnAddDraws}" type="submit">Hozzáadás</button>
				<div class="clear"></div>
				<input type="text" name="folderName" class="form-control size-1">
				<button class="btn btn-sm btn-primary" name="{$BtnCreateFolder}" type="submit">Mappa létrehozása</button>
				 <div class="clear"></div>
			</div>	 
        {else}
            <a class="submit btn" title="Regisztráció szükséges" href="{$DOMAIN}ceg/regisztracio/">Hozzáadás</a>
        {/if}
</form>
</div>

<a href="{$DOMAIN}szolgaltatasok/" class="accordionItem-title">3. lépés - Kérem a jelöltek elérhetőségét!</a>
