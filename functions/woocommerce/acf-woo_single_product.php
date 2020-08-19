<?php

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
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'product',
					),
					array(
						'param' => 'post_taxonomy',
						'operator' => '==',
						'value' => 'product_type:simple',
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