<div id='testError' style='display: none;'>
</div>
<div>{$text}</div>

<form id="{$FormName}" name="{$FormName}" action="" method="post">
    <div class="jobFindList-title-cont"><div class="jobFindList-title jobFindList-title-1">Töltse ki a tesztet!</div></div>
	<div class="jobFindList-cont">    
		<div class="jobFindList-data-3">
			 <div class="qCont-label row">
			 	<div class="col-lg-8"></div>
				<div class="col-lg-4">Teljes mértékben</div>
				<div class="col-lg-4">Inkább</div>
				<div class="col-lg-4">Kevésbé</div>
				<div class="col-lg-4">Egyáltalán nem</div>
			 </div>
			 {foreach from=$questions item=question}
				<div class="qCont row">
					<div class="question col-lg-8 textAlign-left">{$question}</div>            
					<div class="col-lg-4"><input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="3"></div>         
					<div class="col-lg-4"><input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="2"></div>         
					<div class="col-lg-4"><input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="1"></div>         
					<div class="col-lg-4"><input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="0"></div>         
					<!--input type="hidden" id="kerdes{$question@iteration}_val" class='answerValue' name="kerdes[{$question@iteration}]" value="-1"-->		
					<div class="clear"></div>
					<div class="missing"></div>		   
				</div>			 
			{/foreach}
		</div>		
	</div>
	
	<div class="form-row">		
		<input type="hidden" name="result" value="1">
		<button id="elkuld" type="submit" class="btn btn-primary btn-lg">Eredmény</button>
	</div>
	<div class="clear"></div>	
	
</form>


<script type=text/javascript>
$(document).ready(function(){
   
    $("#elkuld").click(function (){
     
          
			$("#{$FormName}").validate( { rules: {
                'kerdes[1]': { required: 1 },
                'kerdes[2]': { required: 1 },
                'kerdes[3]': { required: 1 },
                'kerdes[4]': { required: 1 },
                'kerdes[5]': { required: 1 },
                'kerdes[6]': { required: 1 },
                'kerdes[7]': { required: 1 },
                'kerdes[8]': { required: 1 },
                'kerdes[9]': { required: 1 },
                'kerdes[10]': { required: 1 },
                'kerdes[11]': { required: 1 },
                'kerdes[12]': { required: 1 },
                'kerdes[13]': { required: 1 },
                'kerdes[14]': { required: 1 },
                'kerdes[15]': { required: 1 },
                'kerdes[16]': { required: 1 },
                'kerdes[17]': { required: 1 },
                'kerdes[18]': { required: 1 },
                'kerdes[19]': { required: 1 },
                'kerdes[20]': { required: 1 },
                'kerdes[21]': { required: 1 },
                'kerdes[22]': { required: 1 },
                'kerdes[23]': { required: 1 }
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent().parent().parent().find('.missing'));					
            }
			
        });
        	
    });
      
});

</script>