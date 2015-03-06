<form name="{$FormName}" action="" method="post">

{foreach from=$questions item=question}
    <div class="question">{$question}</div>
    <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="3">teljes mértékben
    <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="2">inkább
    <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="1">kevésbé
    <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="0">egyáltalán nem
    <input type="hidden" id="kerdes{$question@iteration}_val" name="kerdes[{$question@iteration}]" value="">
    <br/><br/>
    <div class="clear"></div> 
{/foreach}
    

<input type="hidden" name="result" value="1">
<button type="submit">Eredmény</button>

</form>

<script type=text/javascript>
$(document).ready(function(){

$(".kerdes").change(function(){
    
    var id = $(this).attr("id");
    $("#"+id+"_val").attr("value",$(this).attr("value"));
});


});


</script>