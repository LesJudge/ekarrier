<div id='testError' style='display: none;'>
</div>
<div>{$text}</div>

<form id="{$FormName}" name="{$FormName}" action="" method="post">
    {foreach from=$questions item=question}
        <div class="question">{$question}</div>
        <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="3">teljes mértékben
        <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="2">inkább
        <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="1">kevésbé
        <input type="radio" name="kerdes{$question@iteration}" id="kerdes{$question@iteration}" class="kerdes" value="0">egyáltalán nem
        <input type="hidden" id="kerdes{$question@iteration}_val" class='answerValue' name="kerdes[{$question@iteration}]" value="-1">
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

    $( "#{$FormName}" ).submit(function( event ) {
      var missing = 0;
      $('.answerValue').each(function(){
          if($(this).attr('value') == -1){
              missing++;
          }
      });
      
      if(missing > 0){
          $('#testError').html("<font color='red'>"+missing+" kérdésre nem válaszolt!</font>");
          $('#testError').show();
          setTimeout(function() { $("#testError").fadeOut("slow"); }, 3000);
          window.scrollTo(0,0);
          event.preventDefault();
      }
    });
});
</script>