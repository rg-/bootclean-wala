<?php
 
add_action('wp_footer',function(){ 
	$ajax_empty_cart_url = admin_url('admin-ajax.php').'?action=get_template&name=ajax/remove_cart_item';
?>

<script id="wpbc-woo-mainjs">
	
	$(document.body).on('click', '[data-woo="empty-cart"]', function(e) {
		var $button = $(this);
		var $loading_target = $button.attr('data-loading-target');
		// values = JSON.parse(values);
		// $($loading_target).addClass('loading'); 
		// data-backdrop="static" data-keyboard="false"
		$('#modal_empty_cart_redirecting').modal({
		  keyboard: false,
		  backdrop: 'static'
		});
		// $('#modal_empty_cart_redirecting').modal('show');
		$.ajax({ type: "GET",   
		     url: '<?php echo $ajax_empty_cart_url; ?>&empty_cart=1',   
		     success : function(text)
		     {
		     		//alert('Cart emptied, will redirect to '+$button.attr('href'));
		     		window.location = $button.attr('href');

		     }
		});  
		return false;
	});

</script>

<?php

},999);