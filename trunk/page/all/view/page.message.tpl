<script type="text/javascript">
/*<![CDATA[*/
function messageBox(selected_item_id, title, tartalom) {
    $( "#dialog-message div.dialog-message-data" ).html(tartalom);    
    $( "#dialog-message" ).dialog({
			resizable: false,
            draggable: false,
			modal: true,
            title: title,
			buttons: {
				'Bezár': function() {
					$( this ).dialog( "close" );
                    if($('#'+selected_item_id).attr('href')) window.location = $('#'+selected_item_id).attr('href');
                    else $('#'+selected_item_id).click();    
				}
			},
             close: function(event, ui) {
                if($('#'+selected_item_id).attr('href')) window.location = $('#'+selected_item_id).attr('href');
                else $('#'+selected_item_id).click();
             }
	});
    return false;
}
/*]]>*/
</script>
<!--<div id="dialog-message" style="display: none;">-->
<div class="dialog-message" style="display: none;">
	<div><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 30px 0;"></span> <div class="dialog-message-data"></div></div>
</div>
<div class="clear"></div>
{if $FormError}
 <div class="info info-error">
		<p><img src="images/site/form-error.png" style="float:left; margin:5px;"/>{$FormError}</p>
	</div> 
    <div class="clear"></div>
{/if}
{if $FormMessage}
  	<div id="form_info" class="info info-success">
		<p>{$FormMessage}</p>
	</div>
    <div class="clear"></div>
{/if}
{if $FormInfo}
  	<div id="form_info" class="notice info">
		<p>{$FormInfo}</p>
	</div>
    <div class="clear"></div>
{/if}
<!--<div id="jquery_hiba" style="display: none;">-->
<div class="jquery_hiba" style="display: none;">
    <div class="notice warning">
		<p>Hibás form kitöltés!</p>
	</div>
    <div class="clear"></div>
</div>