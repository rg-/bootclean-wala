<?php

add_filter('wpbc/filter/group_landing_flexible_content/layouts', 'build_ui_box_icon',30,1); 

add_filter('WPBC_acf_builder_layouts', 'build_ui_box_icon',10,1);

function build_ui_box_icon($layouts){
	$content_sub_fields = array();  

		$sub_fields_boxes = array();
			$sub_fields_boxes[] = WPBC_acf_make_image_field(
				array(
					'name' => 'ui-box-icon__boxes_image',
					'label'=>'Icono',  
					'width' => '20%', 
				)
			);
			$sub_fields_boxes_group = array(); 
			$sub_fields_boxes_group[] = WPBC_acf_make_textarea_field(
				array(
					'name' => 'ui-box-icon__boxes_text',
					'label'=>'Texto',   
				)
			);
			$sub_fields_boxes[] = WPBC_acf_make_group_field(
				array(
					'name' => 'ui-box-icon__boxes_group',
					'label'=>'',  
					'width' => '80%',
					'sub_fields' => $sub_fields_boxes_group,
				)
			);

			$content_sub_fields[] = WPBC_acf_make_repeater_field(
				array(
					'name' => 'ui-box-icon__boxes',
					'label'=>'Columnas', 
					'button_label' => 'Agregar Columna',
					'sub_fields' => $sub_fields_boxes, 
					'collapsed' => 'field_ui-box-icon__boxes_image',
				)
			);

	$layouts = WPBC_acf_make_flexible_content_layout(array(
		'layout_name' => 'ui-box-icon',
		'layout_label' => '<i class="dot-badge"></i> Icono/Texto en Columnas',
		'content_sub_fields' => $content_sub_fields,
	), $layouts); 
	return $layouts; 
} 