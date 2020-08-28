<?php

function child_register_nav_menu(){
    register_nav_menus( array( 
        'right_menu'  => __( 'Menu Secundario'),
    ) );

    register_nav_menus( array( 
        'left_footer'  => __( 'Footer Menu Primario'),
    ) );
    register_nav_menus( array( 
        'right_footer'  => __( 'Footer Menu Secundario'),
    ) );
    register_nav_menus( array( 
        'call_to_action_footer'  => __( 'Footer Menu Call to Action'),
    ) );
}
add_action( 'after_setup_theme', 'child_register_nav_menu', 0 );

/*

	Filter main-navbar settings

*/

/*

	Adding the right_menu as a secondary nav into the collapse-custom we are going to create later

*/

add_filter('wpbc/filter/layout/collapse-custom/nav_menus', function($nav_menus){
	$nav_menus[] = array(
			'theme_location'  => 'right_menu',
			'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => 'navbar-right_menu',
			'menu_class'      => 'navbar-nav',
			'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
			'walker'          => new WP_Bootstrap_Navwalker(), 
			'before_menu'			=> '',
			'after_menu'			=> '',
		);
	return $nav_menus;
},10,1);

/*

	Passing arguments to this filter will create (and disable the default one) a custom navbar collapsable.

*/
add_filter('wpbc/filter/layout/main-navbar/custom_collapse', function($args){

		$args['collapse']['inside_nav'] = true;

		$args['collapse']['id'] = 'collapse-custom';
		$args['collapse']['class'] = 'collapse-custom-right'; 
		$args['collapse']['toggler_class'] = 'toggler-white';
		$args['collapse']['toggler_attrs'] = ' data-btn="fx" '; 
	 
		$args['collapse']['class'] .= ' w-xl-100 order-2';
		$args['collapse']['content_class'] = 'd-xl-flex justify-content-end';
		$args['collapse']['wp_nav_menu']['container_class'] = 'gmr-xl-6';  

		return $args;
	},99,1);
	
/*

	Rest of filters for main-navbar
	
*/

add_filter('wpbc/filter/layout/main-navbar/defaults', function($args){
	
	$expand = 'navbar-expand-xl'; 
	$color = 'bg-transparent';
	if( class_exists( 'WooCommerce' ) ){
		if(is_account_page()){
			$color = 'bg-white';
		} 
	}

	$args['class'] = 'navbar navbar-expand-aside collapse-right fasdfa '.$color.' '.$expand; 

	$args['nav_attrs'] = ' data-affix-removeclass="bg-transparent" data-affix-addclass="shadow-sm bg-violeta" ';

	$args['container_class'] = 'container align-items-start gpx-1 ';

	// navbar brand
	$args['navbar_brand']['class'] = 'order-1';
	$args['navbar_brand']['attrs'] = ' data-affix-removeclass="" data-affix-addclass="" ';  
 
 	// use args for the navbar-brand...
	$logo = '[WPBC_get_stylesheet_directory_uri]/images/theme/wala-violet.svg';
	$args['navbar_brand']['title'] = '<img width="120" src="'.$logo.'" alt="'.get_bloginfo('title').'" data-affix-addclass=""/>'; 
	// ... or a shortcode
	$args['navbar_brand']['title'] = '[icon_walla class="fill-primary"]';

	// navbar toggler
	$args['navbar_toggler']['class'] = 'toggler-primary order-3';
	$args['navbar_toggler']['type'] = 'animate';
	$args['navbar_toggler']['effect'] = 'close-arrow'; 
	//$args['navbar_toggler']['attrs'] = 'data-affix-addclass="toggler-white" data-affix-removeclass="toggler-white"'; 

	//$args['wp_nav_menu']['container_class'] = 'collapse navbar-collapse flex-row-reverse mx-auto order-3';
	//$args['wp_nav_menu']['menu_class'] = 'navbar-nav nav'; 
	 
	$affix = false;
	$simulate = true; 

	global $post;
	if(WPBC_if_has_page_header($post->ID)){
		//$simulate = false; 
	}

	$args['affix'] = $affix;
	
	$args['affix_defaults']['simulate'] = $simulate;
	//$args['affix_defaults']['simulate_target'] = '#main_navbar_container';
	$args['affix_defaults']['breakpoint'] = 'xs';
	$args['affix_defaults']['scrollify'] = false;   
	$args['affix_defaults']['offset'] = '111px'; 
	//$args['affix_defaults']['simulate_resize'] = 'false';
	//$args['affix_defaults']['position'] = 'fixed-top';   
	$args['affix_defaults']['target'] = '#main-content-wrap';   
	return $args;
},10,1);  

/*
	Alter output html for menus
*/
function nav_replace_wpse_189788($item_output, $item) {  
	return $item_output; 
}
add_filter('walker_nav_menu_start_el','nav_replace_wpse_189788',10,2);


/*
	Disable main-navbar from templates
*/
add_filter('wpbc/filter/layout/main-navbar/defaults',function ($params){
	//$params['use_custom_template'] = 'none';
	return $params;
},10,1); 


/*
	Add items into menus
*/
add_filter('wp_nav_menu_items', 'add_admin_link', 10, 2);
function add_admin_link($items, $args){

	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' ); 
	$myaccount_page_title = get_the_title($myaccount_page_id);
		$myaccount_menu_label = $myaccount_page_title;
	$myaccount_page_url = get_the_permalink($myaccount_page_id);

	$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
		$ordenar_page_title = get_the_title($ordenar_page_id);
		$ordenar_page_label = 'Ordená Ahora';
		$ordenar_page_url = get_the_permalink($ordenar_page_id);

	if(is_user_logged_in()){
		$wp_get_current_user = wp_get_current_user();  
		$myaccount_menu_label = '<i><b>'.$wp_get_current_user->user_login.'</b></i>'; 
	}
 

  if( $args->theme_location == 'right_menu' ){ 

  	$start_menu_item = '<li class="nav-item menu-item">'; 
		$start_menu_item .= '<a title="'.$myaccount_page_title.'" href="'.$myaccount_page_url.'" class="nav-link">'.$myaccount_menu_label.'</a>';
		$start_menu_item .= '</li>';

		if( function_exists('_wpbc_woo_if_use_pasos_nav') && !_wpbc_woo_if_use_pasos_nav() ){ 

			$start_menu_item .= '<li class="nav-item menu-item">'; 
			$start_menu_item .= '<a title="'.$ordenar_page_title.'" href="'.$ordenar_page_url.'" class="btn btn-primary btn-order-now" data-btn="fx">'.$ordenar_page_label.'</a>';
			$start_menu_item .= '</li>';

		}

   $items = $start_menu_item . $items; 
      
  }
  if( $args->theme_location == 'call_to_action_footer' ){
  	$start_menu_item .= '<li class="nav-item menu-item">'; 
		$start_menu_item .= '<a title="'.$ordenar_page_title.'" href="'.$ordenar_page_url.'" class="btn btn-primary btn-order-now" data-btn="fx">'.$ordenar_page_label.'</a>';
		$start_menu_item .= '</li>';
		$items = $start_menu_item . $items; 
  }

  return $items;
}


/* 
	Disable dropdown markup on BootstrapNavWalker 
*/
// add_filter('nav_menu_use_dropdown',function(){ return false; });