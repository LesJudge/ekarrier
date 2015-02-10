<div class="field"> 
        <div class="form_row">
                <label for="userUsername">
                        Felhasználónév
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="userUsername" name="user[user_fnev]" type="text" value="{$user->user_fnev}">
                {if is_object($user->errors) and $user->errors->on('user_fnev')}<p class="error small">{$user->errors->on('user_fnev')}</p>{/if} 
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userPassword">Jelszó</label>
                <input type="password" id="userPassword" name="user[user_jelszo]" value="">
                {if is_object($user->errors) and $user->errors->on('user_jelszo')}<p class="error small">{$user->errors->on('user_jelszo')}</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userPasswordAgain">
                        Jelszó mégegyszer
                        <span class="require">*</span><!--/.require-->
                </label>
                <input type="password" id="userPasswordAgain" name="passwordAgain" value="">
                {if $passwordAgainError}<p class="error small">A jelszavak nem egyeznek!</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="{$SelGroup.name}">
                        Jogosultsági csoport
                        <span class="require">*</span><!--/.require-->
                </label>
                {html_options multiple name="groups[]" options=$userGroups selected=$activeGroups}
                {if isset($SelGroup.error)}<p class="error small">{$SelGroup.error}</p>{/if} 
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row" style="display:none;">
                <label for="userLanguage">
                        Kapcsolat nyelve
                        <span class="require">*</span><!--/.require-->
                </label>
                {html_options name="user[nyelv_id]" options=$languages selected=$user->nyelv_id} 
                {if is_object($user->errors) and $user->errors->on('nyelv_id')}<p class="error small">{$user->errors->on('nyelv_id')}</p>{/if} 
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
</div><!--/.field-->