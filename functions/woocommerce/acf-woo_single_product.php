<?php

function WPBC_group_woo_single_product_locations(){
	
	$location_temp = array();

	$recetas_cat = WPBC_get_theme_settings('general_post_object_recetas_cat');
	
	if(!empty($recetas_cat)){
 
		$recetas_term = get_term_by( 'id', $recetas_cat, 'product_cat' );  
		$location_temp[] = array(
			array(
				'param' => 'post_taxonomy',
				'operator' => '==',
				'value' => 'product_cat:'.$recetas_term->slug,
			)
		);

		$recetas_childrens = get_term_children( $recetas_cat, 'product_cat' ); 
		if(!empty($recetas_childrens)){
			foreach ( $recetas_childrens as $child ) {
			    $term = get_term_by( 'id', $child, 'product_cat' );  
			    $location_temp[] = array(
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'product_cat:'.$term->slug,
						)
					);
			}
		}

	}

	return $location_temp;
	
}


add_action('init',function(){

	$fields = array(); 

		$fields[] = WPBC_acf_make_text_field(array(
			'label' => do_shortcode('[icon_money color="#6639b7"]').' Precio',
			'name' => '_regular_price',
			'width' => '20%',
		)); 

		$fields[] = WPBC_acf_make_text_field(array(
			'label' => do_shortcode('[icon_time color="#6639b7"]').' Tiempo de preparación',
			'name' => 'receta_tiempo',
			'width' => '30%',
		)); 

		$fields[] = WPBC_acf_make_number_field(array(
			'label' => do_shortcode('[icon_porciones color="#6639b7"]').'Porciones',
			'name' => 'receta_porciones',
			'width' => '30%', 
		)); 

		$receta_ingredientes = array();

			$receta_ingredientes[] = WPBC_acf_make_post_object_field(array(
				'label' => 'Tipo',
				'name' => 'receta_ingredientes_post_object',
				'post_type' => array( 'ingrediente' ),
				'width' => '60%',
				'multiple' => 0, 
				'ui' => 1,
			));
			$receta_ingredientes[] = WPBC_acf_make_text_field(array(
				'label' => 'Cantidad',
				'name' => 'receta_ingredientes_cantidad',
				'width' => '30%',
			));  

		$fields[] = WPBC_acf_make_repeater_field(array(
			'label' =>  do_shortcode('[icon_heladera color="#6639b7"]').' Ingredientes',
			'name' => 'receta_ingredientes',
			'width' => '100%',
			'sub_fields' => $receta_ingredientes,
			'button_label' => 'Agregar Ingrediente',
		)); 

		$receta_ingredientes_extra = array();

			$receta_ingredientes_extra[] = WPBC_acf_make_text_field(array(
				'label' => 'Ingrediente',
				'name' => 'receta_ingredientes_extra',
				'width' => '100%',
			));  

		$fields[] = WPBC_acf_make_repeater_field(array(
			'label' =>  do_shortcode('[icon_porciones color="#6639b7"]').' Vas a necesitar...',
			'name' => 'receta_ingredientes_extras',
			'width' => '100%',
			'sub_fields' => $receta_ingredientes_extra,
			'button_label' => 'Agregar Item',
		)); 

		$receta_pasos = array();
			$receta_pasos[] = WPBC_acf_make_image_field(array(
				'label' => 'Imagen',
				'name' => 'receta_pasos_image',
				'width' => '30%',
			));
			
				$receta_pasos_content = array();
				$receta_pasos_content[] = WPBC_acf_make_text_field(array(
					'label' => 'Título',
					'name' => 'title', 
				));
				$receta_pasos_content[] = WPBC_acf_make_textarea_field(array(
					'label' => 'Descripción',
					'name' => 'description', 
				));

				$receta_pasos[] = WPBC_acf_make_group_field(array(
					'label' => '',
					'name' => 'receta_pasos_content',
					'width' => '70%',
					'sub_fields' => $receta_pasos_content,
				));
			

		$fields[] = WPBC_acf_make_repeater_field(array(
			'label' =>  do_shortcode('[icon_pasos color="#6639b7"]').' Pasos',
			'name' => 'receta_pasos',
			'width' => '100%',
			'sub_fields' => $receta_pasos,
			'button_label' => 'Agregar Paso',
		)); 

	if( function_exists('acf_add_local_field_group') ){ 

		acf_add_local_field_group(array(
			'key' => 'group_woo_single_product',
			'title' => 'Opciones Extras Receta',
			'fields' => $fields,
			'location' => WPBC_group_woo_single_product_locations(),
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

add_action('admin_head',function(){
?>
<style>
	#acf-group_landing_flexible_content{ 
	}
	#acf-group_woo_single_product > .handlediv .toggle-indicator{
		color:#fff;
	}
	#acf-group_woo_single_product > .ui-sortable-handle{
		background-color: #6639b7;
		color:#fff;
	}

</style>
<?php
}); 