/*
 * jQuery UI Multilevel Accordion v.1
 * 
 * Copyright (c) 2011 Pieter Pareit
 *
 * http://www.scriptbreaker.com
 *
 */

//plugin definition




(function($){
    $.fn.extend({
    	
    multiaccordion: function(options) {
		var defaults = {
			accordion: 'true',
			speed: 300,
			closedSign: '   [+]  ',
			openedSign: '   [-]  '
		};
		var opts = $.extend(defaults, options);
 		var $this = $(this);
 			
		var cookie = $.cookie("AktivBalmenuFA");
		var items = cookie ? cookie.split(/,/) : new Array();

 		$this.find("li").each(function() {
 			if($(this).find("ul").size() != 0){
 				$(this).find("a:first").after("<span id='span_"+$(this).attr('id')+"'>"+ opts.closedSign +"</span>");
 				if($(this).find("a:first").attr('href') == "#"){
 		  			$(this).find("a:first").click(function(){return false;});
 		  		}
 			}
 		});

 		$this.find("li.active").each(function() {
 			$(this).parents("ul").slideDown(opts.speed);
 			$(this).parents("ul").parent("li").find("span:first").html(opts.openedSign);
 		}); 		
 		
 		$this.find("li span").each(function(index,value) {
			var element = $(this);
	 		$(items).each(function(index, value) {
	 			if(element.attr('id')==value) openMenu(element);
			});
		});
		
		function openMenu(element) {
			$(element).parent().find("ul:first").slideDown(opts.speed, function(){
  				$(element).parent().find("span:first").html(opts.openedSign);
  			});
		}
	
  		$this.find("li span").click(function() {
  			var this_elment = $(this); 
  			if($(this).parent().find("ul").size() != 0){
  				if(opts.accordion){
  					if(!$(this).parent().find("ul").is(':visible')){
  						parents = $(this).parent().parents("ul");
  						visible = $this.find("ul:visible");
  						visible.each(function(visibleIndex){
  							var close = true;
  							parents.each(function(parentIndex){
  								if(parents[parentIndex] == visible[visibleIndex]){
  									close = false;
  									return false;
  								}
  							});
  							if(close){
  								if($(this).parent().find("ul") != visible[visibleIndex]){
									$.each(items, function(index, result) {
									      if(result != this_elment.attr('id')) items.splice(index, 1);		      
									});
				  					$.cookie("AktivBalmenuFA", items.join(',')	);					  
										
  									$(visible[visibleIndex]).slideUp(opts.speed, function(){
										$(this).parent("li").find("span:first").html(opts.closedSign);
  									});
  									
  								}
  							}
  						});
  					}
  				}
  				if($(this).parent().find("ul:first").is(":visible")){
  					$.each(items, function(index, result) {
					      if(result == this_elment.attr('id')) items.splice(index, 1);   
					});
  					$.cookie("AktivBalmenuFA", items.join(',')	);
  					$(this).parent().find("ul:first").slideUp(opts.speed, function(){
  						$(this).parent("li").find("span:first").delay(opts.speed).html(opts.closedSign);
  					});
  					
  					
  				}else{
  					items.push($(this).attr('id'));
  					$.cookie("AktivBalmenuFA", items.join(','));
  					$(this).parent().find("ul:first").slideDown(opts.speed, function(){
  						$(this).parent("li").find("span:first").delay(opts.speed).html(opts.openedSign);
  					});
  				}
  			}
  		});
    }
});
})(jQuery);