<?php

/*

	Modify the WPBC woocommerce main settings


	$wpbc_woocommerce_config = array(
	
		'widgets' => ....

	)

*/

add_filter('wpbc/filter/woocommerce/config', 'child_woocommerce_config',10,1);

function child_woocommerce_config($wpbc_woocommerce_config){

	/*
		Change widgets (NEVER EVER CHANGE IDS ON PRODUCTION SITE!!!!!)

		by default config has 2 woo widgets areas:

			widget_area_woocommerce
			widget_area_woocommerce_products

		You could unset one, both, add new ones, or modify args on default ones.

	*/

	//$wpbc_woocommerce_config['widgets']['widget_area_woocommerce']['name'] = 'Custom widget name here';
	//$wpbc_woocommerce_config['widgets']['widget_area_woocommerce']['description'] = 'Custom description here';


	$wpbc_woocommerce_config['layout']['shop'] = array(

		'main_container_areas_class' => 'container',
		'main_container_row_class' => 'row',
		'content_areas_cols' => array(
			'main_class' => 'col-12',
			'col_class' => 'col-12',
			//'col_content' => do_shortcode('[WPBC_get_template name="layout/secondary-content" args="name:area-1"/]'),
		),
		'content_areas_single' => array(
			'main_class' => 'col-12', 
		),

	);  

	// $wpbc_woocommerce_config['layout']['before_woo-main-container-area'] = do_shortcode('[WPBC_get_template name="woocommerce/grouped-product_elegir-recetas" /]');

	return $wpbc_woocommerce_config;
} 

add_filter('wpbc/filter/layout/locations', function($locations){
	if( is_account_page() ){
		$locations['page']['id'] = 'a1'; 
		$locations['page']['args']['container_type'] = 'fixed'; 
	}
	if( is_cart() || is_checkout() ){
		$locations['page']['id'] = 'a1';  
	} 
	return $locations;  
}, 20, 1 ); 

add_filter('wpbc/filter/layout/location', function($layout, $template, $using_theme_settings, $using_page_settings){
	if($template == 'page'){
		//$layout = 'a2-ml';
		if( is_account_page() || is_cart() || is_checkout() ){
			$layout = 'a1';
		}
	}
	return $layout;
},10,4);


add_filter('wpbc/filter/layout/start/defaults', function($args){  
	if( is_account_page() || is_cart() || is_checkout() ){
		$args['main_content']['wrap']['class'] = 'gpy-2';
	}
	return $args;
});  


/* Use grouped related page ($ordenar_page_id) settings for some other woo pages like cart... */

add_action('wpbc/layout/start', function(){
	
	if( is_account_page() || is_cart() || is_checkout() ){

		$ordenar_page_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar');
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

}, 50 );