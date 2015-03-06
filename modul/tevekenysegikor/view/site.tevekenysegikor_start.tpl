{if $FormError}
 <div class="info info-error">
    <p><img src="images/site/form-error.png" style="float:left; margin:5px;"/>{$FormError}</p>
</div> 
<div class="clear"></div>
{/if}
{if $FormMessage}
<div id="form_info" class="info info-success">
    <p>{$FormMessage}</p>
</div>
<div class="clear"></div>
{/if}

<div class="jobCircle-cont">
	<div>
        {$text}
        </div>
        <br/><br/><br/>
	<a href="{$DOMAIN}keszulj-az-allasinterjura" class="jobCircle jobCircle-1">
		<span class="jobCircle-panel">
			<span class="jobCircle-top">5.</span>
			<span class="jobCircle-content">
				<img src="images/site/munkakor_img_1.jpg" alt="" />
				<span class="jobCircle-text-1">Készülj az állásinterjúra!</span>
				<span class="jobCircle-text-2">További segítség a sikeres elhelyezkedéshez</span>
			</span>		
		</span>	
		<span class="jobCircle-shadow"></span>
	</a>
	<div class="rotateImg rotateImg-1"></div>
	<a href="{$DOMAIN}tevekenysegikor-kereso/" class="jobCircle jobCircle-2">
		<span class="jobCircle-panel">
			<span class="jobCircle-top">1.</span>
			<span class="jobCircle-content">
				<img src="images/site/munkakor_img_2.jpg" alt="" />
				<span class="jobCircle-text-1">Ismerd meg a munkakört</span>
				<span class="jobCircle-text-2">Biztos ezt szeretnéd csinálni?</span>
			</span>		
		</span>	
		<span class="jobCircle-shadow"></span>
	</a>
	<div class="rotateImg rotateImg-2"></div>
	<a href="{$DOMAIN}kompetenciak/tesztek" class="jobCircle jobCircle-3">
		<span class="jobCircle-panel">
			<span class="jobCircle-top">2.</span>
			<span class="jobCircle-content">
				<img src="images/site/munkakor_img_3.jpg" alt="" />
				<span class="jobCircle-text-1">Vizsgáld meg magad!</span>
				<span class="jobCircle-text-2">Biztos alkalmas vagy erre a feladatra?</span>
			</span>		
		</span>	
		<span class="jobCircle-shadow"></span>
	</a>
	
	<div class="clear"></div>
	
	
	<div class="rotateImg rotateImg-3"></div>
	<a href="{$DOMAIN}kompetenciak/kompetenciarajz/" class="jobCircle jobCircle-4">
		<span class="jobCircle-panel">
			<span class="jobCircle-top">4.</span>
			<span class="jobCircle-content">
				<img src="images/site/munkakor_img_4.jpg" alt="" />
				<span class="jobCircle-text-1">Készíts el kompetencia profilod!</span>
				<span class="jobCircle-text-2">..hogy rád találjon a munáltató</span>
			</span>		
		</span>	
		<span class="jobCircle-shadow"></span>
	</a>
	<div class="rotateImg rotateImg-4"></div>
	<a href="{$DOMAIN}allaskereses/" class="jobCircle jobCircle-5">
		<span class="jobCircle-panel">
			<span class="jobCircle-top">3.</span>
			<span class="jobCircle-content">
				<img src="images/site/munkakor_img_5.jpg" alt="" />
				<span class="jobCircle-text-1">Keress az álláshírdetések között!</span>
				<span class="jobCircle-text-2">Válassz munkáltatót!</span>
			</span>		
		</span>	
		<span class="jobCircle-shadow"></span>
	</a>
	<div class="rotateImg rotateImg-5"></div>
	<a href="{$DOMAIN}en/" class="jobCircle jobCircle-6">
		<span class="jobCircle-panel">
			<span class="jobCircle-content">
				<span class="jobCircle-text-1">Saját profilom!</span>
			</span>		
		</span>	
		<span class="jobCircle-shadow"></span>
	</a>
	<div class="clear"></div>
</div>	
                
{include file = "modul/ugyfellinkek/view/site.ugyfellinkek.tpl"}