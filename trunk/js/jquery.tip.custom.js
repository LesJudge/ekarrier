$.fn.extend({       
	tip : function(options) {  
		var THIS = this;
		
		var defaults = {				
			tipUse : true,
			tipArrow : true,
			tipTextTriggerAttr : 'title',								
			tipStyle : {
				position: 'fixed', 
				top: '0px',
				left: '0px',
				height: 'auto',
				lineHeight: '30px',
				padding: '0 10px',				
				width: '200px',
				background:'#8dc153',
				color:'#ffffff',
				textAlign:'left',
				border: '1px solid #8dc153',	 		
				zIndex: '9999',
				borderRadius: 10					
			},
			animDuration:200,
			animOver : { 
				'display' : 'block',
			},
			animOut : { 
				'display' : 'none',				
			},	
			tipTypeDef :{				
				top: {
					pos: {						
						top:-45						
					}				
				},
				right: {
					pos: {						
						top:0						
					}				
				},
				bottom: {
					pos: {						
						bottom:-45					
					},				
				},
				left: {
					pos: {						
						top:0					
					}				
				},
			},
			tipType:"top",			
			arrowTypeDef: {
				leftBottom: {
					pos: {
						left:"20px",
						bottom:"-10px",
						height:"20px",
						width:"20px"
					},
					arrow:"<i class='tipArrow icomoon icomoon-arrow-down'></i>"
				},
				rightBottom: {
					pos: {
						right:"20px",
						bottom:"-10px",
						height:"20px",
						width:"20px"
					},
					arrow:"<i class='tipArrow icomoon icomoon-arrow-down'></i>"
				},
				leftTop: {
					pos: {
						left:"20px",
						top:"-10px",
						height:"20px",
						width:"20px"
					},
					arrow:"<i class='tipArrow icomoon icomoon-arrow-up'></i>"
				},
				rightTop: {
					pos: {
						right:"20px",
						top:"-10px",
						height:"20px",
						width:"20px"						
					},
					arrow:"<i class='tipArrow icomoon icomoon-arrow-up'></i>"
				},
				left: {
					pos: {
						left:"-9px",
						top:"5px",
						height:"20px",
						width:"20px"
					},
					arrow:"<i class='tipArrow icomoon icomoon-arrow-left'></i>"
				},
				right: {
					pos: {
						right:"-9px",
						top:"5px",
						height:"20px",
						width:"20px" 
					},
					arrow:"<i class='tipArrow icomoon icomoon-arrow-right'></i>"
				}
			},
			arrowType:"right"				 				
		};	
			
		var opt = $.extend(defaults, options);  	
		
		var arrow=0;
		var pos=0;
		switch (opt.arrowType) {
			case "leftBottom": {
				arrow = opt.arrowTypeDef.leftBottom.arrow;
				pos = opt.arrowTypeDef.leftBottom.pos;
				break;
			}
			case "rightBottom": {
				arrow = opt.arrowTypeDef.rightBottom.arrow;
				pos = opt.arrowTypeDef.leftBottom.pos;
				break;
			}
			case "leftTop": {
				arrow = opt.arrowTypeDef.leftTop.arrow;
				pos = opt.arrowTypeDef.leftTop.pos;
				break;
			}
			case "rightTop": {				
				arrow = opt.arrowTypeDef.rightTop.arrow;
				pos = opt.arrowTypeDef.rightTop.pos;
				break;
			}
			case "left": {
				arrow = opt.arrowTypeDef.left.arrow;
				pos = opt.arrowTypeDef.left.pos;
				break;
			}
			case "right": {
				arrow = opt.arrowTypeDef.right.arrow;
				pos = opt.arrowTypeDef.right.pos;
				break;
			}			
		} 
		
		
		var tipTop=0;
		switch (opt.tipType) {			
			case "top": {
				tipTop = opt.tipTypeDef.top.pos.top;				
				break;
			}
			case "right": {
				tipTop = opt.tipTypeDef.right.pos.top;				
				break;
			}
			case "bottom": {
				tipTop = opt.tipTypeDef.bottom.pos.bottom;				
				break;
			}
			case "left": {
				tipTop = opt.tipTypeDef.left.pos.left;				
				break;
			}			
		} 
		
					
		THIS.message = $("<div id='tipCont'><div class='tipInner'></div>"+arrow+"<div>").css(opt.tipStyle);				
		
		
		THIS.itemOver=function (t,animations) {
			THIS.message.remove().appendTo('body').css({ "left":t.offset().left,"top":t.offset().top+tipTop}).find(".tipInner").html(t.attr(opt.tipTextTriggerAttr));
			THIS.message.find(".tipArrow").css(pos).css({'color':opt.tipStyle.background});			
			t.animate(
					animations,
					{ 'duration' : opt.animDuration, 'complete' :function() {						
						}
					}
			);
			
			return false		
		}
		
		THIS.itemOut=function (t,animations) {
			THIS.message.remove();
			t.animate(
					animations,
					{ 'duration' : opt.animDuration, 'complete' :function() {						
						}
					}
			);
			return false		
		}		
		
		$(function(){	
			//console.log(THIS);		
			if (opt.tipUse != false){				
				THIS.each(function(e){
					$(this).hover(function(){						
						THIS.itemOver($(this),opt.animOver);
					},function(){
						THIS.itemOut($(this),opt.animOut);		
					});				
				});	
			}			
												
		});	
		
		
	} 
	
}); //$.fn.extend -> end
