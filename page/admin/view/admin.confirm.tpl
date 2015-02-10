<script type="text/javascript">
var clickedToOK = false;
function confirmBox(selected_item_id, title, tartalom) {
    if(clickedToOK==true) return true;
    $( "#dialog-confirm div.dialog-confirm-kerdes" ).html(tartalom);    
    $( "#dialog-confirm" ).dialog({
			resizable: false,
            draggable: false,
			modal: true,
            title: title+'?',
			buttons: {
				'Igen': function() {
				    clickedToOK = true;
					$( this ).dialog( "close" );
                    if($('#'+selected_item_id).attr('href')) window.location = $('#'+selected_item_id).attr('href');
                    else $('#'+selected_item_id).click();    
				},
				"Mégse": function() {
				    clickedToOK = false;
				    $('#'+selected_item_id).removeClass('ui-state-focus');
					$( this ).dialog( "close" );
				}
			}
	});
    return false;
}
</script>
<div id="dialog-confirm" style="display: none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 30px 0;"></span> <div class="dialog-confirm-kerdes"></div></p>
</div>