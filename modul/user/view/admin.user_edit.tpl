<script type="text/javascript">
$(function() { {$FormScript}
    $('select[name="{$SelGroup.name}[]"]').multiselect();
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
      <div class="grid_18">
            <div class="box_top">
                  <h2 class="icon time">Felhasználó - [{$edit_mode}]</h2>
            </div>
            <div class="box_content padding"> {include file='page/admin/view/admin.message.tpl'}
				 {include file='page/admin/view/admin.edit_events.tpl'}
                  <div class="field"> 
                        <div class="form_row">
                            <label for="{$TxtFnev.name}">Felhasználónév <span class="require">*</span></label>
                            <input type="text" id="{$TxtFnev.name}" name="{$TxtFnev.name}" value="{$TxtFnev.activ}">
                            {if isset($TxtFnev.error)}
                            <p class="error small">{$TxtFnev.error}</p>
                            {/if} 
                        </div><div class="clear"></div>
                        <div class="form_row">
                              <label for="{$TxtEmail.name}">E-mail cím <span class="require">*</span></label>
                              <input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}" value="{$TxtEmail.activ}">
                              {if isset($TxtEmail.error)}
                              <p class="error small">{$TxtEmail.error}</p>
                              {/if} 
                        </div><div class="clear"></div>
                        <div class="form_row">
                            <label for="{$Password.name}">Jelszó</label>
                            <input type="password" id="{$Password.name}" name="{$Password.name}" value="{$Password.activ}">
                            {if isset($Password.error)}
                            <p class="error small">{$Password.error}</p>
                            {/if} </div>
                        <div class="clear"></div>
                        <div class="form_row">
                            <label for="{$Password2.name}">Jelszó mégegyszer <span class="require">*</span></label>
                            <input type="password" id="{$Password2.name}" name="{$Password2.name}" value="{$Password2.activ}">
                            {if isset($Password2.error)}
                            <p class="error small">{$Password2.error}</p>
                            {/if} </div>
                        <div class="clear"></div>
                        <div class="form_row">
                            <label for="{$SelGroup.name}">Jogosultsági csoport <span class="require">*</span></label>
                            {html_options multiple name=$SelGroup.name options=$SelGroup.values selected=$SelGroup.activ}
                            {if isset($SelGroup.error)}
                            <p class="error small">{$SelGroup.error}</p>
                            {/if} 
                        </div><div class="clear"></div>
                        <div class="form_row">
                            <label for="{$SelNyelv.name}">Kapcsolat nyelve <span class="require">*</span></label>
                            {html_options name=$SelNyelv.name options=$SelNyelv.values selected=$SelNyelv.activ} 
                            {if isset($SelNyelv.error)}
                            <p class="error small">{$SelNyelv.error}</p>
                            {/if} 
                        </div><div class="clear"></div>
                  </div>
                  <div class="field">
                        <div class="form_row">
                              <label for="{$TxtVnev.name}">Vezetéknév <span class="require">*</span></label>
                              <input type="text" id="{$TxtVnev.name}" name="{$TxtVnev.name}" value="{$TxtVnev.activ}">
                              {if isset($TxtVnev.error)}
                              <p class="error small">{$TxtVnev.error}</p>
                              {/if} 
                        </div><div class="clear"></div>
                        <div class="form_row">
                              <label for="{$TxtKnev.name}">Keresztnév <span class="require">*</span></label>
                              <input type="text" id="{$TxtKnev.name}" name="{$TxtKnev.name}" value="{$TxtKnev.activ}">
                              {if isset($TxtKnev.error)}
                              <p class="error small">{$TxtKnev.error}</p>
                              {/if} 
                        </div><div class="clear"></div>
                    </div>
                    <div class="field">
                        <div class="form_row">
                              <label>Hírlevélre feliratkozott</label>
                              {html_radios name=$ChkHirlevel.name options=$ChkHirlevel.values selected=$ChkHirlevel.activ}
                              {if isset($ChkHirlevel.error)}
                              <p class="error small">{$ChkHirlevel.error}</p>
                              {/if} 
                        </div><div class="clear"></div>
                        <div class="form_row">
                              <label>Publikus</label>
                              {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                              {if isset($ChkAktiv.error)}
                              <p class="error small">{$ChkAktiv.error}</p>
                              {/if} 
                        </div><div class="clear"></div>
                    </div>
            </div>
      </div>
      <!-- grid 18 vege -->
      {if isset($user_reg_date)}
      <div class="grid_6"> 
            <div class="box_top">
                  <h2 class="icon time">Információ</h2>
            </div>
            <div class="box_content padding">
                  <div class="form_row"> <strong>Regisztráció dátuma:</strong> {$user_reg_date} </div>
                  <div class="clear"></div>
                  <div class="form_row"> <strong>Megerősítés:</strong> {if $user_megerositve} {$user_megerositve_date} {/if} </div>
                  <div class="clear"></div>
                  <div class="form_row"> <strong>Utoljára belépve:</strong> {$user_last_login} </div>
                  <div class="clear"></div>
                  <div class="form_row"> <strong>Eddigi belépéseinek száma:</strong> {$user_szum_login} </div>
                  <div class="clear"></div>
            </div>
      </div>{/if}
</form>
