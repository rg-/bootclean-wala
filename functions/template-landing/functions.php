<?php

function WPBC_get_section_row_args($args=array(),$p=''){

	$options = !empty($args[$p.'__section_options']) ? $args[$p.'__section_options'] : array(); 


	if(!empty($options)){
		$options = array(
			'visible' => !empty($options[$p.'__section_options_visible']) ? $options[$p.'__section_options_visible'] : '',
			'style' => !empty($options[$p.'__section_options_style']) ? $options[$p.'__section_options_style'] : 'transparent',
			'style_color' => 'dark',
		);
	} 
	if( !empty( $options['style'] ) ) {
		if( !in_array( $options['style'], array( 'transparent', 'white', 'rosa', 'rosa-claro' ) )){
			$options['style_color'] = 'white';
		}
	} 

	$return = array(
		'section_id' => !empty($args[$p.'__section-title']) ? sanitize_title($args[$p.'__section-title']) : $args['acf_fc_layout'].'-'.uniqid(),
		'section_title' => !empty($args[$p.'__section-title']) ? $args[$p.'__section-title'] : '',
		'call_to_action' => !empty($args[$p.'__call_to_action']) ? $args[$p.'__call_to_action'] : '',
		'section_options' => $options,
	);    

	return $return;

}

function WPBC_acf_make_flexible_content_layout($args=array(), $layouts=array()){

	if(empty($args)) return; 

		$layout_name = !empty($args['layout_name']) ? $args['layout_name'] : 'ui-box-test';
		$layout_label = !empty($args['layout_label']) ? $args['layout_label'] : 'Box Test';
		$sub_fields = array();

		$sub_fields[] = WPBC_acf_make_tab_field(
			array(
				'key' => $layout_name.'__content_tab',
				'label' => 'Contenido',
				'placement' => 'top',
			)
		);
			if(empty($args['hide_section_title'])){
				$sub_fields[] = WPBC_acf_make_text_field(
					array(
						'name' => $layout_name.'__section-title',
						'label'=>'Título de sección', 
						'class' => 'acf-input-title', 
						'width' => '70%',
					)
				);
			}

			$content_sub_fields = $args['content_sub_fields'];
			if(!empty($content_sub_fields)){
				foreach ($content_sub_fields as $key => $value) {
					$sub_fields[] = $value;
				}
			}

		if(empty($args['hide_call_to_action'])){

				$sub_fields[] = WPBC_acf_make_tab_field(
					array(
						'key' => $layout_name.'__call_to_action_tab',
						'label'=>_x('Call to Action', 'bootclean'),
						'placement' => 'top',
					)
				);

					$sub_fields[] = WPBC_acf_make_call_to_action_group_field(
						array(
							'name' => $layout_name.'__call_to_action',
							'label'=> 'Método de visualización', 
							'default_type' => 'btn',
						)
					);

			}

		$sub_fields[] = WPBC_acf_make_tab_field(
			array(
				'key' => $layout_name.'__section_options_tab',
				'label'=>_x('Settings', 'bootclean'),
				'placement' => 'top',
			)
		); 

			$sub_fields_section_options = array();


				if(empty($args['hide_options_style'])){

					$def_color = 'transparent'; 
					$sub_fields_section_options[] = WPBC_acf_make_radio_field( array(
							'name' => $layout_name.'__section_options_style',
							'label'=>  'Esquema de color',
							'choices' => WPBC_get_acf_root_colors_choices($layout_name.'__section_options_style'),
							'default_value' => $def_color,
							'width' => '20%',
							'class' => 'wpbc-radio-as-btn no-padding-radio-label', 
						) );

				}

					$sub_fields_section_options[] = WPBC_acf_make_true_false_field(
							array(
								'name' => $layout_name.'__section_options_visible',
								'label'=>'¿Ocultar la sección?',  
								'default_value' => 0, 
								'message' => '',
								'width' => '20%', 
							)
						); 

					$sub_fields[] = WPBC_acf_make_group_field(
						array(
							'name' => $layout_name.'__section_options',
							'label'=>'',  
							'width' => '100%',
							'sub_fields' => $sub_fields_section_options,
							'class' => 'wpbc-group-no-border wpbc-group-no-label',
						)
					); 

		$layouts['layout_'.$layout_name] = array(
			'key' => 'layout_'.$layout_name,
			'name' => $layout_name,
			'label' => $layout_label,
			'display' => 'block',
			'sub_fields' => $sub_fields,
			'min' => '',
			'max' => '',
		); 

		return $layouts; 

} 