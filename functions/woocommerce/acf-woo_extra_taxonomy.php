<?php
/*

	ACF custom woo fields

*/
add_action('init', function(){

	if( function_exists('acf_add_local_field_group') ){

		$fields = array();

		$fields[] = WPBC_acf_make_radio_field( array(
					'name' => 'woo_extra_taxonomy__style',
					'label'=>  'Color a usar en etiquetas y botones',
					'choices' => WPBC_get_acf_root_colors_choices('woo_extra_taxonomy__style'),
					'default_value' => 'transparent',
					'width' => '35%',
					'class' => 'wpbc-radio-as-btn no-padding-radio-label'
				) );

		acf_add_local_field_group(array(
			'key' => 'group_woo_extra_taxonomy_fields',
			'title' => 'Opciones Extra Categoría',
			'fields' => $fields,
			'location' => array(
				array(
					array(
						'param' => 'taxonomy',
						'operator' => '==',
						'value' => 'product_cat',
					),
				),
			),
			'menu_order' => 0,
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

// CUSTOM TAX COLUMNS

add_filter( "manage_edit-product_cat_columns", 'woo_extra_taxonomy_column_header', 10);
add_action( "manage_product_cat_custom_column", 'woo_extra_taxonomy_column_content', 10, 3);

function woo_extra_taxonomy_column_header($columns) {
	$columns['woo_extra_taxonomy__style'] = 'Color'; 
	return $columns;
}

function woo_extra_taxonomy_column_content($content, $column_name, $term_id){
	if($column_name == 'woo_extra_taxonomy__style'){
		$term = get_term( $term_id, 'product_cat' );
		$color = get_field('woo_extra_taxonomy__style', $term);
		echo '<span class="wpbc-badge" style="width: 20px; height: 10px; background-color:var(--'.$color.')"></span>';
	}
	
}