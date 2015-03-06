{if not $isArchive}
<div>
    <a href="{$DOMAIN}allaskereses/archivum/" class="bigBtn-link">Archívum</a>
</div>
<br />
{/if}
<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    <div class="jobDataForm-cont hiddenLabels">
        <div class="jobDataForm-top"><i class='icomoon icomoon-search'>&nbsp;</i></div>
        <div class="form-cell-1">
            <div>
                <label>Szektor</label>
                {html_options name=$FilterSector.name id=$FilterSector.name options=$FilterSector.values selected=$FilterSector.activ}
            </div>
            <div>
                <label>Pozíció</label>
                {html_options name=$FilterPosition.name id=$FilterPosition.name options=$FilterPosition.values selected=$FilterPosition.activ}
            </div>
        </div>
        <div class="form-cell-1">
            <!--div>
                <label>Munkakör</label>
                {html_options name=$FilterJob.name id=$FilterJob.name options=$FilterJob.values selected=$FilterJob.activ}
            </div-->
               
            <div>
                <label>Tevékenységi csoport</label>
                {html_options name=$FilterTevCsoport.name id=$FilterTevCsoport.name options=$FilterTevCsoport.values selected=$FilterTevCsoport.activ}
            </div>
            <div>
                <label>Tevékenységi kör</label>
                {html_options name=$FilterTevKor.name id=$FilterTevKor.name options=$FilterTevKor.values selected=$FilterTevKor.activ}
            </div>
            <div>
                <label>Megye</label>
                {html_options name=$FilterCounty.name id=$FilterCounty.name options=$FilterCounty.values selected=$FilterCounty.activ}			
            </div>
        </div>
        <div class="form-cell-1">
            <div>
                <label for="{$FilterCity.name}">Város</label>    
                <input id="{$FilterCity.name}" name="{$FilterCity.name}" type="text" value="{$FilterCity.activ}" alt="" placeholder="Város" class="labelInField"  />
            </div>
        </div>
        <div class="form-cell-1">
            <div>
                {html_options name=$FilterEllenorzott.name id=$FilterEllenorzott.name options=$FilterEllenorzott.values selected=$FilterEllenorzott.activ}	
            </div>
        </div>
        <div class="form-cell-1">
            <input type="submit" value="Keres" class="submit btn-1" />			
        </div>
        <div class="form-cell-1">
            <input name="{$BtnFilterDEL}" class="submit btn-1" type="submit" value="Feltételek törlése" />
        </div>
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
        <input id="{$FilterLetter.name}" name="{$FilterLetter.name}" type="hidden" value="{$FilterLetter.activ}" />
    </div>
        
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
 </style>   
        
 <script type="text/javascript">
 $(document).ready(function(){
     
     $(".letter").each(function(){
        var val = $("#{$FilterLetter.name}").attr('value');
        if(val == $(this).text().toLowerCase())
        {
        $(this).addClass("activeLetter");
        }
     });
    

 });
 
 $(".letter").click(function(){
    
   $('.activeLetter').removeClass('activeLetter');
   $(this).addClass('activeLetter');
   
   var letter = $(this).text().toLowerCase();
   
  $('#{$FilterLetter.name}').attr('value',letter);
  
        
    });
 </script>
        
    {include file='page/all/view/page.message.tpl'}
    {include file='modul/allashirdetes/view/partial/site_allashirdetes_list.tpl'}
    {include file='page/all/view/page.paging.tpl'} 
</form>

{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}