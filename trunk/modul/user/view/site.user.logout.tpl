<div class="logoutbox">	
        <h3 class="boxForm-form-title">Üdvözöljük {$felhasznalonev}!</h3>
        <form action="" method="post" name="{$FormName}" id="{$FormName}" class="boxForm-form">		
                <div class="form-row clearfix">
                        {if $userMenu}
                                <ul>
                                {foreach from=$userMenu item=menu}
                                        <li><a href="{$DOMAIN}{$menu.menu_link}">{$menu.menu_nev}</a></li>
                                {/foreach}
                                </ul>
                        {/if}
                </div>
                
                <div class="form-row clearfix">            	
                        <button  class="submit" id="{$BtnLogout}" type="submit" name="{$BtnLogout}">Kilépés </button>
                        <div class="clear"></div>
                </div>        
        </form>
        <div class="clear"></div>
</div>


