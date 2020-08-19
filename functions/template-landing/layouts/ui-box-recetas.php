<?php

add_filter('wpbc/filter/group_landing_flexible_content/layouts', 'build_ui_box_recetas',20,1); 

add_filter('WPBC_acf_builder_layouts', 'build_ui_box_recetas',10,1); 

function build_ui_box_recetas($layouts){

	$content_sub_fields = array();  

		$content_sub_fields[] = WPBC_acf_make_radio_field( array(
				'name' => 'ui-box-recetas__type',
				'label'=>'Mostrar como:', 
				'choices' => array (
					'slider' => 'Carrusel de items', 
					'columns' => 'Items en Columnas', 
				),
				'default_value' => !empty($args['default_type']) ? $args['default_type'] : 'none',
				'width' => '100%',
				'class' => 'wpbc-radio-as-btn show-radio'
			) );

		$content_sub_fields[] = WPBC_acf_make_number_field(
				array(
					'name' => 'ui-box-recetas__max_posts',
					'label'=>'Cantidad máxima', 
					'default_value' => 12,
					'width'=>'20%' 
				)
			);

		$content_sub_fields[] = WPBC_acf_make_select_field(
				array(
					'name' => 'ui-box-recetas__orderby',
					'label'=> 'Ordenar por',  
					'choices' => array(
						'title' => 'Título',
						'data' => 'Fecha',
						'rand' => 'Randómico'
					),
					'default_value' => 'rand',
					'width' => '20%' 
				)
			);

	$layouts = WPBC_acf_make_flexible_content_layout(array(
		'layout_name' => 'ui-box-recetas',
		'layout_label' => '<i class="dot-badge"></i> Recetas',
		'content_sub_fields' => $content_sub_fields,
	), $layouts);

	return $layouts;

}