<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        {include file='page/all/view/page.included.tpl'}
        <script type="text/javascript">
        var DOMAIN_ADMIN="{$DOMAIN}";
        </script>
        
        {foreach from=$head key=for_id item=headitem}
        {$headitem}
        {/foreach}
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

{include file="modul/user/view/partial/user_profile.tpl"}
<div class="site_head_container">
	<div class="head_content site_center"> 
		<div class="headArrow"></div>
		<span class="headSlogen"></span>
		<a href="{$DOMAIN}"><img src="images/site/site_logo.png" alt="" class="site_logo" /></a>				
		<div class="main_menu"> {$Menu_1}</div>
                <div class="main_menu" style="margin-top: 100px !important"> {$Menu_30}</div>
		<div class="box-search">
			<div class="page-nav-cont">
				<!--<a href="{$DOMAIN}?type=mv" class="btn btn-primary btn-xs" title="Munkavállalói oldal"> Munkavállaló</a>
				<a href="{$DOMAIN}?type=ma" class="btn btn-primary btn-xs" title="Munkavállalói oldal"> Munkaadó</a>-->
                                {if $loggedIn != "1"}
                                    <a href="{$DOMAIN}?type=cl" class="btn btn-primary btn-xs" title="Nyitólap"> Nyitólap</a>
                                {/if}
			</div>		
			{$ErrorMessage}		
			<form action="" method="get" id="search">	
				  <div class="form-row clearfix">
					<input type="text" class="search_field autoclear" id="keresoszo" name="" value="Keresés" />						 
					<button class="submit search_button no_fix" onclick="if(($('#keresoszo').val()!='')&amp;&amp;($('#keresoszo').val()!='Keresés')){ window.location = '{$DOMAIN}kereses/'+$('#keresoszo').val(); }"  name="{$BtnLogin}" type="button" value="Keresés">Keresés</button>
					<div class="clear"></div>
				  </div>
			</form>							
			<div class="clear"></div>							
		</div>
                      
                                        
                                    
                <!--<div>
                    {if $loggedIn}
                        <div style="background:lightgreen;position:absolute;top:150px;width:100%;height:35px;z-index:99;">
                            <span>Bejelentkezve, mint: {$userData.lastname} {$userData.firstname} ({$userData.username})</span>
                            <ul class="uw-nav-list uw-nav-list-inline-block floatRight">
                                <li>
                                    <a href="{$DOMAIN}munkakorok/">Munkakörök</a>
                                </li>
                                <li>
                                    <a href="{$DOMAIN}kompetenciak/">Kompetenciák</a>
                                </li>
                                <li>
                                    <a href="{$DOMAIN}munkaltato/">Munkáltató</a>
                                </li>
                                <li>
                                    <a href="{$DOMAIN}en/">Én</a>
                                </li>
                            </ul>
                        </div>
                    {else}
                    <a href="javascript:;" class="headLoginBtn"><script type='text/javascript'> raphaelSvgFontRender('headLoginBtn-icon',svgIcon.lock.vector,'32','32','S1,1,0,0','#fff'); </script>Bejelentkezés</a>			
                    <a href="javascript:;" class="headSearchBtn"><script type='text/javascript'> raphaelSvgFontRender('headSearchBtn-icon',svgIcon.magnifier_1.vector,'32','32','S1,1,0,0','#fff'); </script>Részletes keresés</a>                    
                    {/if}
                </div>-->
		<div class="clear"></div> 			
	</div>
</div>
	
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>    		        
        
<div class="site_body_container">	
	<div class="site_content site_center">                 
		<div class="column-0">
			{$ErrorMessage}
			<div class="mainContent">
				{if $PageName}
					<h1>{$PageName}</h1>
				{/if}
				
				{$kategoriaList}
				
				{$Content}
				<div class="clear"></div>
			</div>			
			<div class="clear"></div>		
		</div>
		
				
		
		<div class="clear"></div>	
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

<script>
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