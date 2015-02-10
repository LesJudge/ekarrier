<div class="field">
    <div class="form_row">
            <label for="userLastname">
                    Vezetéknév
                    <span class="require">*</span><!--/.require-->
            </label>
            <input type="text" id="userLastname" name="user[user_vnev]" value="{$user->user_vnev}">
            {ar_error model=$user property='user_vnev' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
            <label for="userFirstname">
                    Keresztnév
                    <span class="require">*</span><!--/.require-->
            </label>
            <input type="text" id="userFirstname" name="user[user_knev]" value="{$user->user_knev}">
            {ar_error model=$user property='user_knev' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
            <label for="userEmail">
                    E-mail cím
                    <span class="require">*</span><!--/.require-->
            </label>
            <input type="text" id="userEmail" name="user[user_email]" value="{$user->user_email}">
            {ar_error model=$user property='user_email' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
            <label for="userTel">
                    Telefonszám
                    <span class="require">*</span><!--/.require-->
            </label>
            <input id="userTel" name="user[user_tel]" type="text" value="{$user->user_tel}" />
            {ar_error model=$user property='user_tel' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
            <label for="userAddress">
                    Lakcím
                    <span class="require">*</span><!--/.require-->
            </label>
            <input id="userAddress" name="user[user_lakcim]" type="text" value="{$user->user_lakcim}" />
            {ar_error model=$user property='user_lakcim' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
            <label for="userBirthplace">Születési hely</label>
            <input id="userBirthplace" name="user[user_szul_hely]" type="text" value="{$user->user_szul_hely}" />
            {ar_error model=$user property='user_szul_hely' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
            <label for="userBirthdate">Születési idő</label>
            <input id="userBirthdate" name="user[user_szul_date]" type="text" value="{$user->user_szul_date}" />
            {ar_error model=$user property='user_szul_date' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.field-->
<div class="field">
    <div class="form_row">
            <label>Hírlevélre feliratkozott</label>
            {html_radios name="user[user_hirlevel]" options=$activeValues selected=$user->user_hirlevel}
            {ar_error model=$user property='user_hirlevel' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
            <label>
                    Aktív felhasználó
                    <span class="require">*</span><!--/.require-->
            </label>
            {html_radios name="user[user_aktiv]" options=$activeValues selected=$user->user_aktiv}
            {ar_error model=$user property='user_aktiv' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
</div><!--/.filed-->
<script type="text/javascript">
/*<![CDATA[*/
$(function() {

    //$("#userBirthdate").datepicker();

});
/*]]>*/
</script>