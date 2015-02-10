<div class="field">
        <div class="form_row">
                <label for="userLastname">
                        Vezetéknév
                        <span class="require">*</span><!--/.require-->
                </label>
                <input type="text" id="userLastname" name="user[user_vnev]" value="{$user->user_vnev}">
                {if is_object($user->errors) and $user->errors->on('user_vnev')}<p class="error small">{$user->errors->on('user_vnev')}</p>{/if} 
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userFirstname">
                        Keresztnév
                        <span class="require">*</span><!--/.require-->
                </label>
                <input type="text" id="userFirstname" name="user[user_knev]" value="{$user->user_knev}">
                {if is_object($user->errors) and $user->errors->on('user_knev')}<p class="error small">{$user->errors->on('user_knev')}</p>{/if} 
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userEmail">
                        E-mail cím
                        <span class="require">*</span><!--/.require-->
                </label>
                <input type="text" id="userEmail" name="user[user_email]" value="{$user->user_email}">
                {if is_object($user->errors) and $user->errors->on('user_email')}<p class="error small">{$user->errors->on('user_email')}</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userTel">
                        Telefonszám
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="userTel" name="user[user_tel]" type="text" value="{$user->user_tel}" />
                {if is_object($user->errors) and $user->errors->on('user_tel')}{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userAddress">
                        Lakcím
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="userAddress" name="user[user_lakcim]" type="text" value="{$user->user_lakcim}" />
                {if is_object($user->user_lakcim) and $user->errors->on('user_lakcim')}<p class="error small">{$user->errors->on('user_lakcim')}</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userBirthplace">
                        Születési hely
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="userBirthplace" name="user[user_szul_hely]" type="text" value="{$user->user_szul_hely}" />
                {if is_object($user->user_szul_hely) and $user->errors->on('user_szul_hely')}<p class="error small">{$user->errors->on('user_szul_hely')}</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userBirthdate">
                        Születési idő
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="userBirthdate" name="user[user_szul_date]" type="text" value="{$user->user_szul_date}" />
                {if is_object($user->errors) and $user->errors->on('user_szul_date')}<p class="error small">{$user->errors->on('user_szul_date')}</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
</div><!--/.field-->
<div class="field">
        <div class="form_row">
                <label>
                        Hírlevélre feliratkozott
                        <span class="require">*</span><!--/.require-->
                </label>
                {html_radios name="user[user_hirlevel]" options=$activeValues selected=$user->user_hirlevel}
                {if is_object($user->errors) and $user->errors->on('user_hirlevel')}<p class="error small">{$user->errors->on('user_hirlevel')}</p>{/if} 
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label>
                        Publikus
                        <span class="require">*</span><!--/.require-->
                </label>
                {html_radios name="user[user_aktiv]" options=$activeValues selected=$user->user_aktiv}
                {if is_object($user->errors) and $user->errors->on('user_aktiv')}<p class="error small">{$user->errors->on('user_aktiv')}</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
</div><!--/.filed-->