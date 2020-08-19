<?php

/*
 * Bootclean Child Theme Widgets
 * 
 * @related files (somme):
 *
 *		> template-parts/layout/secondary-content.php
 *		> bc/core/setup/widgets_init.php
 *
 */


/*
 * widgets_init
 */

add_action( 'widgets_init', 'child_WPBC_widgets_init' );

function child_WPBC_widgets_init(){

	// Changing an already registered widget area name
	add_filter('WPBC_widgets_init__defaults', function($defatuls_widgets){ 
		$defatuls_widgets[1]['name'] = 'Widget Area Primary';
		return $defatuls_widgets; 
	},10,1);

	// Filter widgets fields
	add_filter('wpbc/filter/widgets/custom_fields/before_widget', function($before_widget){ 
		$before_widget = '<div class="widget-box gmb-3 [VAL]">';
		return $before_widget;
	},10,1); 
	add_filter('wpbc/filter/widgets/custom_fields/before_title', function($before_title){
		$before_title = '<h4 class="section-title gmb-1 gpb-1 border-bottom [VAL]">';
		return $before_title;
	});

	// Set defaults widgets areas if...
	add_filter('wpbc/filter/layout/secondary-content/defaults_widgets', function($defaults_widgets, $name){
		if($name=='area-1'){
			$defaults_widgets[] = 'widget_area_1';
		}
		if($name=='area-2'){
			//$defaults_widgets[] = 'widget_area_2';
		}
		return $defaults_widgets;
	},10,2);

	// Change shortcode output for the secondary content areas
	add_filter('wpbc/filter/layout/content-area/shortcode/area-1', function($shortcode, $key, $value){
		//$shortcode = '[WPBC_get_template name="layout/secondary-content" args="name:area-1"/]';
		return $shortcode;
	},10,3);
	// Notice that if you change one, you should also change both, like
	add_filter('wpbc/filter/layout/content-area/shortcode/area-2', function($shortcode, $key, $value){
		//$shortcode = '[WPBC_get_template name="layout/secondary-content" args="name:area-2"/]';
		return $shortcode;
	},10,3);
}

/*
 * widgets_admin_page
 */

add_action( 'widgets_admin_page', 'child_WPBC_widgets_admin_page' );

function child_WPBC_widgets_admin_page(){

	// Get the global widgets
  $preview_widgets = $GLOBALS['wp_registered_sidebars'];

  // Remove widgets
  // unset ( $preview_widgets['wp_inactive_widgets'] );
  
  // Add custom html into widgets.php template
  ?>
  <div class="" style="border:2px solid #dedede;padding:10px 20px;margin-top:20px;">
  	<h3>Widgets</h3>
  </div>
	<?php
}