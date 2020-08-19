<?php

include('template-landing/functions.php');

/*

	TEMPLATE LANDING

	In this case i´m using just default "page header" section
	Rest is a flexible content group

	See how i add this part into 'wpbc/layout/start'
	so sections from this flexible whil be placed inside "main-content-wrap" just before footer

*/

add_filter('wpbc/filter/template-landing/exclude_page_settings', '__return_true',10,1 );

/*

	Disable section helper (key field) on admin

*/

add_filter('wpbc/filter/template-landing/fields/show_helper','__return_false',10,1);

/*

	Template Landing custom child settings

*/ 


add_filter('wpbc/filter/layout/main-navbar/defaults', 'wpbc_child_main_navbar_template_landing',10,1);
function wpbc_child_main_navbar_template_landing($args){
	if(is_page_template('_template_landing_builder.php')){
		// $args['affix'] = true; 
		// $args['affix_defaults']['simulate'] = false;
	}
	return $args;
}

/*

	Wrap sections into DIV

*/

add_action('wpbc/layout/start', function(){
	if(is_page_template('_template_landing_builder.php')){
		echo do_shortcode('[WPBC_get_template name="template-landing/landing_flexible_rows"]');
	}
},31);

add_action('wpbc/layout/sections/start', function($sections, $is_page_header){
	if(!$is_page_header) {

		echo "<div id='sections-wrapper'>";
		

	}
},0,2);
add_action('wpbc/layout/sections/end', function($sections, $is_page_header){
	if(!$is_page_header) echo "</div>";
},0,2);

add_filter('wpbc/filter/template-landing/default_section', function($default_section){

	$default_section['acf']['label'] = 'Portada de página';
	$default_section['acf']['group_layout'] = 'block';

	return $default_section;
},10,1 ); 

/*

	Add new section, needs template-parts/template-landing/section-1.php file

*/

add_filter('wpbc/filter/template-landing/build_sections', function($build_sections){  
	return $build_sections;
},10,1);


/*
	
	Add fields into existing sectinons by group_id.

	Ex:

	'wpbc/filter/template-landing/sub_fields/?group=[GROUP_ID]'

		@return $sub_fields array()

*/ 

/* 
	GROUP page_header 
*/

/* Tipo de encabezado */

add_filter('wpbc/filter/template-landing/sub_fields/?group=page_header', function($sub_fields){
	$sub_fields[] = WPBC_acf_make_radio_field( array(
		'name' => 'page_header_type',
		'label'=>'Tipo de encabezado', 
		'instructions' => 'Al cambiar de <b>Tipo de encabezado</b> y <u>Actualizar</u>, no se perderán los datos del Tipo no usado.',
		'choices' => array (
			'none' => _x('Disabled','bootclean'), 
			'default' => _x('Default','bootclean'), 
			'video' => _x('Video','bootclean'), 
			'template'=> _x('Template','bootclean'),
			'html'=> _x('HTML','bootclean'),
		),
		'default_value' => !empty($args['default_type']) ? $args['default_type'] : 'default',
		'width' => '100%',
		'class' => 'wpbc-radio-as-btn as-btn-lg show-radio',
	) );
	return $sub_fields;
},10,1);

		/* 
			Include en each file, los fields de cada type de encabezado  
		*/

		include('template-landing/sections/default.php');
		include('template-landing/sections/video.php');
		include('template-landing/sections/template.php');
		include('template-landing/sections/html.php'); 

/*

	ADDING A CUSTOM FLEXIBLE AREA INTO LANDING TEMPLATE
	
	after_setup_theme it´s crucial here in order to use the WPBC_acf_make functions

*/

include('template-landing/layouts.php');  

add_action('after_setup_theme', function(){    

	if( function_exists('acf_add_local_field_group') ){
	 
		$layouts = apply_filters('wpbc/filter/group_landing_flexible_content/layouts', array()); 

		acf_add_local_field_group(array(
			'key' => 'group_landing_flexible_content',
			'title' => 'Contenido',
			'fields' => array(
				array(
					'key' => 'field_landing_flexible_rows',
					'label' => '',
					'name' => 'landing_flexible_rows',
					'type' => 'flexible_content',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layouts' => $layouts,
					'button_label' => '<span class="dashicons dashicons-plus"></span> Agregar Layout',
					'min' => '',
					'max' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'page_template',
						'operator' => '==',
						'value' => '_template_landing_builder.php',
					),
				),
			),
			'menu_order' => 10,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));

	}  

});

add_action('admin_head',function(){
?>
<style>
	#acf-group_landing_flexible_content{ 
	}
	#acf-group_landing_flexible_content > .ui-sortable-handle{
		cursor: default!important;
    pointer-events: none;
    font-size: 1.3em!important;
  	padding: 9px 12px!important;
  	display: block !important; 
	}

</style>
<?php
});