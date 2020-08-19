<?php

/*

	Add a collapsable mini cart
	A button somewhere must be also inserted, like on the main navbar with cart icon and cart item count on basket....
	Or could have it´s own "open" button somewhere positioned fixed.

*/
add_action('wpbc/layout/body/end', function(){ 
	$params = array(
		'id' => 'collapse-woo-mini-cart',
		'content' => '[WPBC_woo_mini_cart]',
		'attrs' => 'style="width:480px;"',
	); 
	if(is_cart() || is_checkout()){
			
	}else{
		WPBC_get_component('collapse-custom',$params); 
	}
	 
}, 60); 


/*

	Add WooCommerce Cart Icon to Menu with Cart Item Count

*/  

/**
 * Add WooCommerce Cart Menu Item Shortcode to particular menu
 * See [WPBC_woo_cart_btn] shorcode
 */  
add_filter('wp_nav_menu_items', 'WPBC_woo_cart_btn__nav', 10, 2);
function WPBC_woo_cart_btn__nav($items, $args){
    if( $args->theme_location == 'right_menu' ){
        $items .=  '<li>[WPBC_woo_cart_btn]</li>'; 
    }
    return $items;
}

add_filter('wpbc/filter/woocommerce/cart_btn_link',function($args){
	$args['atts'] = 'data-toggle="collapse-custom" data-target="#collapse-woo-mini-cart" aria-expanded="false"';
	// $args['href'] = '#';
	return $args;
},10,1);