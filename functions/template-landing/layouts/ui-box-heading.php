<?php

add_filter('wpbc/filter/group_landing_flexible_content/layouts', 'build_ui_box_heading',30,1); 

add_filter('WPBC_acf_builder_layouts', 'build_ui_box_heading',10,1);

function build_ui_box_heading($layouts){
	$content_sub_fields = array(); 

	$layouts = WPBC_acf_make_flexible_content_layout(array(
		'layout_name' => 'ui-box-heading',
		'layout_label' => '<i class="dot-badge"></i> Encabezado',
		'content_sub_fields' => $content_sub_fields,
	), $layouts); 
	return $layouts; 
} 