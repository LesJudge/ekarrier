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

<div class="site_head_container start">
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
                                        
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                                        
		<!--div class="banner-top">				
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
		</div-->		
		<div class="clear"></div> 			
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
			<div class="boxType boxType-1">
				<h2>Hasznos tanácsok</h2>
				{if $usefulAdvices}
					<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="advice-table">
						{foreach from=$usefulAdvices item=advice name=adviceList}
						<tr>
							<td class="advice-td advice-td-left">
							<i id='check_{$smarty.foreach.adviceList.index}--check_2--16--16--S0.5:0.5:0:0--24c100--24c100' class='svgIcon'>&nbsp;</i>
							<td class="advice-td advice-td-right">
                                                                                                                                     <a href="{$DOMAIN}hirek/{$advice.hir_link}" class="newsList-title">{$advice.hir_cim}</a>
                                                                                                                                     <a href="{$DOMAIN}hirek/{$advice.hir_link}">
                                                                                                                                             <span class="advice-text">{$advice.hir_leiras}</span>
                                                                                                                                     </a>
                                                                                                                           </td>
						</tr>
						{/foreach}
					</table>							
				{else}
				 <div>Nincs megjeleníthető elem!</div>
				{/if}						
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
				{$LoginForm}							
				{$LogoutForm}
			</div>	
			<!--div class="boxForm">					
				<h3 class="boxForm-form-title">Részletes keresés</h3>
				<form action="" method="post" name="{$FormName}" id="{$FormName}" class="boxForm-form">	
					<div class="form-row">        
						<input type="text" name="{$TxtFnev.name}" value="munkavégzés helye..." class="text labelInField" alt="munkavégzés helye..." />
						<div class="clear"></div>
					</div>
					<div class="form-row">       
						<input type="text"  name="{$PassJelszo.name}" value="munka típusa..."  class="text labelInFieldPwd" alt="munka típusa..."/> 
						<div class="clear"></div> 
					</div>
					<div class="selectCont selectFilter_1">     
						 <select  class="select" name="{$FormKategoriaName}" id="{$FormKategoriaName}">						
						   <option value="0">Válasszon a listából</option>
						 </select>
					</div>
					<div class="clear"></div>	 
					<div class="selectCont selectFilter_1">     
						 <select  class="select" name="{$FormKategoriaName}" id="{$FormKategoriaName}">						
						   <option value="0">Válasszon a listából</option>
						 </select>
					</div>	
					<div class="clear"></div> 										
					<div class="form-row form-row-submit">
						<button class="submit" id="{$BtnLogin}" name="{$BtnLogin}" type="submit" value="Keresés">Keresés</button>
						<div class="clear"></div>   
					</div>		
					<div class="clear"></div>
				</form> 
			</div-->	
				
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