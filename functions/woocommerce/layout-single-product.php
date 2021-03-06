<?php


add_filter('wpbc/filter/woocommerce/config', function ($wpbc_woocommerce_config){
	 

	$wpbc_woocommerce_config['layout']['product'] = array(
		'class' => 'col-images-md-6 col-summary-md-6',
		'tab_class' => 'col-12',
		'upsell_class' => 'col-12',
		'related_class' => 'col-12',
	);
	
	return $wpbc_woocommerce_config;

},10,1);


add_filter('wpbc/filter/layout/start/defaults', function($args){
	if( is_product() ){
		
		$ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');
		if(is_single($ordenar_product_id)){
			$args['main_content']['wrap']['class'] = 'gpt-2 mt-2';
		}else{
			$args['main_content']['wrap']['class'] = 'gpt-md-2 mt-2';
		}

	} 
	return $args;
}); 


add_action('init',function(){

	add_action('wpbc/woo/layout/after/main-container-areas', function(){ 
		$ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');
		if( is_product() && !is_single($ordenar_product_id) ){
			// 
			$product_template = get_option('options_wpbc_theme_settings__general_single_product_template');
			if(!empty($product_template)){
				echo do_shortcode('[WPBC_get_template id="'.$product_template.'"/]');
			}
		}
	},60);

});

/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb' , 20 );


/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */

add_action( 'woocommerce_before_single_product_summary', function(){  

	global $product;  

}, 0);


/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */ 

add_action( 'woocommerce_single_product_summary', function(){  

	global $product; 

	remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating',10);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing',50);

	if( $product->get_type() == 'simple' ){
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
		WPBC_get_template_part('woocommerce/single-product_summary', $product); 
	}  

}, 0);


/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action('woocommerce_after_single_product_summary',function(){
	global $product;
	if( $product->get_type() == 'simple' ){
		WPBC_get_template_part('woocommerce/single-product_ingredientes', $product); 
		WPBC_get_template_part('woocommerce/single-product_paso-a-paso', $product);  
	} 
},5);
 

add_filter( 'woocommerce_gallery_image_size', function( $size ) {
    return 'full';
} );

add_filter( 'woocommerce_single_product_image_thumbnail_html', function($html, $post_thumbnail_id){

	$image_large = wp_get_attachment_image_src($post_thumbnail_id, 'large');
	$image_medium = wp_get_attachment_image_src($post_thumbnail_id, 'medium'); 
	$image_blured = wp_get_attachment_image_src($post_thumbnail_id, 'wpbc_blured_image'); 
	$html = '<div data-is-inview="detect" class="position-relative"><img alt=" " data-is-inview-lazysrc="'.$image_large[0].'" src="'.$image_blured[0].'"/></div>';
	return $html;

}, 10,2 );