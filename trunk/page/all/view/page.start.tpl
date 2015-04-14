<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        {include file='page/all/view/page.included.tpl'}
        <script type="text/javascript">
        /*<![CDATA[*/
        var DOMAIN_ADMIN="{$DOMAIN}";
        /*]]>*/
        </script>
</head>
    
<body>
<div id="fb-root"></div>
<script type="text/javascript">
/*<![CDATA[*/
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/hu_HU/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
/*]]>*/
</script>
<p style="display: none;"><input type="hidden" id="DOMAIN" value="{$DOMAIN}"/></p>

{if $bgBannerList}
	{foreach from=$bgBannerList key=banner_for_id item=banner_lista}
		{if $banner_lista.banner_kep_nev}				
		<img src="{$DOMAIN}pic/banner/{$banner_lista.banner_kep_nev}_1920x1660_1" alt="{$banner_lista.banner_nev}" class="site-bg-1" />
		{/if}
	{/foreach}	
{/if}

<div class="siteWrapper">

	<div class="site_head_container start">
		
		<div class="head_content site_center"> 		
			<div class="row">
				<div class="col-lg-8">
					{$ErrorMessage}	
					<div class="search">       
						 <form action="kereses/" method="get" id="search">
							<div class="form-row clearfix form-group">
								<input type="text" class="search_field form-control" id="keresoszo" name="keresoszo" placeholder="Keresés az oldalon" />
								<button id="searchButton" class="search_button" type="submit" value="Keres"><span class="glyphicon glyphicon-search">&nbsp;</span></button>
								<div class="clear"></div>
							</div>
						</form>	            
					</div>								
					<div class="clear"></div>	
				</div>
				<div class="col-lg-1">
					{if $loggedIn != "1"}
						<a href="{$DOMAIN}?type=cl" class="page-select-link" title="Nyitólap"> Nyitólap</a>
					{/if}
				</div>
				<div class="col-lg-6 site_logo_cont">
					<a href="{$DOMAIN}"><img src="images/site/site_logo_2.png" alt="" class="site_logo" /></a>	
				</div>
				<div class="col-lg-8">
					<div class="login">	
						{if $LogoutForm}								
							{$LogoutForm}
							{include file="modul/user/view/partial/user_profile.tpl"}
						{else}
						<div class="loginBtns">
							<a data-toggle="modal" href="#popUpLoginForm-modal" onclick="setTimeout(function(){ $('#popUpLoginForm-modal').appendTo('body').modal('show'); },100);">
							<button class="btn loginBtn" id="Login" name="Login" value=""  data-toggle="tooltip" data-placement="top" 
							title="A belépéshez kattints ide, majd add meg az adataidat!"  >Bejelentkezés</button>
							</a>
							<div id="popUploginForm" title="Bejelentkezés" style="display:none;">
								{$LoginForm}
							</div>					
							<a class="btn btn-default" href="regisztracio/" role="button" >
							Regisztráció
							</a>
						</div>	
						{/if}							
					</div>
				</div>
				<div class="col-lg-1">
					<a href="javascript:;"><img src="images/site/akadalymentes-logo.png" alt="" class="akadalymentes-logo" /></a>	
				</div>
				<div class="clear"></div> 
			</div>
			
			<div class="row menu-row">
				<div class="menu-left-bg"></div>
				<div class="menu-right-bg"></div>
				<div class="col-lg-9"><div class="menu_table">{$Menu_1}</div></div>
				<div class="col-lg-6"></div>
				<div class="col-lg-9"><div class="menu_table">{$Menu_30}</div></div>
				<div class="clear"></div> 
			</div>							
			
			<div class="clear"></div> 			
		</div>
		
	</div>		
			
	<div class="site_body_container start">	
		<div class="site_content site_center">  
			<div class="site_content_inner">           
				
					{$ErrorMessage_}
					<div class="mainContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="h1-table">
							<tr>
							<td class="h1-td">&nbsp;</td>
							<td class="h1-td-center"><h1>{$PageName}</h1></td>
							<td class="h1-td">&nbsp;</td>
							</tr>
						</table>
									
						{$text}
					</div>
					
					<div class="jobCircle-cont">
						<a href="{$DOMAIN}tevekenysegikor-kereso/" class="jobCircle jobCircle-1">
							<span class="jobCircle-content">								
								<span class="jobCircle-text-1">Ismerd meg a munkakört</span>
								<span class="jobCircle-text-2">Biztos ezt szeretnéd csinálni?</span>
							</span>							
						</a>	
						<a href="{$DOMAIN}kompetenciak/tesztek" class="jobCircle jobCircle-2">									
							<span class="jobCircle-content">
								<span class="jobCircle-text-1">Vizsgáld meg<br /> magad!</span>
								<span class="jobCircle-text-2">Biztos alkalmas vagy<br /> erre a feladatra?</span>
							</span>						
						</a>
						<a href="{$DOMAIN}allaskereses/" class="jobCircle jobCircle-3">						
							<span class="jobCircle-content">								
								<span class="jobCircle-text-1">Keress az<br /> álláshírdetések<br/> között!</span>
								<span class="jobCircle-text-2">Válassz munkáltatót!</span>
							</span>							
						</a>	
						<a href="{$DOMAIN}kompetenciak/kompetenciarajz/" class="jobCircle jobCircle-4">
							<span class="jobCircle-content">							
								<span class="jobCircle-text-1">Készítsd el<br /> kompetencia<br /> profilod!</span>
								<span class="jobCircle-text-2">Hogy rád találjon a munáltató!</span>
							</span>								
						</a>									
						<a href="{$DOMAIN}keszulj-az-allasinterjura" class="jobCircle jobCircle-5">
							<span class="jobCircle-content">								
								<span class="jobCircle-text-1">Készülj az<br /> állásinterjúra!</span>
								<span class="jobCircle-text-2">További segítség a sikeres elhelyezkedéshez</span>
							</span>								
						</a>					
						<a href="{$DOMAIN}en/" class="jobCircle jobCircle-6">						
							<span class="jobCircle-content">
								<span class="jobCircle-text-1">ÉN<br/>Profil</span>								
							</span>							
						</a>
					</div>	
					<div class="clear"></div>
				
				<div class="clear"></div>	
			</div>
		</div>	
	</div>				
	 
					
	<div class="site_footer_container">
		<div class="footer site_center">							
			<div class="footer-middle">
				<div class="footerBoxElement">                               
					<div class="newsLetter">
						{$HirlevelFeliratkozas}
					</div>                               
				</div>
				<div class="footerBoxElement">
						<div class="{$FBLike.class}" data-href="{$FBLike.url}" data-width="{$FBLike.width}" data-height="{$FBLike.height}" data-colorscheme="{$FBLike.colorscheme}" data-show-faces="{$FBLike.show_faces}" data-header="{$FBLike.header}" data-stream="{$FBLike.stream}" data-show-border="{$FBLike.show_border}"></div>
				</div>
				<div class="footerBoxElement">
					<a href="http://nfu.hu"><img src="images/site/nfu.png" alt="" class="nfu_img" /></a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="site_bottom"></div>						
			<div class="footer-menu">
				<ul class="footer-nav">
				{foreach from=$footerMenu item=menu}
						<li><a href="{$menu.menu_link}">{$menu.menu_nev}</a></li>
				{/foreach}
				</ul>
			</div>      
		  </div>	
	</div>	
	
	
	<div class="footer-bottom-cont">
		<div class="footer-bottom site_center">
			<div class="copyright">  
				<span class="copyright-blinding"> &copy; E-karrier </span> Minden jog fenntartva! / All rights reserved!  
			</div>
			<div class="uniweb_logo"><a href="http://www.uniweb.hu/" target="_blank"><img src="{$DOMAIN}images/site/uniweb_logo.png" alt="uniweb logo" /></a></div>
			<div class="clear"></div> 
		</div>
	</div>	

</div>

<script type="text/javascript">
{literal} 
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48400163-1', 'ekarrier.hu');
  ga('send', 'pageview');
{/literal} 
</script>

</body>
</html>