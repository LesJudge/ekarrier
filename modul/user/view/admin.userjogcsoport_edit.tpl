<script type="text/javascript">
   $(function() { {$FormScript}
       $('select[name="{$SelSiteTipus.name}"]').change(function() { $('#{$BtnReload}').click(); });
	    $("div.tabs").tabs();
   });
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
   <div class="grid_24">
      <div class="box_top">
         <h2 class="icon time">Jogosultság csoport - [{$edit_mode}]</h2>
      </div>
      <div class="box_content padding">
         {include file='page/admin/view/admin.message.tpl'}
         {include file='page/admin/view/admin.edit_events.tpl'} 
         <div class="field">
            <div class="form_row">
               <label for="{$TxtNev.name}">Név <span class="require">*</span></label>
               <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}">
               {if isset($TxtNev.error)}
               <p class="error small">{$TxtNev.error}</p>
               {/if} 
            </div>
            <div class="clear"></div>
            <div class="tabs">
               <ul class="tabs ">
                  <li><a href="#tabs-1">Admin jogok</a></li>
                  <li><a href="#tabs-2">Site jogok</a></li>
               </ul>
               <div class="field" id="tabs-1">
                  <div class="form_row">
                     <label for="{$SelJogAdmin.name}">Admin jogok</label>
                     <div class="wide">
                        {html_checkboxes name=$SelJogAdmin.name options=$SelJogAdmin.values selected=$SelJogAdmin.activ separator=''}
                        {if isset($SelJogAdmin.error)}
                        <p class="error small">{$SelJogAdmin.error}</p>
                        {/if}
                     </div>
                  </div>
                  <div class="clear"></div>
               </div>
               <div class="field" id="tabs-2">
                  <div class="form_row">
                     <label for="{$SelJogSite.name}">Site jogok</label>
                     <div class="wide">
                        {html_checkboxes name=$SelJogSite.name options=$SelJogSite.values selected=$SelJogSite.activ separator=''}
                        {if isset($SelJogSite.error)}
                        <p class="error small">{$SelJogSite.error}</p>
                        {/if}
                     </div>
                  </div>
                  <div class="clear"></div>
               </div>
            </div>
            <div class="form_row">
               <label>Publikus</label>
               {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
               {if isset($ChkAktiv.error)}
               <p class="error small">{$ChkAktiv.error}</p>
               {/if} 
            </div>
            <div class="clear"></div>
         </div>
      </div>
   </div>
</form>