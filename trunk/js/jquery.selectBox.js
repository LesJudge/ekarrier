

document.write('<style type="text/css">.selectCont { position:relative; } .selectCont select.select { position: relative; opacity: 0; filter: alpha(opacity=0); -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";}</style>');

var Custom = {
	init: function() {		
		var span = Array(), textnode, option, active;		
		inputs = $(".selectCont .select");
		inputs.each(function(e){
			if ($(this).find("option:selected").length) { 
			  $(this).before("<span class='styled'>"+$(this).find("option:selected").text()+"</span><span class='styled-arrow'></span>");
			}				
		});
		
	},		
	choose: function() {		
		option=inputs;		
		option.each(function(e){
			if ($(this).find("option:selected").length) {
				$("styled"+$(this).attr('name')).text($(this).find("option:selected").text());
			}
		});		
		eval($(this).attr('onchange'));		
	}
}
window.onload = Custom.init;