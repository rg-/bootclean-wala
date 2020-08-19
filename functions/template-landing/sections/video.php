<?php

add_filter('wpbc/filter/template-landing/sub_fields/?group=page_header', function($sub_fields){
	
	$conditional_logic = array (
		array (
			array (
				'field' => 'field_page_header_type', 'operator' => '==', 'value' => 'video',
			),
		), 
	);

	$type_sub_fields = array();

		$type_sub_fields[] = WPBC_acf_make_text_field(
			array(
				'name' => 'video_youtube_id',
				'label' => 'Youtube ID', 
				'width' => '40%',
			)
		);

		$type_sub_fields[] = WPBC_acf_make_radio_field( array(
				'name' => 'video_youtube_embedby',
				'label'=>'Aspect ratio', 
				'choices' => array (
					'1by1' => _x('1by1','bootclean'), 
					'4by3' => _x('4by3','bootclean'), 
					'16by9'=> _x('16by9','bootclean'),
					'21by9'=> _x('21by9','bootclean'),
				),
				'default_value' => !empty($args['default_embedby']) ? $args['default_embedby'] : '16by9',
				'width' => '40%',
				'class' => 'wpbc-radio-as-btn as-btn-secondary',
			) );

	$sub_fields[] = WPBC_acf_make_group_field(
		array(
			'name' => 'page_header_'.'video', // notice each type should be a group named with type name
			'label'=> '', 
			'class' => 'wpbc-field-no-label',  
			'conditional_logic' => $conditional_logic,
			'sub_fields' => $type_sub_fields,
		)
	);

	return $sub_fields;
},12,1);