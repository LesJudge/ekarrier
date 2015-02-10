<script>
$(function() {
    $('.flat_menu').each(function(index) {
        $(this).menuize({ 
			content: $(this).next().html(), // grab content from this page
			showSpeed: 400,
            flyOut: true,
            width: 130
		});
    });
});
</script>
<div class="menu_all">
    {$menu_all}
</div>