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
include('woocommerce/layout-emails.php'); 

include('woocommerce/acf-woo_single_product.php');
include('woocommerce/acf-woo_extra_taxonomy.php'); 

include('woocommerce/post_type-ingredientes.php');
// include('woocommerce/collapse-woo-mini-cart.php');  


include('woocommerce/checkout-delivery-date-selector.php');




/** Disable Ajax Call from WooCommerce */
add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_cart_fragments', 11); 
function dequeue_woocommerce_cart_fragments() { 

	if ( is_front_page() || is_single() ) {

		wp_dequeue_script('wc-cart-fragments'); 

	}

}


//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){
    

    if( !is_user_logged_in() ){

    	wp_dequeue_style( 'wp-block-library' );
	    wp_dequeue_style( 'wp-block-library-theme' );
	    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS

			wp_dequeue_style( 'bootclean-admin' );

    }

} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

/** Disable All WooCommerce  Styles and Scripts Except Shop Pages*/
add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 99 );
function dequeue_woocommerce_styles_scripts() {

		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
			# Styles 

			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce_frontend_styles' );
			wp_dequeue_style( 'woocommerce_fancybox_styles' );
			wp_dequeue_style( 'woocommerce_chosen_styles' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			# Scripts
			wp_dequeue_script( 'wc_price_slider' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'wc-cart-fragments' );
			wp_dequeue_script( 'wc-checkout' );
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-cart' );
			wp_dequeue_script( 'wc-chosen' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'fancybox' );
			wp_dequeue_script( 'jqueryui' );
		} 
		
}