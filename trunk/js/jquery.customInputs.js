 
	function customInputs(options) {  
		$this = this;
		
		$this.defaults = {																
			select : true,
			checkbox : true,
			radio : true,
			file : true,
			
			lang : {
				yes : "Igen",
				no : "Nem", 
				browse:"Tallózás"
			},
				
			allSelect : true,	
			allCheckbox : true,				
			allRadio : true,
			allFile : true,
			
			regularCheckbox : true
			
		};	
			
		//var opt2 = $.extend({ getChecked: function() {} }, arguments[1] || {} );
		$this.opt = $.extend({}, $this.defaults, options);
		
		
		$this.widestObject = function(o){
			var widest=0;
			o.each(function(){
				if((parseInt($(this).css("font-size"))/2)*$(this).text().length>=widest){
					widest=(parseInt($(this).css("font-size"))/2)*$(this).text().length;	
				}
				//console.log($(this).text().length+" - "+(parseInt($(this).css("font-size"))/2)*$(this).text().length);
			});		
			return widest;
		}
		
		
		$this.selectbox = function() {	
			var inputs, c, cArr=Array();	
			
			if($this.opt.allSelect!=true){
				if( ($($this.opt.selectType_1).length!==0) && ($($this.opt.selectType_1)!=true) ){					
					renderSelect($("SELECT"+$this.opt.selectType_1)); 					
				}if( ($($this.opt.selectType_2).length!==0) && ($($this.opt.selectType_2)!=true) ){					
					renderSelect($("SELECT"+$this.opt.selectType_2)); 					
				}
			}
			else if(opt.allSelect==true){				
				renderSelect($("SELECT")); 				
			}
			
			function renderSelect(inp){				
				inp.each(function(e){								
					$(this).wrap("<span class='select-cont'/>"); 					
					c=$.trim($(this).attr("class")).toLowerCase();
					cArr=c.split(' ');
					for(var i=0; i<=cArr.length-1; i++){					
						if (cArr[i].search(/select-type-/i)!=-1) {
							$(this).parent().addClass(cArr[i]);	
						}
					}							
					if ($(this).find("option:selected").length!=0) { 
						$(this).before("<span class='styled customInput-text'>"+ $(this).find("option:selected").text() +"</span><span class='styled-arrow'></span>");
					}					
					$(this).css("width",$this.widestObject($(this).find("option"))+$(this).parent().find(".styled-arrow").width()+parseInt($(this).parent().find(".styled").css("padding-left")));						
					//$(this).css("width","100%");									
				});	
				inp.change(function () { 
					$(this).parent().find(".styled.customInput-text").text($(this).find("option:selected").text());
				});	
				return false;
			} 
			return false;

		
		}
		
		$this.checkbox = function() {		
			var inputs, c;
			var cArr=new Array();	
			
			if($this.opt.allCheckbox==false){
				$("INPUT[type='checkbox']").addClass("noStyle");	
			}			
			inputs=($this.opt.allCheckbox==true)?$("INPUT[type='checkbox']"):$(".checkbox");		
			inputs.each(function(){	
				$(this).removeClass("noStyle");			
				$(this).wrap("<span class='checkbox-cont'/>"); 
				$(this).parent(".checkbox-cont").append("<span class='checkbox-switch customInput-text'>"+$this.opt.lang.no+"</span>");	
				if($this.opt.regularCheckbox==true){
					$(this).parent(".checkbox-cont").addClass("regularCheckboxCont");	
				}
			});				
			inputs.each(function(e){			
				c=$.trim($(this).attr("class")).toLowerCase();
				cArr=c.split(' ');				
				for(var i=0; i<=cArr.length-1; i++){
					if (cArr[i].search(/checkbox-size-/i)!=-1) {
						$(this).addClass(cArr[i]);	
					}
				}	
				if ($(this).prop('checked')==true) { 	
					//console.log($(this).prop('checked'));	
					//$this.opt.getChecked.call(this);
					$(this).parent().addClass("checkedBox");	
					$(this).parent().find(".checkbox-switch.customInput-text").text($this.opt.lang.yes);			
				}	
						
				$(this).find(".customInput-text").css("font-size",parseInt($(this).height())/2+"px");
				
				$(this).bind("click",function(){
					var tChkCont=$(this).parent();					
					var thisItem=$(this);
					//console.log("clickben: "+thisItem.prop('checked'));					
					if (thisItem.prop('checked')==false) { 
						//thisItem.prop('checked', false);
						tChkCont.removeClass("checkedBox");
						tChkCont.find(".checkbox-switch.customInput-text").text($this.opt.lang.no);												
					}else{
						//thisItem.prop('checked', true);
						//$this.opt.getChecked.call(this);
						tChkCont.addClass("checkedBox");	
						tChkCont.find(".checkbox-switch.customInput-text").text($this.opt.lang.yes);												
					}							
				});
				
			});					
			return false;
		}
		
		
		$this.radiobox = function() {		
			var inputs, isChecked, c;
			var cArr=new Array();	
			
			inputs=($this.opt.allRadio==true)?$("INPUT[type='radio']"):$(".radiobox");
			inputs.each(function(){
				$(this).wrap("<span class='radiobox-cont'/>"); 
				$(this).parent(".radiobox-cont").append("<span class='radiobox-switch customInput-text'>"+$this.opt.lang.no+"</span>");	
			});	
			
			inputs.parent().each(function(e){
				c=$.trim($(this).find(inputs).attr("class")).toLowerCase();
				cArr=c.split(' ');
				for(var i=0; i<=cArr.length-1; i++){
					if (cArr[i].search(/radiobox-size-/i)!=-1) {
						$(this).addClass(cArr[i]);	
					}
				}					
				isChecked = $(this).find(inputs).is(':checked');			
				if (isChecked==true) { 	
					$(this).addClass("checkedBox");	
					$(this).next(".designedRadio").addClass("active");
					$(this).find(".radiobox-switch.customInput-text").text($this.opt.lang.yes);					
				}	
				$(this).find(".customInput-text").css("font-size",parseInt($(this).height())/2+"px");
				
				$(this).click(function(){				
					$(".radiobox-cont INPUT[type='radio'][name='"+$(this).find(inputs).attr("name")+"']")
						.parent()
						.removeClass("checkedBox")
						.removeAttr("checked");
					$(".designedRadio").removeClass("active");
					$(this).find(inputs).attr("checked","checked");
					$(this).addClass("checkedBox");	
					$(this).next(".designedRadio").addClass("active");
					$(this).find(".radiobox-switch.customInput-text").text($this.opt.lang.no);	
					isChecked=false;							
				});							
			});	
			return false;				
		}
		
		
		$this.filebox= function() {		
			var inputs; 
			inputs=($this.opt.allFile==true)?$("INPUT[type='file']"):$(".filebox");
			
			inputs.each(function(){
				$(this).wrap("<span class='filebox-cont'/>");
				$(this).before("<input class='filebox-field' readonly='readonly' id="+$(this).attr('id')+" /><span class='filebox-btn customInput-text'>"+$this.opt.lang.browse+"</span>"); 								
				$(this).parent().find(".customInput-text").css("font-size",parseInt($(this).height())/2.5+"px");
			});						
			inputs.each(function(e){
				$(this).change(function () { 
					$(this).parent().find(".filebox-field").attr("value",$(this).val());
				});						
			});	
			return false		
		}
						
		
		$this.start= function()  {		
			if($this.opt.select==true) { 
				$this.selectbox() 
			}; 
			
			if($this.opt.checkbox==true) { 
				$this.checkbox() 			
			}; 
			
			if($this.opt.radio==true) { 
				$this.radiobox() 
			}; 
			
			if($this.opt.file==true) { 
				$this.filebox() 
			}; 	
		}
		
		
	}	
	



