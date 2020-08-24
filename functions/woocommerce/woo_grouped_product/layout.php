<?php

/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */

add_action( 'woocommerce_before_single_product_summary', function(){  

	global $product; 
	if( $product->get_type() == 'grouped' ){
		remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash',10);
		remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_images',20);
	}

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

	if( $product->get_type() == 'grouped' ){
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
		 
	}

}, 0);

/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */ 

add_action('woocommerce_after_single_product_summary',function(){
	global $product; 
	if( $product->get_type() == 'grouped' ){
		// WPBC_get_template_part('woocommerce/grouped-product_elegir-recetas', $product); 
	}
},5);
 

/*

	Usar los fields de la pagina cuando estoy viendo en realidad el producto agrupado

	Esto aplica en varios lados, body class, usar footer, o footer alternativo, y el resto de cosas, como los template builder usados y cosas asi.

*/

add_filter( 'document_title_parts', function($title){

	if(_is_ordenar_page()){
		$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
		$title['title'] = get_the_title($ordenar_page_id); 
	}

	return $title;
}, 10,1 );

add_filter('wpbc/body/class', function($class){

	$ordenar_product_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar_product');
	$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');

	if( _wpbc_woo_if_use_pasos_nav() ){
		$class .= ' woo_using_pasos_nav';

		$layout_general_style = WPBC_get_field('layout_general_style', $ordenar_page_id);
		$class .= ' bg-'.$layout_general_style;

	}

	return $class;

},10,1);

	add_filter('wpbc/woo/layout/use_footer', function($use_footer){
		if( _wpbc_woo_if_use_pasos_nav() ){
			$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
			$use_footer = WPBC_get_field('layout_footer_template', $ordenar_page_id);
		} 
		return $use_footer;
	},10,1);
	add_filter('wpbc/woo/layout/alt_footer', function($alt_footer){
		if( _wpbc_woo_if_use_pasos_nav() ){
			$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
			$alt_footer = WPBC_get_field('layout_general_alt_footer', $ordenar_page_id); 
		} 
		return $alt_footer;
	},10,1);
	add_filter('wpbc/woo/layout/show_prefooter', function($show_prefooter){
		if( _wpbc_woo_if_use_pasos_nav() ){
			$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
			$show_prefooter = WPBC_get_field('layout_general_show_prefooter', $ordenar_page_id);
		} 
		$ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');
		if( is_product() && !is_single($ordenar_product_id) ){
			$show_prefooter = get_option('options_wpbc_theme_settings__general_single_product_prefooter');
		}
		return $show_prefooter;
	},10,1);


add_filter('wpbc/filter/layout/main-navbar/custom_collapse', function($args){  

	if( _wpbc_woo_if_use_pasos_nav() ){
		$args['collapse']['class'] = '';
		$args['collapse']['content_class'] = '';
		$args['collapse']['wp_nav_menu']['container_class'] = '';
	} 

	return $args;
},100,1);

add_filter('wpbc/filter/layout/main-navbar/defaults', function($args){

	if( _wpbc_woo_if_use_pasos_nav() ){

		$class = str_replace('navbar-expand-xl', 'navbar-expand-xs', $args['class']);
		$args['class'] = $class . ' using_pasos_nav';
		$args['before_nav_container'] = '[pasos_main_nav]';

	} 
	return $args;

},20,1); 


add_filter('wpbc/filter/layout/main-page-header/defaults',function($params){
	if( _wpbc_woo_if_use_pasos_nav() ){
		ob_start();
		$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
		WPBC_template_landing__main_container(true, $ordenar_page_id);
		$content = ob_get_contents();
		ob_end_clean();
		$params['use_custom_html'] = $content; 
	}
	return $params;
},10,1);


/*

	Insert the entire template on the main container areas strucure

*/

add_action('wpbc/woo/layout/before/main-container-areas',function($args){ 
	global $product;
	global $wp_query;
	if(empty($product)){
		$product = wc_get_product( $wp_query->queried_object->ID );

		$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
		$ordenar_product_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar_product');

		if( $product->get_type() == 'grouped' && $product->get_id() == $ordenar_product_id ){
			WPBC_get_template_part('woocommerce/grouped-product', array()); 

			/* Also insert content builder if used */
			$page_template_slug = get_page_template_slug( $ordenar_page_id ); 
			if($page_template_slug == '_template_landing_builder.php'){
				
				$rows = WPBC_get_field('landing_flexible_rows', $ordenar_page_id);
				if(!empty($rows)){
					?><div id='sections-wrapper' class="sections-wrapper-grouped-product"><?php
					foreach ($rows as $layout) {
						$acf_fc_layout = $layout['acf_fc_layout']; 
						WPBC_get_template_part('template-landing/rows/'.$acf_fc_layout, $layout);  
					}
					?></div><?php
				}

			}

		}
	} 
},99,1); 

/* Filtros y actions para estos custom fields */

function _wpbc_woo_if_use_pasos_nav(){

	$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar'); 
	$ordenar_product_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar_product');  
	
	global $wp_query;   
	$cart_page_id = get_option( 'woocommerce_cart_page_id' );
	$checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
	//_print_code($wp_query->queried_object_id);

	if( !empty($wp_query->queried_object_id) ){

		if( $wp_query->queried_object_id == $ordenar_product_id ||
					$wp_query->queried_object_id == $cart_page_id || 
					$wp_query->queried_object_id == $checkout_page_id ){

			return true;

		}

	}

}

function _is_ordenar_page(){
	$ordenar_product_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar_product');
	$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
	global $wp_query;
	if( !empty($wp_query->queried_object_id) ){
		if( $wp_query->queried_object_id == $ordenar_product_id ){
			return true;
		}
	}
}

add_shortcode('pasos_main_nav', 'pasos_main_nav_FX');

function pasos_main_nav_FX($args, $content=NULL, $tag){ 
	ob_start();
	WPBC_get_template_part('woocommerce/pasos_main_nav');
	$return = ob_get_clean(); 	
  return $return; 
}