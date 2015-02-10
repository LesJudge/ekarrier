	function close_sidebar() {
		jQuery(".box_content").removeClass("box_content_bg");
		jQuery("#open_sidebar").show();
		jQuery("#close_sidebar").hide();
		$(".grid_6 .box_top").hide();
		$(".grid_6 .box_content").hide();
	}

	function open_sidebar() {
		jQuery(".box_content").addClass("box_content_bg");
		jQuery("#open_sidebar").hide();
		jQuery("#close_sidebar").show();
		$(".grid_6 .box_top").show();
		$(".grid_6 .box_content").show();
	}
$(function() {
    $(".form_filter input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            a = $(this).parent("div").find("input[type=submit]:first");
            
			$(this).parent("div").find("input[type=submit]:first").click();
            return false;
        } else {
            return true;
        }
    });
	/*if($(".grid_6").length > 0){
		$(".box_content .form_muvelet").append('<a id="open_sidebar" class="tip ui-state-default icon-only ui-corner-all" title="Info"><img src="../images/admin/icons/info.png" /><span class="ui-icon ui-icon-circle-arrow-w" style="float:right;"></span></a>');
		$(".box_content .form_muvelet").append('<a id="close_sidebar" class="tip ui-state-default icon-only ui-corner-all" title="Info"><img src="../images/admin/icons/info.png" /><span class="ui-icon ui-icon-circle-arrow-e" style="float:right;"></span></a>');
		jQuery('#close_sidebar').click(function(){
			close_sidebar();
			//if(jQuery.browser.safari) { location.reload();}
			jQuery.cookie('sidebar', 'closed' ); 
			jQuery(this).addClass("active");
		});
		jQuery('#open_sidebar').click(function(){
			open_sidebar();
			//if(jQuery.browser.safari) {location.reload();}
			jQuery.cookie('sidebar', 'open' );
		});
		if (jQuery.cookie('sidebar') == 'open') {
			open_sidebar();
	    }
		else{
	    	close_sidebar();
	    }
	}*/
	$("div.notice, p.error, p.warning, p.info, p.note, p.success").click(function() { 
		$(this).fadeOut('slow');
	});
    $(".form input:not(:submit,:checkbox)").addClass("ui-widget-content"); $("select").addClass("ui-widget-content"); $(":submit").button(); $(".form textarea").addClass("ui-widget-content");
	/*INPUTS ADDED CLASSES*/
    $("input").focus(function(){ 
    	$(this).addClass("ui-state-hover");
	}); 
	$("input").blur(function(){ 
		$(this).removeClass("ui-state-hover");
	});
    $("select").focus(function(){ 
    	$(this).addClass("ui-state-hover");
	}); 
	$("select").blur(function(){ 
		$(this).removeClass("ui-state-hover");
	});
    $("a.submit").mouseover(function(){ $(this).addClass('ui-state-hover'); }).mouseout(function(){ $(this).removeClass('ui-state-hover'); });
    $(".box_content select:not(.no_uniform), .box_content input:checkbox, .box_content input:radio, .box_content input:file  ").uniform();
    
    /*THEMEROLLER A QTIP-HEZ*/
    $.fn.qtip.styles.themeroller = {
        background: null, color: null, tip: { corner: true, background: null, color: '#bdbdbd' }, title: { 'background': null, 'fontWeight': null }
    };
    /*QTIPS*/
    $('.tip').qtip({ style: {  name: 'themeroller', tip: {  size: { x: 15, y : 8  } } }, border: { width: 0, radius: 0 }, position: { corner: { target: 'topMiddle', tooltip: 'bottomMiddle' }, adjust: { screen: true } }    });   
    /*INFO delay*/
    $('#form_info').delay(4000).slideUp(500);
    /*LIST FORM zebra AND active ROWS*/
    $("tr:even").addClass('even'); $("tr:odd").addClass('odd');
	$("tr").mouseover(function(){ $(this).addClass('activ_row'); }).mouseout(function(){ $(this).removeClass('activ_row'); });
    /*LIST FORM check row AND check all row*/
    $('.check_all_input').click(function(){  if($(this).attr('checked')) { var checked = $(':checkbox', $('tr.data_row')).removeAttr('checked');  $('tr.data_row').removeClass('highlight_table_row');  }  else{  var checked = $(':checkbox', $('tr.data_row')).attr('checked','checked');  $('tr.data_row').addClass('highlight_table_row');  }  $('tr.data_row').trigger('click'); $.uniform.update(checked); });
    $('tr.data_row ').filter(':has(:checkbox:checked)').end().click(function(event) { $(this).toggleClass('highlight_table_row'); if (event.target.type !== 'checkbox'){ $(':checkbox', this).attr('checked', function() {   return !this.checked; });$.uniform.update( $(':checkbox', this));} });
    $( ".accordion" ).accordion({  fillSpace: true });
});
/*JQUERY validálás*/
/*!
    !! beleírtam a js-be: 
        629: message += this.settings.errorObject; 
*/
$.validator.setDefaults({
	highlight: function(input) { $(input).addClass("ui-state-error"); },
	unhighlight: function(input) { $(input).removeClass("ui-state-error"); },
    errorClass: "error-jquery",
	validClass: "form-valid",
	errorElement: "p",
    errorObject: '',
    invalidHandler: function(form, validator) {
    	$(".ui-tabs-nav li").removeClass("ui-state-error");
    	var invalidPanels = $(validator.invalidElements()).closest(".ui-tabs-panel", form);
    	if (validator.numberOfInvalids()) {
   	  		$("#jquery_hiba").show(); 
			if (invalidPanels.size() > 0) {
				$.each($.unique(invalidPanels.get()), function(){
				  $(this).siblings(".ui-tabs-nav").find("a[href='#" + this.id + "']").parent().show("pulsate",{times: 4}).addClass("ui-state-error");
				});
			}
    }
    else{
    	$("#jquery_hiba").hide();
    }
  }
});

    // Extend messages.
    $.extend($.validator.messages, {
        dateISO: "Valós dátumot adjon meg! (éééé-hh-nn)"
    });
    // Regex method for jQuery Validate plugin.
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );

    $(document).ready(function() {
		$('TABLE.sorting thead .align_left:first').removeClass('center');
		
//-------------------------------------------------------------- */
// Gallery Actions
//-------------------------------------------------------------- */

	function galleryActions(){
		// When hovering over gallery li element
		$("ul.gallery li").hover(function() { 
		  
			var $image = (this);
			
			// Shows actions when hovering
			$(this).find(".actions").show();
			
			// If the "x" icon is pressed, show confirmation (#dialog-confirm)
			$(this).find(".actions .delete").click(function () {
				
				// Confirmation
				$( "#dialog-confirm" ).dialog({
					resizable: false,
					modal: true,
					minHeight: 0,
					draggable: false,
					buttons: {
						"Delete": function() {
							$( this ).dialog( "close" );
							
							// Removes image if delete is pressed
							$($image).fadeOut('slow', function() { 
								$($image).remove(); 
							});
							
						},
						
						// Removes dialog if cancel is pressed
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
				
				return false;
		    });

			
			// Changes opacity of the image
			$(this).find("img").css("opacity","0.5");
		  
			// On hover off
			$(this).hover(function() {  
			}, function(){  
				
				// Hides actions when hovering off
				$(this).find(".actions").hide();
				
				// Changes opacity of the image back to normal
				$(this).find("img").css("opacity","1");
				
			});  
		}); 
		
	};
	
	galleryActions();
		
    });