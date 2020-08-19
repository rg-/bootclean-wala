<?php

add_filter('wpbc/filter/template-landing/sub_fields/?group=page_header', function($sub_fields){

	$conditional = array (
		array (
			array (
				'field' => 'field_page_header_type', 'operator' => '==', 'value' => 'html',
			),
		), 
	);

	$type_sub_fields = array(); 

		$type_sub_fields[] = WPBC_acf_make_codemirror_field(
			array(
				'name' => 'textarea', 
			)
		);

	$sub_fields[] = WPBC_acf_make_group_field(
		array(
			'name' => 'page_header_'.'html', // notice each type should be a group named with type name
			'label'=> '', 
			'class' => 'wpbc-field-no-label',  
			'conditional_logic' => $conditional,
			'sub_fields' => $type_sub_fields,
		)
	);

	return $sub_fields;

}, 13, 1);