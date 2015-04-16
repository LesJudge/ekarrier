
<div class="welcome-box">		
	<ul class="nav welcome-box-nav">           
		<li class="dropdown">
			<form action="" method="post" name="{$FormName}" id="{$FormName}" class="logoutform">		
			<a data-toggle="dropdown" class="dropdown-toggle welcome-text" href="#">Üdvözöljük <span>{$felhasznalonev}!</span> <b class="caret"></b></a>
			<ul class="dropdown-menu extended logout">                    
				{if $userMenu}                               
					{foreach from=$userMenu item=menu}
							<li class="lang-select smallLangSelect dropdown"><a href="{$DOMAIN}{$menu.menu_link}">{$menu.menu_nev}</a></li>
					{/foreach}					   
				{/if}				          
				<li>
					<button  class="btn btn-block btn-sm btn-danger" id="{$BtnLogout}" type="submit" name="{$BtnLogout}">Kilépés </button>					
				</li>
			</ul>
			</form>
		</li>           
	</ul>
</div>
<div class="clear"></div>
		
		
		

<!--
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

-->
