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
    
<body class="page-select">
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
		<a href="{$DOMAIN}"><img src="images/site/start_logo.png" alt="" class="site_logo" /></a>				
		<div class="clear"></div> 			
	</div>
</div>
	
		        
        
<div class="site_body_container">	
	<div class="site_content site_center">     
		{$ErrorMessage}
		<a href="{$DOMAIN}?type=mv" class="start-infobox"><span class="start-infobox-bub start-infobox-bub-1"><span class="start-infobox-bub-arrow"></span> <span class="start-infobox-logo"></span><span class="start-infobox-data-title">{$munkavallaloInfo.infobox_nev} </span>  <span class="start-infobox-data">{$munkavallaloInfo.infobox_tartalom}</span> </span> <img src="images/site/start_mv.png" alt="" class="start-logo" /><span class="start-infobox-name start-infobox-name-1">Álláskereső</span> </a>
		<a href="{$DOMAIN}?type=ma" class="start-infobox"><span class="start-infobox-bub start-infobox-bub-2"><span class="start-infobox-bub-arrow"></span> <span class="start-infobox-logo"></span><span class="start-infobox-data-title">{$munkaltatoInfo.infobox_nev} </span>  <span class="start-infobox-data">{$munkaltatoInfo.infobox_tartalom} </span> </span> <img src="images/site/start_ma.png" alt="" class="start-logo" /> <span class="start-infobox-name start-infobox-name-2">Munkáltató</span></a>  
		<div class="clear"></div>  
		<div class="start-impressum-cont">
			<div class="start-impressum start-impressum-1">
				<span>Székhely és levelezési cím:</span> 	4025 Debrecen, Arany János u. 2. sz.<br/>
				<span>Székhely telefonszáma:</span> 		+36-52-530-895<br/>
				<span>Székhely faxszáma:</span> 		+36-52-530-896<br/>
				<span>Székhely mobilszáma:</span> 		+36 20 469 9634<br/>
				<span>Ügyfélfogadási idő:</span> 		H-CS: 8:00-16:00,  P: 8:00-14:00
			</div> 		
			<div class="start-impressum start-impressum-2">
				<span>Berettyóújfalui iroda:</span>  		   4100 Berettyóújfalu, József Attila u. 35.<br/>
				<span>Berettyóújfalui iroda telefonszáma:</span>  	   +36 20 424 8480<br/>
				<span>Berettyóújfalui iroda ügyfélfogadás:</span>  	   H-P: 8:00-16:00<br/>
				<span>A CSAT Egyesület weboldala:</span>  	   <a href="http://www.csat.hu" target="_blank">www.csat.hu</a><br/>
				<span>A CSAT Egyesület e-mail címe:</span>  	  
				<script type="text/javascript">
				  $(function(){	
					var em1 = "info";
					var em2 = "@";
					var em3 = "csat.hu";
					$(".start-impressum-email").html('<a href=\"mailto:' + em1 + em2 + em3 +'\">'+ em1 + em2 + em3+'<\/a>');
				  });			
			   </script>	
				<span class="start-impressum-email">email</span> 
			</div> 	
			<div class="clear"></div> 	
		</div>	  
    </div>	
</div>				
 
                
<div class="site_footer_container">
    
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