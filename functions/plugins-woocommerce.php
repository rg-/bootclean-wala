<?php

/*

	Even WPBC detects Woocomerce and define a constant:

	 "WPBC_WOOCOMMERCE_ACTIVE" 

	 Note: on templates can use the function WPBC_is_woocommerce_active() true/false

	Customizations must be enabled like so:

*/
add_filter('wpbc/filter/woocommerce/enable_customise','__return_true',10,1); 

function wpbc_woo_remove_post_type_page_from_search() {
    global $wp_post_types;
    $wp_post_types['product']->exclude_from_search = true;
}
add_action('init', 'wpbc_woo_remove_post_type_page_from_search');

add_filter('product_type_selector', 'wpbc_woo_custom_product_type_selector');
function wpbc_woo_custom_product_type_selector() {
	$product_type = array(
			'simple'   => __( 'Simple product', 'woocommerce' ),
			'grouped'  => __( 'Grouped product', 'woocommerce' ),
			//'external' => __( 'External/Affiliate product', 'wcvendors-pro' ),
			//'variable' => __( 'Variable product', 'wcvendors-pro' ),
			// For the last product type, make sure there is NO COMMA after the right ) parenthesis.
	);
	return $product_type;
}

function wpbc_woo_remove_product_type_options( $options ) { 

    if ( isset( $options['virtual'] ) ) {
    	unset( $options['virtual'] );
    }
    
    if ( isset( $options['downloadable'] ) ) {
        unset( $options['downloadable'] );
    }
    
    return $options;
}
add_filter( 'product_type_options', 'wpbc_woo_remove_product_type_options' );

// include('woocommerce/admin.php'); 

include('woocommerce/rewrite_rules.php'); 
include('woocommerce/enqueue.php');

/* Advanced grouped product settings */
include('woocommerce/woo_grouped_product.php');

include('woocommerce/layout.php'); 
include('woocommerce/layout-single-product.php'); 
include('woocommerce/layout-my-account.php'); 
include('woocommerce/layout-checkout.php'); 

include('woocommerce/acf-woo_single_product.php');
include('woocommerce/acf-woo_extra_taxonomy.php'); 

include('woocommerce/post_type-ingredientes.php');
// include('woocommerce/collapse-woo-mini-cart.php');  