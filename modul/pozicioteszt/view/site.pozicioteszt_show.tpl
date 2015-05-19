<div id='testError' style='display: none;'>
</div>
<div>{$text}</div>

<form id="{$FormName}" name="{$FormName}" action="" method="post">
    {foreach from=$questions item=question}
        <div class="qCont">
            <div class="question">{$question}</div>
            <div class="missing"></div>
            <input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="3">teljes mértékben
            <input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="2">inkább
            <input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="1">kevésbé
            <input type="radio" name="kerdes[{$question@iteration}]" id="kerdes{$question@iteration}" class="kerdes" value="0">egyáltalán nem
            <!--input type="hidden" id="kerdes{$question@iteration}_val" class='answerValue' name="kerdes[{$question@iteration}]" value="-1"-->
            <br/><br/>
        </div>
        <div class="clear"></div> 
    {/foreach}
    <input type="hidden" name="result" value="1">
    <button id="elkuld" type="submit">Eredmény</button>
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
                    error.appendTo(element.parent().parent().find('.missing'));
            }
        });
        
    });
      
});

</script>