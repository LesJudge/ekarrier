<script type="text/javascript">
$(function() { {$FormScript} });
</script>
<div id="wrap" class="container_24">
    <div class="login">
                        {include file='page/admin/view/admin.message.tpl'} 
        <div id="header">
        	<a id="logo" href="#">Admin Panel</a>
            <form action="" method="post" name="{$FormName}" id="{$FormName}" class="loginform">
			<div class="form-row">
                        <label for="{$TxtFnev.name}" class="label_username">Felhasználónév </label>
                        <input type="text" id="{$TxtFnev.name}" name="{$TxtFnev.name}" value="{$TxtFnev.activ}" class="password tip" title="Kérjük írja be felhasználónevét" />
                        {if isset($TxtFnev.error)}<div class="ui-state-error">{$TxtFnev.error}<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"/></span></div>{/if}
            </div>
            <div class="form-row">
                        <label for="{$PassJelszo.name}" class="label_password">Jelszó</label>
                        <input type="password" id="{$PassJelszo.name}" name="{$PassJelszo.name}" value="{$PassJelszo.activ}"  class="password tip" title="Írja be jelszavát">
                        {if isset($PassJelszo.error)}<div class="ui-state-error">{$PassJelszo.error}<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"/></span></div>{/if}  
			</div>
                        <input type="submit" title="Belépés" class="tip" name="{$BtnLogin}" id="{$BtnLogin}" value="Belépés" />
            </form>
        </div>
        <div id="breadcrumb">
<!--			<ul class="left">
				<li class="icon key"><a href="#">Elfelejtette a jelszavát?</a></li>
			</ul>-->
			<ul class="right">
				<li><a title="Home" class="icon home tip" href="#">Kezdőlap</a></li>
			</ul>
		</div>
    </div>
</div>