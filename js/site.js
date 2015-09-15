function setLocation(url){
	window.location.href = url;
}

$.validator.setDefaults({
	highlight: function(input) { $(input).addClass("ui-state-error"); },
	unhighlight: function(input) { $(input).removeClass("ui-state-error"); },
    errorClass: "ui-state-error",
	validClass: "form-valid",
	errorElement: "div",
    errorObject: '',
    invalidHandler: function(form, validator) {
  }
});
var ikz = 0; // initialize
var int = 0; // Internet Explorer 



function renderBoxHeight(selectorStr){	
	var cnt1 = 0;
	var cnt2 = 0;
	var tallest = 0;		
	$("."+selectorStr).each(function(e){
		$(this).attr("itemId",(e+1));
		if ( $(this).attr("itemId") % 2 == 0 ){		
			cnt1 = cnt1 + 1;		
			$(this).attr("itemRow",cnt1);
		}
		if ( $(this).attr("itemId") % 2 == 1 ){		
			cnt2 = cnt2 +1;		
			$(this).attr("itemRow",cnt2);
		}			
	});			
	for (var i=1; i<=cnt2; i++) {
		var o = $("."+selectorStr+"[itemRow='"+i+"']");			
		$("."+selectorStr+"[itemRow='"+i+"']").each(function(e){
			var padding = parseInt($(this).css("padding-top"))+parseInt($(this).css("padding-bottom"));	
			if($(this).height()>=tallest+padding){
				tallest=$(this).height()+padding;	
			}				
		});
		o.css("height",tallest+"px");			
	}
	return false;
}	



function raphaelSvgIconRender(){			
	$(".svgIcon").each(function(e){
		var transText="";
		var vectorText="";
		var paper;
		var idArr=$(this).attr("id").split("--");
		if(idArr.length==7){
			idArr[0]=($("#"+idArr[0]).length!=0)?idArr[0]+"_"+e:idArr[0];
			$(this).attr("id",idArr[0]);	
						
			if (idArr[1].search(/\./i)==-1) {
				if ( eval("svgIcon."+idArr[1]) != "undefined") {					
					vectorText=eval("svgIcon."+idArr[1]+".vector");
					transText = idArr[4];
					idArr[4]=String(transText.replace(/:/gi, ",")); 
					idArr[5]=String("#"+idArr[5]); 
					idArr[6]=String("#"+idArr[6]); 
					
					paper = Raphael(idArr[0],idArr[2],idArr[3]); 			
					paper.path(vectorText).attr({fill:idArr[5], stroke:"none"}).hover(function() {	
						this.attr({fill:idArr[6], stroke:"none"});							
					}, function() {
						this.attr({fill:idArr[5], stroke:"none"});
					});
					paper.forEach(function(obj){
						obj.transform(idArr[4]);
					});						
					
				}
			}				
		}
	});	
	
}
$(window).load(function(){
	raphaelSvgIconRender();
});




(function() {
    var matched, browser;

    // Use of jQuery.browser is frowned upon.
    // More details: http://api.jquery.com/jQuery.browser
    // jQuery.uaMatch maintained for back-compat
    jQuery.uaMatch = function( ua ) {
        ua = ua.toLowerCase();

        var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
            /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
            /(msie) ([\w.]+)/.exec( ua ) ||
            ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
            [];

        return {
            browser: match[ 1 ] || "",
            version: match[ 2 ] || "0"
        };
    };

    matched = jQuery.uaMatch( navigator.userAgent );
    browser = {};

    if ( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }

    // Chrome is Webkit, but Webkit is also Safari.
    if ( browser.chrome ) {
        browser.webkit = true;
    } else if ( browser.webkit ) {
        browser.safari = true;
    }

    jQuery.browser = browser;
})();



function siteTabPager(){	
	 $this = this;
	 $this.mainWidth=$('.siteTabContainer').width();	
	 $this.itemWidth = $(".siteTab").width();
	 
	$itemCnt=0;
	$startPage =1;
	$animTime = 400;
	var slideHeightRenderTimer = 0;
	var bredCumbHref;
	
	 $this.start=function () {
		$(".siteTab").each(function(e1){
			$(this).attr("id","tabSection_"+(e1+1));	
			bredCumbHref = (typeof $(this).attr('siteTab-bredCumbHref') !== typeof undefined && $(this).attr('siteTab-bredCumbHref') !== false)?"href='"+$(this).attr('siteTab-bredCumbHref')+"'":"href='javascript:;'";
						
			$("<a "+bredCumbHref+" class='siteTab-bredcrumb' id='siteTab-bredcrumb-"+(e1+1)+"' siteTab-bredcrumb-rel='"+(e1+1)+"'>"+$(this).attr('siteTab-bredcrumb')+"</a>").appendTo( $( ".tabBreadcrumb" ) );			
			$("#siteTab-bredcrumb-"+$startPage).addClass("active");
			maxItem=e1;	
			
			$(".siteTabContainer").css({"height":"auto"});
		});					
	 }
	 
	 $this.slideHeightRender=function (itemCnt) {		 
		 
		slideHeightRenderTimer = setInterval(function(){
			$(".siteTabContainer").css({"height":$("#tabSection_"+itemCnt).height()});
			//console.log(itemCnt);
		},200);	
				
	 }
	 	 
	 $this.hideNav=function () {		 
		$(".siteTabNext_cover").css({'display':'block'});
		$(".siteTabBack_cover").css({'display':'block'});
		$(".tabBreadcrumb_cover ").css({'display':'block'});		
     }
	 
	 $this.showNav=function () {		 
		$(".siteTabBack_cover").css("display","none");
		$(".siteTabNext_cover").css("display","none");
		$(".tabBreadcrumb_cover ").css({'display':'none'});	
     }
	
	$this.toSlide=function (thisSelector) {	
	 	$this.hideNav();		
		
	 	if ($itemCnt<=maxItem) {
			$(".siteTab-bredcrumb").removeClass("active");			
			
			if (typeof $("#tabSection_"+thisSelector.attr("siteTab-bredcrumb-rel")).attr('siteTab-bredCumbHref') !== typeof undefined 
				&& $("#tabSection_"+thisSelector.attr("siteTab-bredcrumb-rel")).attr('siteTab-bredCumbHref') !== false) {
			
				$(".siteTabContainer").stop();
				$(window).stop();	
						
			}else {
				
				animLeft=(parseInt(thisSelector.attr("siteTab-bredcrumb-rel")-1)*($this.itemWidth));
				$itemCnt = parseInt(thisSelector.attr("siteTab-bredcrumb-rel"))-1;	
				
				clearInterval(slideHeightRenderTimer);
				$this.slideHeightRender(parseInt($itemCnt+1));
										
				$(".siteTabContainer").animate(
					{ left:  -animLeft},
					{ duration: $animTime, easing: 'easeInExpo',complete:function() {							
						if ($itemCnt==maxItem) { 
							$(".siteTabBack").css("display","block");
							$(".siteTabNext").css("display","none");			
						}	
						if ($itemCnt==0) { 
							$(".siteTabBack").css("display","none");
							$(".siteTabNext").css("display","block");				
						}
						if (($itemCnt>0)&&($itemCnt<maxItem)){				
							$(".siteTabBack").css("display","block");
							$(".siteTabNext").css("display","block");
						}					
						$this.showNav();
						$(".siteTab-title").text($("#siteTab-bredcrumb-"+($itemCnt+1)).text());
						thisSelector.addClass("active");								
					}}
				);	
				
			
			}
		}
		
	};
	
	 $this.next=function (thisSelector) {	
	 	$this.hideNav();
		$(".siteTab-bredcrumb").removeClass("active");	
		
	 	if ($itemCnt<maxItem) {
			
			if (typeof $("#tabSection_"+parseInt($itemCnt+1+1)).attr('siteTab-bredCumbHref') !== typeof undefined 
				&& $("#tabSection_"+parseInt($itemCnt+1+1)).attr('siteTab-bredCumbHref') !== false) {
				
				$("#siteTab-bredcrumb-"+parseInt($itemCnt+1+1)).addClass("active");
				document.location.href= $("#tabSection_"+parseInt($itemCnt+1+1)).attr('siteTab-bredCumbHref');
				
				$(".siteTabContainer").stop();
				$(window).stop();							
			}else {
				//console.log(1);
				clearInterval(slideHeightRenderTimer);
				$this.slideHeightRender(parseInt($itemCnt+1+1));
				
				animLeft=(parseInt($(".siteTabContainer").css('left'))-$this.itemWidth);
				$(".siteTabContainer").animate(
					{ left:  animLeft},
					{ duration: $animTime, easing: 'easeInExpo',complete:function() {								
						$(".siteTabBack").css("display","block"); 
						$this.showNav();
						$("#siteTab-bredcrumb-"+($itemCnt+1)).addClass("active");	
						//console.log(parseInt($itemCnt+1)+"; "+"#tabSection_"+parseInt($itemCnt+1));				
					}}
				);	
				$itemCnt++;		
			}
		}
		if ($itemCnt==maxItem) { 
			$(".siteTabNext").css("display","none");			
		}		
	};
	
	$this.prev=function (thisSelector) {		
		$this.hideNav();
		$(".siteTab-bredcrumb").removeClass("active");
		
	 	if ($itemCnt<=maxItem) {
			
			if (typeof $("#tabSection_"+parseInt($itemCnt+1-1)).attr('siteTab-bredCumbHref') !== typeof undefined 
				&& $("#tabSection_"+parseInt($itemCnt+1-1)).attr('siteTab-bredCumbHref') !== false) {
			
				$("#siteTab-bredcrumb-"+parseInt($itemCnt+1-1)).addClass("active");
				document.location.href= $("#tabSection_"+parseInt($itemCnt+1-1)).attr('siteTab-bredCumbHref');
				
				$(".siteTabContainer").stop();
				$(window).stop();	
						
			}else {
				clearInterval(slideHeightRenderTimer);
				$this.slideHeightRender(parseInt($itemCnt+1)-1);
				
				animLeft=(parseInt($(".siteTabContainer").css('left'))+$this.itemWidth);
				$(".siteTabContainer").animate(
					{ left:  animLeft},
					{ duration: $animTime, easing: 'easeInExpo',complete:function() {	
						$(".siteTabNext").css("display","block");	
						$this.showNav();
						$("#siteTab-bredcrumb-"+($itemCnt+1)).addClass("active");	
						//console.log("----> "+parseInt($itemCnt+1)+"; "+"#tabSection_"+parseInt($itemCnt+1));					
					}}
				);		
				$itemCnt--;	
			}
		}
		if ($itemCnt==0) { 
			$(".siteTabBack").css("display","none");			
		}				
	};
	
	 
}


$(function() {
	
	customIn=new customInputs({
		/*
		select : true,
		checkbox : true,
		allCheckbox : false,
		regularCheckbox : true,
		radio : true,		
		allRadio : true,
		file : true	
		*/
		
		
		
		select : true,
		selectType_1 : ".select-type-1",	
		selectType_2 : ".select-type-2",	
		allSelect : false,	
		checkbox : true,
		allCheckbox : true,
		regularCheckbox : true,
		radio : true,		
		file : true
	
		
	});
	customIn.start();
	
	
	
  //$('#menu_1').superfish();  
  
  $("A[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'facebook',slideshow:6000, default_width: 700, autoplay_slideshow: false, social_tools:false,deeplinking: false, show_title:false, allow_resize: true });
  
  $("[data-toggle='tooltip'][title]").tooltip();
  
    //$labelInField=new labelInFieldFn();				
    //$labelInField.start($('.labelInField'), $('.labelInFieldPwd'));	
	
	
	$('.tip').tip({tipType:"top",arrowType:"leftBottom"});	
	
	var slider = $('.bxslider').bxSlider({
		//mode: 'horizontal',
		mode: 'fade',
		useCSS: false,
		infiniteLoop: true,
		hideControlOnEnd: false,
		easing: 'easeInOutExpo',
		speed: 1000,
		captions: false,
		auto: true,	  
		controls: true,
		pause: 4000	
	});
	$('.bx-pager-link, .bx-controls-direction A').click(function () {
		var i = $(this).attr('data-slide-index');
		slider.goToSlide(i);
		slider.stopAuto();
		slider.startAuto();
		return false;
	});
	
	
	$('.compQuestion-cont').css('left', ( $(window).width()-$('.site_center').width())/2-27+'px' );
	
  
    $("form input").keypress(function (e) {
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
			$(this).parents("form").find('.submit').click();
			return false;
		} else {
			return true;
		}
	});
} );

$(window).resize(function(){
	$('.compQuestion-cont').css('left', ( $(window).width()-$('.site_center').width())/2-27+'px' );
});