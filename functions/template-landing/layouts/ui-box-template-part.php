<?php

add_filter('wpbc/filter/group_landing_flexible_content/layouts', 'build_ui_box_template_part',40,1); 
 
function build_ui_box_template_part($layouts){
	$content_sub_fields = array();   

		$content_sub_fields[] = array(
			'key' => 'field_ui-box-template-part__template',
			// 'label' => 'Plantilla HTML', 
			'name' => 'ui-box-template-part__template',
			'type' => 'select',
			'instructions' => __('Files under "template-parts/theme/" folder. (php only)','bootclean'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'template_part_select',
				'id' => '',
			),
			'choices' => array (),
			'default_value' => array (),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',

			'as_template_part_select' => 1 // Custom not ACF part
		); 

	$layouts = WPBC_acf_make_flexible_content_layout(array(
		'layout_name' => 'ui-box-template-part',
		'layout_label' => '<i class="icon-badge"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="#fff" d="M10 18h5v-6h-5v6zm-6 0h5V5H4v13zm12 0h5v-6h-5v6zM10 5v6h11V5H10z"/></svg></i> Plantilla HTML',
		'content_sub_fields' => $content_sub_fields,
		'hide_call_to_action' => true,
		'hide_section_title' => true,
		'hide_options_style' => true,
	), $layouts); 
	return $layouts; 
} 