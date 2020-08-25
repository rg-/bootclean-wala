<?php

add_filter('wpbc/filter/group_landing_flexible_content/layouts', 'build_ui_box_thumb_rows',10,1); 

/*

	Replicate layout to use it also on the Builder Rows builder 
	Needs also a template-parts/builder/[LAYOUT_NAME] file

*/
add_filter('WPBC_acf_builder_layouts', 'build_ui_box_thumb_rows',10,1); 

function build_ui_box_thumb_rows($layouts){
	$content_sub_fields = array();

		$sub_fields_boxes = array();
			$sub_fields_boxes[] = WPBC_acf_make_image_field(
				array(
					'name' => 'ui-box-thumb-rows__boxes_image',
					'label'=>'Imagen',  
					'width' => '20%', 
				)
			);
			$sub_fields_boxes_group = array();
			$sub_fields_boxes_group[] = WPBC_acf_make_text_field(
				array(
					'name' => 'ui-box-thumb-rows__boxes_title',
					'label'=>'Título',   
				)
			);
			$sub_fields_boxes_group[] = WPBC_acf_make_textarea_field(
				array(
					'name' => 'ui-box-thumb-rows__boxes_text',
					'label'=>'Texto',   
				)
			);
			$sub_fields_boxes[] = WPBC_acf_make_group_field(
				array(
					'name' => 'ui-box-thumb-rows__boxes_group',
					'label'=>'',  
					'width' => '80%',
					'sub_fields' => $sub_fields_boxes_group,
				)
			);

			$sub_fields_boxes[] = WPBC_acf_make_text_field(
				array(
					'name' => 'ui-box-thumb-rows__boxes_shortcode',
					'label'=> 'Elemento sobre la imagen (shortcode)',   
				)
			);

			$content_sub_fields[] = WPBC_acf_make_repeater_field(
				array(
					'name' => 'ui-box-thumb-rows__boxes',
					'label'=>'Filas', 
					'button_label' => 'Agregar Fila',
					'sub_fields' => $sub_fields_boxes, 
					'collapsed' => 'field_ui-box-thumb-rows__boxes_image',
				)
			);

	$layouts = WPBC_acf_make_flexible_content_layout(array(
		'layout_name' => 'ui-box-thumb-rows',
		'layout_label' => '<i class="dot-badge"></i> Miniaturas/Icono en filas',
		'content_sub_fields' => $content_sub_fields,
	), $layouts);

	return $layouts;
}