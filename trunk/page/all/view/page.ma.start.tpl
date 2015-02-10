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
    
<body class="page-ma page-ma-start">
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

<div class="site_head_container start">
	<div class="head_content site_center"> 		
		<span class="headSlogen"></span>
		<a href="{$DOMAIN}"><img src="images/site/site_logo.png" alt="" class="site_logo" /></a>				
		<div class="main_menu"> {$Menu_23} </div>							
		<div class="box-login-itmes">			
			<div class="page-nav-cont">
				<!--<a href="{$DOMAIN}?type=mv" class="btn btn-primary btn-xs" title="Munkavállalói oldal"> Munkavállaló</a>
				<a href="{$DOMAIN}?type=ma" class="btn btn-primary btn-xs" title="Munkavállalói oldal"> Munkaadó</a>-->
                                {if $loggedIn != "1"}
                                <a href="{$DOMAIN}?type=cl" class="btn btn-primary btn-xs" title="Nyitólap"> Nyitólap</a>
                                {/if}
			</div>
			{if $LoginForm}
			<script type="text/javascript">
				function loginDialog(){
					$("#popUploginForm").dialog({ 	
						//autoOpen: false,							
						closeOnEscape: false,
						width: 380,								
						modal: true,								
						draggable: true,
						close: function (event, ui) {									
							$(this).dialog("close");							
						}																
					});
					return true;
				}						
				$(function(){
					$(".btn.loginBtn").bind("click",function(){
						loginDialog();
					});					
				});			
			</script>

			<div class="loginBtns">				
				<a href="javascript:;">
					<button class="btn loginBtn" id="Login" name="Login" value=""  data-toggle="tooltip" data-placement="bottom" 
					title="A belépéshez kattints ide, majd a bejelentkezési panelen add meg az adataidat!"  >
					<i class="icomoon icomoon-unlocked">&nbsp;</i> Bejelentkezés
					</button>
					<div id="popUploginForm" title="Bejelentkezés" style="display:none;">
						<div class="boxform">
						{$LoginForm}					
						</div>
					</div>    
				</a>
				<a class="btn btn-default" href="ceg/regisztracio/" role="button" >
					<i class="icomoon icomoon-user3">&nbsp;</i>Regisztráció
				</a>
			</div>	
			{else}
			{$LogoutForm}	
			{include file="modul/user/view/partial/user_profile.tpl"}
			{/if}
			<!-- 
			{$ErrorMessage}		
			<form action="" method="get" id="search">	
				  <div class="form-row clearfix">
					<input type="text" class="search_field autoclear" id="keresoszo" name="" value="Keresés" />						 
					<button class="submit search_button no_fix" onclick="if(($('#keresoszo').val()!='')&amp;&amp;($('#keresoszo').val()!='Keresés')){ window.location = '{$DOMAIN}kereses/'+$('#keresoszo').val(); }"  name="{$BtnLogin}" type="button" value="Keresés">Keresés</button>
					<div class="clear"></div>
				  </div>
			</form>		
			-->					
			<div class="clear"></div>					
		</div> 			
	</div>
</div>
	
<div class="site_slider_container">
	<div class="site_center"> 	
		<div class="banner-top">		
			{if $felsoBannerList}			
			<ul class="bxslider">
			{foreach from=$felsoBannerList key=banner_for_id item=banner_lista}
				{if $banner_lista.banner_kep_nev}
				<li>
					<a href="{$banner_lista.banner_link}">
						<img src="{$DOMAIN}pic/banner/{$banner_lista.banner_kep_nev}_946x325_1" alt=" " />
					</a>
				</li>
				{/if}
			{/foreach}						 		  
			</ul>
			{/if}
			<div class="banner-bottom"><span class="stat-item"> Összes - <span>{$countAllClients[0]['db']}</span></span> <span class="stat-item"> Dolgozik - <span>{$countWorkingClients[0]['db']}</span></span>	</div>	
			<div class="clear"></div> 		
		</div>		
	</div>
</div>			        
        
<div class="site_body_container">	
	<div class="site_content site_center">                 
		<div class="column-1">
			{$ErrorMessage}
			<div class="mainContent">
				<h1>{$PageName}</h1>
				{$Content}
				<div class="clear"></div>
			</div>
			
			<div class="boxType boxType-2">
				<h2>{$hirek}Legutóbbi hírek</h2>
				{foreach from=$newHirList key=hir_for_id item=hir_lista name=hir_lista}
				<div class="newsList">						
					<a href="hirek/{$hir_lista.hir_link}" class="newsList-frame"><img class="newsList-img" alt="{$hir_lista.hir_cim}" src="{if $hir_lista.hir_kep_nev}{$DOMAIN}pic/hir/{$hir_lista.hir_kep_nev}_104x68{else}images/site/no_image.jpg{/if}" /></a>
					<div class="newsList-data">
						<a href="hirek/{$hir_lista.hir_link}" class="newsList-title">{$hir_lista.hir_cim}</a>
						<div class="newsList-lead">{$hir_lista.hir_leiras_min}</div>
						<a href="hirek/{$hir_lista.hir_link}" class="newsList-next">Részletek</a>
					</div>
					<div class="clear"></div>
				</div>                         
				{/foreach}
			</div>	
			<div class="clear"></div>		
		</div>
        <div class="column-2">
			
			<div class="boxForm">					
				<h3 class="boxForm-form-title">Keresés munkakör szerint</h3>
                                							
				<form action="" method="post" name="SearchForm" id="SearchForm" class="boxForm-form">	
					<div class="form-row">        
						<input type="text" name="searchWord" value="" class="text labelInField" />
						<div class="clear"></div>
                                                {foreach from=$munkakorResult key=key item=val}
                                                <div>{$val['munkakor_nev']} ({$val['db']} találat)</div>
                                                {/foreach}
					</div>
					<div class="form-row form-row-submit">
						<button class="submit" id="BtnSearchMunkakor" name="BtnSearchMunkakor" type="submit" value="Keresés">Keresés</button>
						<div class="clear"></div>   
					</div>
                                    
					<div class="clear"></div>
				
                                </form> 
                               
			</div>	
				
		</div>
                        
		<div class="clear"></div>	
      </div>	
</div>				
 
                
<div class="site_footer_container">
    <div class="footer site_center">							
		<div class="footer-middle">
			<div class="footerBoxElement">                               
				<div class="impressum">
					<span class="impressum-title">CSAT Egyesület a Hátrányos Helyzetű Rétegek Munkaerőpiaci Csatlakozásáért</span>
					<br /><br />
					Székhely és levelezési cím: 
					4025 Debrecen, Arany János u. 2. sz.
					<br /><br />
					<span>Székhely telefonszáma:</span> 	+36-52-530-895<br />
					<span>Székhely faxszáma:</span>  		+36-52-530-896<br />
					<span>Székhely mobilszáma:</span>  	+36 20 469 9634<br />
					<span>Ügyfélfogadási idő:</span>  	H-CS: 8:00-16:00, P: 8:00-14:00
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
		<!--
		<div class="footer-menu">
			<ul class="footer-nav">
			{foreach from=$footerMenu item=menu}
					<li><a href="{$menu.menu_link}">{$menu.menu_nev}</a></li>
			{/foreach}
			</ul>
		</div>  
		-->    
      </div>	
</div>	


<div class="footer-bottom-cont">
	<div class="footer-bottom site_center">
		<div class="copyright">  
			<span class="copyright-blinding"> &copy; E-karrier </span> Minden jog fenntartva! / All rights reserved!  
		</div>
		<div class="uniweb_logo"><a href="http://www.uniweb.hu/" target="_blank"><img src="{$DOMAIN}images/site/ma_uniweb_logo.png" alt="uniweb logo" /></a></div>
		<div class="clear"></div> 
	</div>
</div>	

<!--
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
-->
</body>
</html>