<div class="uw-ugyfelkezelo-form"> 
    <div class="uw-ugyfelkezelo-form-row">
        <label for="userUsername">{*$client->getAttributeLabel('user_fnev')*}</label>
        <!--<input id="userUsername" name="client[user_fnev]" type="text" value="{*$client->user_fnev*}">-->
        {*ar_error model=$client property='user_fnev' view='admin_ar_error.tpl'*}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="userPassword">{*$client->getAttributeLabel('user_jelszo')*}</label>
        <!--<input id="userPassword" name="client[user_jelszo]" type="password" value="">-->
        {*ar_error model=$client property='user_jelszo' view='admin_ar_error.tpl'*}
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label for="userPasswordAgain">Jelszó megerősítés</label>
        <input type="password" id="userPasswordAgain" name="passwordAgain" value="">
        {if $passwordAgainError}<p class="error small">A jelszavak nem egyeznek!</p>{/if}
    </div>
    <div id="sendMailRow" class="uw-ugyfelkezelo-form-row">
        <label>
            Belépési adatok elküldése e-mailben:
            <input name="sendMail" type="checkbox" checked />
        </label>
    </div>
</div>