<div class="field"> 
        <div class="form_row">
                <label for="userUsername">Felhasználónév</label>
                <input id="userUsername" name="user[user_fnev]" type="text" value="{$user->user_fnev}">
                {ar_error model=$user property='user_fnev' view='admin_ar_error.tpl'}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userPassword">Jelszó</label>
                <input id="userPassword" name="user[user_jelszo]" type="password" value="">
                {ar_error model=$user property='user_jelszo' view='admin_ar_error.tpl'}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="userPasswordAgain">Jelszó mégegyszer</label>
                <input type="password" id="userPasswordAgain" name="passwordAgain" value="">
                {if $passwordAgainError}<p class="error small">A jelszavak nem egyeznek!</p>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <!--
        <div class="form_row" style="display:block;">
                <label for="userLanguage">Kapcsolat nyelve</label>
                {**html_options name="user[nyelv_id]" options=$languages selected=$user->nyelv_id**} 
                {**ar_error model=$user property='nyelv_id' view='admin_ar_error.tpl'**}
        </div>
        <div class="clear"></div>
        -->
</div><!--/.field-->