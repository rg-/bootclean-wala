<?php

/**
 * @snippet       Avoid Empty Cart Redirect @ WooCommerce Checkout 
 */
 
// Could be usefull, but not in this case, see next action
// add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
// add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );

add_action( 'template_redirect', 'wpbc_checkout_template_redirect', 0 );

function wpbc_checkout_template_redirect(){

	// this is same thing in /includes/wc-template-functions.php line 30
	// but redirecting to custom page 

	// When on the checkout with an empty cart, redirect to cart page.
	if ( is_page( wc_get_page_id( 'checkout' ) ) && wc_get_page_id( 'checkout' ) !== wc_get_page_id( 'cart' ) && WC()->cart->is_empty() && empty( $wp->query_vars['order-pay'] ) && ! isset( $wp->query_vars['order-received'] ) && ! is_customize_preview() && apply_filters( 'woocommerce_checkout_redirect_empty_cart', true ) ) {
		
		$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
		if( !is_wc_endpoint_url('order-received') && !isset($_GET['key']) ){
			wc_add_notice( __( 'Checkout is not available whilst your cart is empty.', 'woocommerce' ), 'notice' );
			wp_safe_redirect( get_the_permalink($ordenar_page_id) );
			exit;
		}
	}
}

/*

	wpbc woocommerce config for Checkout pages

*/
add_filter('wpbc/filter/woocommerce/config', function ($wpbc_woocommerce_config){
	
	$wpbc_woocommerce_config['layout']['checkout'] = array(
		'class' => ' ',
	);

	return $wpbc_woocommerce_config;

},10,1);

add_filter('wpbc/filter/page/single/class',function($class){
	if( is_checkout() ){
		$class .= ' woo-is_checkout gpb-1 gpb-md-2 gpb-md-5 ui-loader';
	} 
	return $class;
},10,1); 

add_filter( 'woocommerce_order_button_html', function($html){
	if( is_checkout() ){
		$html = '';
	} 
	return $html;
},10,1);


/*
	
	woo actions/filters

*/
add_filter( 'woocommerce_checkout_login_message', function($msg){

	$msg = '¿Ya tienes una cuenta de Walá?';
	return $msg;

},10,2 );

add_action( 'woocommerce_after_checkout_validation', 'wpbc_checkout_validation_one_err', 9999, 2);
function wpbc_checkout_validation_one_err( $fields, $errors ){ 
	// if any validation errors
	if( !empty( $errors->get_error_codes() ) ) { 
		// remove all of them
		foreach( $errors->get_error_codes() as $code ) {
			$errors->remove( $code );
		} 
		// add our custom one
		$errors->add( 'validation', 'Revisa los campos marcados en rojo para continuar.' ); 
	} 
}

// templates/checkout/form-checkout.php
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 ); 
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

add_action('woocommerce_before_checkout_form',function($checkout){
	
	?>
	<div id="affix-checkout-area" class="position-relative">
		<div class="col2-set">
			<div class="col-1">
				<div class="woo-custom-checkout-login-form">
					<?php //woocommerce_output_all_notices(); ?>
					<?php woocommerce_checkout_coupon_form(); ?>
					<?php woocommerce_checkout_login_form(); ?>
				</div>
			</div>
		</div>
	<?php 
},10,1);
add_action('woocommerce_after_checkout_form',function($checkout){
	?>
	</div><!-- affix-checkout-area END -->
	<?php 
},10,1);

add_action('woocommerce_checkout_before_customer_details', function(){  

	?>
	<div id="affix-checkout-areaX" class="position-relativeX">
	<?php 
});

add_action('woocommerce_checkout_after_customer_details', function(){ 

	$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');

	?> 

	<div class="col2-set">
		<div class="col-1">

			<h3 class="woo-form-title gmb-1">Método de pago</h3>
			<p class="font-size-14">Seleccione el método de pago preferido.</p>

			<?php woocommerce_checkout_payment(); ?>

			<div class="align-items-center d-none d-md-flex">
				<p class="m-0 small"><a data-woo="empty-cart" data-loading-target=".woo-is_checkout" href="<?php echo get_the_permalink($ordenar_page_id); ?>"><i class="fa fa-angle-left"></i> Cambiar Plan</a></p>

			<?php
			$order_button_text = 'Realizar Pedido';
			echo '<button type="submit" class="ml-auto btn btn-action btn-primary" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>'; // @codingStandardsIgnoreLine ?>
			</div>

		</div>
	</div> 

<div id="affix-column" class="affix-container-absolute z-index-40" data-toggle="nav-affix" data-affix-position="top" data-affix-breakpoint="md" data-affix-target="#affix-checkout-area" data-affix-simulate="false" data-affix-scrollify="true" data-affix-detect="bottom" data-affix-inner-element=".affix-column">
	<div class="container affix-container"> 
		<!-- woo-custom-checkout-review-order column  -->
		<div class="col-md-6 col-lg-4 order-md-2 ml-auto affix-column px-0 gpx-md-1">
			<div class="woo-custom-checkout-review-order">
				<?php
			 	woocommerce_order_review();
				?>
			</div>
		</div>
	</div>
</div><!-- #affix-checkout-area end -->

<?php WPBC_get_template_part('woocommerce/modals/empty_cart_redirecting'); ?>

	<?php

});

add_action( 'woocommerce_review_order_before_cart_contents', function(){
	?>
	<tr><td colspan="6">
<h3 class="ui-box-cart-title lg">RESUMEN DE TU PEDIDO</h3>
</td></tr>
	<?php
});

add_action( 'woocommerce_review_order_after_order_total', function(){
	$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
	?>
	<tr><td colspan="6" class="ml-0 w-100">
<p class="d-flex flex-column text-center align-items-center justify-content-start gmt-1 m-0 small">
	
	<a class="order-2 gpt-1 gpt-md-0 mr-md-auto" data-woo="empty-cart" data-loading-target=".woo-is_checkout" href="<?php echo get_the_permalink($ordenar_page_id); ?>"><i class="fa fa-angle-left"></i> Cambiar Plan</a>

	<?php
			$order_button_text = 'Realizar Pedido';
			echo '<button type="submit" class="w-100 order-1 ml-md-auto btn btn-action btn-primary d-md-none" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>'; // @codingStandardsIgnoreLine ?>

</p>
</td></tr>
	<?php
});

add_filter('WPBC_post_header_class', function($class){
	if( is_wc_endpoint_url( 'order-received' ) && isset($_GET['key']) ){
		$class = 'text-center';
	}
	return $class;
},10,1);  


add_filter( 'WPBC_post_header_title', function($_post_title, $title_tag, $title_class){
	if( is_wc_endpoint_url( 'order-received' ) && isset($_GET['key']) ){  
		$_post_title = '[title_claim]Gracias. <br>Tu pedido ha sido recibido.[/title_claim]';
	}
	return $_post_title; 
},10, 3); 


add_filter( 'woocommerce_thankyou_order_received_text', function($text, $order){
	if( is_wc_endpoint_url( 'order-received' ) && isset($_GET['key']) ){
		$text = '';
	}
	return $text;
},10,2 ); 




add_action('woocommerce_review_order_after_shipping',function(){ 

	$shipping_methods = WC()->shipping->get_shipping_methods(); 
	foreach($shipping_methods as $shipping_method){
	    $shipping_method->init(); 
	    foreach($shipping_method->rates as $key=>$val){
	    	//_print_code($val);
	    	$rate_table[$key] = $val;
	    }
	}
	
	?>
<tr class="gmt-n-1">
	<td colspan="2">
 
		<?php
		
		$used_method = $rate_table[WC()->session->get( 'chosen_shipping_methods' )[0]]; 

		// _print_code(WC()->session->get( 'chosen_shipping_methods' ));
		// _print_code($used_method);

		if(!empty($used_method->cost)){
			if($used_method->cost<=0){
				echo "<span class='ui-badge badge-success text-white'>Envío gratuito</span>";
			}
		} 
		?>
	</td>
</tr>
	<?php
});

add_action('wp_footer',function(){
?>
<script id="woo-custom-delivery-areas">
	
	var szbd = {"checkout_string_1":"<span>No hay opciones de m\u00e9todos de env\u00edo disponibles para tu direcci\u00f3n.</span>","checkout_string_2":"Minimum order value is","checkout_string_3":"You are too far away. We only make deliveries within","store_address":null,"debug":"0","select_top_method":"0","deactivate_postcode":"0","store_address_picked":"1"};

</script>
<?php
},99);



/*

	Remove Fields in WooCommerce Billing and Shipping in Form Checkout

*/

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );

function custom_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_state']);
  unset($fields['billing']['billing_city']);
  //unset($fields['billing']['billing_country']);
  //unset($fields['billing']['billing_address_1']);	

  unset($fields['shipping']['shipping_postcode']);
  unset($fields['shipping']['shipping_state']);
  unset($fields['shipping']['shipping_city']); 

  return $fields;
}

function custom_override_billing_fields( $fields ) {
  unset($fields['billing_postcode']);
  unset($fields['billing_state']);
  unset($fields['billing_city']);
  //unset($fields['billing_country']);
  //unset($fields['billing_address_1']);
  return $fields;
}


add_filter( 'woocommerce_default_address_fields', 'custom_override_address_fields' );
 
function custom_override_address_fields( $address_fields ) {
	// as you can see, no needs to specify a field group anymore
	$address_fields['address_1']['priority'] = 4; 
	$address_fields['address_2']['priority'] = 5; 
	return $address_fields;
}


add_action('woocommerce_cart_loaded_from_session', 'wh_cartOrderItemsbyNewest');

function wh_cartOrderItemsbyNewest() {

    //if the cart is empty do nothing
    if (WC()->cart->get_cart_contents_count() == 0) {
        return;
    }

    //array to collect cart items
    $cart_sort = [];
    $vinos_include_cats = WPBC_woo_get_included_terms('general_post_object_vinos_cat');
    //add cart item inside the array
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) { 
        if(!has_term( $vinos_include_cats, 'product_cat', $cart_item['product_id'] )) { 
        	$cart_sort[$cart_item_key] = WC()->cart->cart_contents[$cart_item_key];
        }
    }

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) { 
        if(has_term( $vinos_include_cats, 'product_cat', $cart_item['product_id'] )) { 
        	$cart_sort[$cart_item_key] = WC()->cart->cart_contents[$cart_item_key];
        }
    }

    //replace the cart contents with in the reverse order
    WC()->cart->cart_contents = $cart_sort;
}


/*

	Modify cart item and order items on order, emails, etc

*/


add_filter( 'woocommerce_cart_item_class', function($class, $cart_item, $cart_item_key){
	$product = wc_get_product( $cart_item['product_id'] );
	$vinos_include_cats = WPBC_woo_get_included_terms('general_post_object_vinos_cat');
	if(has_term( $vinos_include_cats, 'product_cat', $cart_item['product_id'] )) { 
		 $class .= ' is-vinos';
	}
	return $class;
},10,3 );

add_filter( 'woocommerce_cart_item_name', function($_product, $cart_item, $cart_item_key){
  
  $product = wc_get_product( $cart_item['product_id'] );
	$vinos_include_cats = WPBC_woo_get_included_terms('general_post_object_vinos_cat');
	if(has_term( $vinos_include_cats, 'product_cat', $cart_item['product_id'] )) { 
		 $_product = $product->get_name();
	}
	
	return $_product;

},10,3 ); 

add_filter( 'woocommerce_order_item_name', function($_product, $cart_item, $order){
  
  $product = wc_get_product( $cart_item['product_id'] );
	$vinos_include_cats = WPBC_woo_get_included_terms('general_post_object_vinos_cat');
	if(has_term( $vinos_include_cats, 'product_cat', $cart_item['product_id'] )) { 
		 $_product = $product->get_name();
	}else{
		if($order===false){
			$_product = "<a style='color:#6639b7; font-weight:bold; ' href='". get_the_permalink($cart_item['product_id']) ."' target='_blank'>".$_product.'</a>';
		}
	}
	
	return $_product;

},10,3 ); 



add_filter( 'woocommerce_order_item_permalink', function($product_permalink, $cart_item, $order){
	$product = wc_get_product( $cart_item['product_id'] );
	$vinos_include_cats = WPBC_woo_get_included_terms('general_post_object_vinos_cat');
	if(has_term( $vinos_include_cats, 'product_cat', $cart_item['product_id'] )) { 
		 $product_permalink = false;
	}else{
		$product_permalink = get_the_permalink($cart_item['product_id']);
	}
	//$product_permalink = false;
	return $product_permalink;
 
},10,3 );
add_filter( 'woocommerce_cart_item_permalink', function($product_permalink, $cart_item, $cart_item_key){
	$product = wc_get_product( $cart_item['product_id'] );
	$vinos_include_cats = WPBC_woo_get_included_terms('general_post_object_vinos_cat');
	if(has_term( $vinos_include_cats, 'product_cat', $cart_item['product_id'] )) { 
		 $product_permalink = false;
	}else{
		$product_permalink = get_the_permalink($cart_item['product_id']);
	}
	//$product_permalink = false;
	return $product_permalink;
 
},10,3 );