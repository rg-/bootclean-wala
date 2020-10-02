<?php
/* ################################################################################## */
/* ################################################################################## */
/**
 * Bootclean child custom functions
 *
 * @package Bootclean
 * @subpackage Child Theme
 * 
 */
/* ################################################################################## */

/**
 * @subpackage Enable "is_inview" Addon
 */
	 
	add_filter('wpbc/filter/is_inview/installed', '__return_true',0,1);

/* ################################################################################## */

/**
 * @subpackage Enable "theme_settings" options pages
 */

	add_filter('wpbc/filter/theme_settings/installed', '__return_true');
		
		/* Customs for theme settings here */
		
		include('functions/addon-theme_settings.php');

/* ################################################################################## */

/**
 * @subpackage Enable "swup" addon
 */

	// add_filter('wpbc/filter/swup/installed', '__return_true');
	// include('functions/addon-swup.php');

/* ################################################################################## */

/**
 * @subpackage Enable "private_areas" addon
 */

	// add_filter('wpbc/filter/private_areas/installed', '__return_true');
	// include('functions/addon-private_areas.php');

/* ################################################################################## */

/**
 * @subpackage "theme-*" customs
 */ 

	include('functions/theme-textdomain.php'); 
	include('functions/theme-login.php'); 
	include('functions/theme-options.php');
	include('functions/theme-under-construction.php'); 
	include('functions/theme-options-page-settings.php');
	include('functions/theme-scripts.php');
	include('functions/theme-fonts.php');
	// include('functions/theme-widgets.php');

/* ################################################################################## */

/* core */
// include('functions/core-theme_support.php'); 

/* ################################################################################## */

/* front-end layout */ 
include('functions/layout.php');
include('functions/layout-navmenus.php');
include('functions/layout-page-header.php');

/* ################################################################################## */

/**
 * @subpackage WooCommerce
 */
if( class_exists( 'WooCommerce' ) ){
	include('functions/plugins-woocommerce.php');
}
if( class_exists('SZBD') ){

	function enable_shop_manager_delivery_zones() {
    
    $admin = get_role('shop_manager');
    
    if($admin->has_cap('publish_szbdzones')) return;

    flush_rewrite_rules();
    $admin_capabilities = array(
      'delete_szbdzones',
      'delete_others_szbdzones',
      'delete_private_szbdzones',
      'delete_published_szbdzones',
      'edit_szbdzones',
      'edit_others_szbdzones',
      'edit_private_szbdzones',
      'edit_published_szbdzones',
      'publish_szbdzones',
      'read_private_szbdzones'
    );
    foreach ($admin_capabilities as $capability) {
      $admin->add_cap($capability);
    }
  }
  enable_shop_manager_delivery_zones();

}

/* ################################################################################## */

include('functions/template-landing.php');

/* ################################################################################## */


/* ################################################################################## */

	include('functions/theme-shortcodes.php');
	include('functions/theme-wpbc_grayscale_image.php');

/* ################################################################################## */   

add_filter('wpbc/filter/acf/call_to_action_group/color_choices/default_value', function ($default_value, $field_name){
	$default_value = 'violeta';
	return $default_value;
},10,2);

add_filter('wpbc/filter/acf/call_to_action_group/btn/attrs', function($attrs, $field){
	$attrs .= ' data-btn="fx" ';
	return $attrs;
},10,2);

add_filter('wpbc/filter/acf/root_color_select_choices', function($style_choices, $field_name){

	unset($style_choices['primary']);
	unset($style_choices['secondary']);
	unset($style_choices['info']);
	unset($style_choices['success']);
	unset($style_choices['warning']);
	unset($style_choices['danger']);
	unset($style_choices['light']);

	return $style_choices;
},10,2);

add_filter('wpbc/filter/acf/root_color_choices', function($style_choices, $field_name){

	unset($style_choices['primary']);
	unset($style_choices['secondary']);
	unset($style_choices['info']);
	unset($style_choices['success']);
	unset($style_choices['warning']);
	unset($style_choices['danger']);
	unset($style_choices['light']);

	return $style_choices;
},10,2);