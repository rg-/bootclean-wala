<?php

/* DEFAULT type */

add_filter('wpbc/filter/template-landing/sub_fields/?group=page_header', function($sub_fields){
	 
	$conditional_default = array (
		array (
			array (
				'field' => 'field_page_header_type', 'operator' => '==', 'value' => 'default',
			),
		), 
	);

	$page_header_type_default_fields = array();

		$conditional_sub_type = array (
			array (
				array (
					'field' => 'field_default_sub_type', 'operator' => '==', 'value' => 'default',
				),
			), 
		);

		$page_header_type_default_fields[] = WPBC_acf_make_radio_field( array(
				'name' => 'default_sub_type',
				'label'=>'', 
				'choices' => array (
					'default' => _x('Usar Imagen/es','bootclean'), 
					'no-images' => _x('No usar Imagen/es','bootclean'),  
				),
				'default_value' => 'default',
				'width' => '100%',
				'class' => 'wpbc-radio-as-btn as-btn-secondary wpbc-field-no-label '
			) );


		$page_header_type_default_fields[] = WPBC_acf_make_subtitle_field(
			array(
				'key' => 'field_gallery_subtitle', 
				'label'=>'Imagen/es de fondo',  
				'conditional_logic' => $conditional_sub_type,
			)
		);

		$page_header_type_default_fields[] = WPBC_acf_make_gallery_advanced_field(
			array(
				'name' => 'gallery_images',
				'label'=>'',
				'class' => 'acf-small-gallery wpbc-field-no-label', 
				'columns' => 6, 
				'conditional_logic' => $conditional_sub_type,
			)
		);  

		$page_header_type_default_fields[] = WPBC_acf_make_subtitle_field(
			array(
				'key' => 'content_subtitle',
				'label'=>'Contenido', 
			)
		);
	 
		$page_header_type_default_fields[] = WPBC_acf_make_text_field(
			array(
				'name' => 'content',
				'label'=>'Texto/Claim', 
				'class' => 'acf-input-title', 
			)
		); 
		
		$page_header_type_default_fields[] = WPBC_acf_make_call_to_action_group_field(
			array(
				'name' => 'call_to_action',
				'label'=> _x('Call to Action', 'bootclean'), 
				'default_type' => 'none', 
			)
		); 

	$sub_fields[] = WPBC_acf_make_group_field(
		array(
			'name' => 'page_header_'.'default', // notice each type should be a group named with type name
			'label'=> '', 
			'class' => 'wpbc-field-no-label',  
			'conditional_logic' => $conditional_default,
			'sub_fields' => $page_header_type_default_fields,
		)
	);

	return $sub_fields;

}, 11, 1);