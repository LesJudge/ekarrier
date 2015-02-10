
/********************************************************/
/*	LABEL IN FIELD => jquery.labelInField.js	
	
	Készítette: Bíró László 
	e-mail: birolacko82@gmail.com 
	
	Működési leírás: Form LABEL tag-ek, Input mezőkbe írása.
	Használata: 
		A kívánt Input mezőhöz kell a lenti két class-t hozzáadni, valamint egy alt
		attributumot, ami a megjelenítendő szöveget tartalmazza.
		pl.: 
			$labelInField=new labelInFieldFn( $('.labelInField'), $('.labelInFieldPwd') );				
    		$labelInField.start();	 
*/
/********************************************************/
function labelInFieldFn(){
	
	var labelInFieldObj=this;
	
	/********************************************************/
	/*	A labelInFieldObj.makeItPassword(), és labelInFieldObj.makeItText() metódusban van meghívva!
		Argumentuma az aktuális Input elem Jquery objektuma.
	*/
	/********************************************************/	
	labelInFieldObj.getAttributes=function(o){
		var attributes = {}; 
        if( o.length ) {
            $.each( o[0].attributes, function( index, attr ) {
                attributes[ attr.name ] = attr.value;
            }); 
        }
		return attributes;		
	}
	
	
	
	/********************************************************/
	/*	A labelInFieldObj.makeItPassword(), és labelInFieldObj.makeItText() metódusban van meghívva!
		Argumentumok: 
			1.) Input selectror konténerének az id-je.(String())   
			2.) A labelInFieldObj.getAttributes(o) metódus adja vissza azt az objektumot, 
				mely tartalmazza az elem attributumait.
			3.) "text" vagy "password" értékű lehet, pl.: akkor text amikor password-ot akarunk belőle kapni!	
		A selector konténere itt kapja meg a generált Inputot a kívánt attributumokkal.
	*/
	/********************************************************/	
	labelInFieldObj.propertiesOfObj=function(oId,obj,type){
		var count = 0;
		var attrString='';			
		for ( property in obj ) {
		   if(obj.hasOwnProperty(property)){
			  if(type=="text"){
				  if((property=="type")&&(obj[property]=="text")){
					 obj[property]="password"; 
				  }
			  }
			  if(type=="password"){
				  if((property=="type")&&(obj[property]=="password")){
					 obj[property]="text"; 
				  }
			  }
			  if((property=="disabled")){
			  	 if(navigator.appVersion.indexOf("MSIE 7.") != -1) { property=""; obj[property]=""; }
			  }			  
			  attrString=attrString+property+"='"+obj[property]+"' "; 			 		 
		   }
		}
		$("#"+oId).html("");
		$("#"+oId).append("<input "+attrString+" />");		
	}
		
	
	/********************************************************/
	/*	A labelInFieldObj.start() metódusban van meghívva először ez a metodus, 
		amikor a selector megkapja a focus-t. 
		Lecseréli a mezőt password típusúvá, törli a mező értékét,
		és ha elveszti a focus-t akkor meghívja a labelInFieldObj.makeItText() metódust. 
	*/
	/********************************************************/			
	labelInFieldObj.makeItPassword=function(fieldId,e,thisText,oldText){					
			labelInFieldObj.propertiesOfObj($('#'+fieldId).parent().attr('id'),labelInFieldObj.getAttributes($('#'+fieldId)),"text");		
			//console.log($("#"+fieldId).parent().html());			
			var thisObj=$("#"+String(fieldId));
			$("#"+fieldId).attr('value','');
			$("#"+fieldId).trigger("focus");
			$("#"+fieldId).focus();					
			$("#"+fieldId).blur(function(){
				if( $('#'+fieldId).attr('value')=="" ){ 
					//console.log("makeItPassword:blur=> value="+$('#'+fieldId).attr('value')+", oldText="+oldText);
					labelInFieldObj.makeItText($('#'+fieldId).attr('id'),e,$('#'+fieldId).attr('value'),oldText);  
				}				
			});		
	}	
		
	
	/********************************************************/
	/*	A labelInFieldObj.makeItPassword() metódusban van meghívva ez a metodus, 
		amikor a selector elveszti a focus-t, és a mező értéke "". 
		Visszaalakítja a mezőt text típusúvá! 	
	*/
	/********************************************************/									
	labelInFieldObj.makeItText=function(fieldId,e,thisText,oldText){		
		var thisTextNew="";
		//console.log("makeItText=> type="+$('#'+fieldId).attr('type')+", value="+$('#'+fieldId).attr('value')+", oldText="+oldText);											
		labelInFieldObj.propertiesOfObj($('#'+fieldId).parent().attr('id'),labelInFieldObj.getAttributes($('#'+fieldId)),'password'); 
		if(thisText==''){ 
			thisTextNew=oldText;			
			$("#"+fieldId).attr("value",thisTextNew); 
		}		
		//console.log("makeItText=> type="+$('#'+fieldId).attr('type')+", value="+$('#'+fieldId).attr('value')+", oldText="+oldText);			
		$("#"+fieldId).focus(function(){					
			labelInFieldObj.makeItPassword($('#'+fieldId).attr('id'),e,thisTextNew,oldText);							
		});				
	}
	
	
	/********************************************************/
	/*	Ezt a metódust kell meghívni a funkció indításához!
		A labelInFieldFn két $objektumot vár az egyik a text tipusú inputok selectora,
		a másik a password típusú selector. 
	*/
	/********************************************************/	
	labelInFieldObj.start=function(io,po){													
		var oldText =new Array();
		io.each(function(e){
			oldText[e]=$(this).attr("alt");			
			if($(this).attr('value')==""){
				$(this).attr("value",oldText[e]);
			}
			$(this).focus(function(){
				if($(this).attr('value')==oldText[e]){
					$(this).attr('value','');
				}
			});
			$(this).blur(function(){
				if($(this).attr('value')==''){ 
					$(this).attr('value',oldText[e]);
				 }
			});														
		});
		var oldPwdText =new Array();		
		po.each(function(e){
			oldPwdText[e]=$(this).attr("alt");
			$(this).wrap("<div id='labelInFieldCont_"+e+"' />");
				
			if($(this).attr('value')==""){
				$(this).attr('value',oldPwdText[e]);
			}
			$(this).attr('id','realPass_'+e);	
			if(navigator.appVersion.indexOf("MSIE 7.") == -1) {					
				$(this).focus(function(){
					//console.log(String($(this).attr('id'))+","+e+","+String($(this).val())+","+String(oldPwdText[e]));
					labelInFieldObj.makeItPassword(String($(this).attr('id')),e,String($(this).val()),String(oldPwdText[e]));
				});	
			}
		});															
	}	
	
	
}