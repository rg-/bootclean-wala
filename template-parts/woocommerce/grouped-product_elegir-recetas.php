<?php


	
	/*

	NO USADO
  */
 


	global $product;  

	$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');

	$grouped_personas = WPBC_get_field('grouped_personas', $product->get_id());
	$grouped_recetas = WPBC_get_field('grouped_recetas', $product->get_id());

	$show_paso_inicio = true;
	$show_paso_2 = false;
	$show_paso_3 = false;

	if( ! empty( $_POST['grouped_personas_option'] ) ) { 
		$grouped_personas = $_POST['grouped_personas_option']; 
		$show_paso_2 = true;
	}
	if( ! empty( $_POST['grouped_recetas_option'] ) ) { 
		$grouped_recetas = $_POST['grouped_recetas_option']; 
	} 

	if( ! empty( $_POST['grouped_personas_option'] ) && ! empty( $_POST['grouped_recetas_option'] ) ) {
		$show_paso_3 = true;
		$show_paso_inicio = false;
	} 
?> 

<div id="ordenar-pasos-inicio" class="ordenar-pasos-inicio <?php if(!$show_paso_inicio) echo 'd-none';?>">

	<?php  
		// Mostrar modal imposible de cerrar si hay carrito items
		if ( !WC()->cart->is_empty() ){ 
			?>
			<button data-backdrop="static" data-keyboard="false" data-modal-open="onload" type="button" class="d-none btn btn-primary" data-toggle="modal" data-target="#modal_cart_not_empty">
			  cart_not_empty
			</button>
			<?php
		}
	?>

	<?php
	// El paso 1 y 2 estan en otro formulario que hace post de las variables de las cantidades de personas y recetas, con esa data se procesa el paso 3 que esta en este mismo php mas abajo, junto con el mini cart al costado.
	?>
	<form class="" action="<?php echo esc_url( get_permalink($ordenar_page_id) ); ?>" method="post" enctype='multipart/form-data'>

		<?php
			// Cantidad Personas
			WPBC_get_template_part('woocommerce/grouped_product/ordenar-paso-1', array()); ?>

		<?php
			// Cantidad Recetas
			WPBC_get_template_part('woocommerce/grouped_product/ordenar-paso-2', array(
				'show_paso_2' => $show_paso_2,
				'show_paso_3' => $show_paso_3,
			)); ?>

	</form>

</div>

<div id="ordenar-paso-3" class="ordenar-paso <?php if($show_paso_inicio) echo 'd-none';?>">

	<div class="row gpb-2">
		<div class="col-12 text-center">
			<h2 class="section-title">ELEGIR RECETAS</h2>
		</div>
	</div>

	<div id="grouped_recetas_form" class="bg-rojo">

		<form class="cart grouped_form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

			<div class="row"> 

				<!-- col order -->
				<div class="col-md-9 order-md-1">
					<?php
					// Elegir Recetas
					WPBC_get_template_part('woocommerce/grouped_product/ordenar-paso-3', array(
						'show_paso_2' => $show_paso_2,
						'show_paso_3' => $show_paso_3,
					)); ?>
				</div>
				<!-- col order END -->

				<!-- Columna mini fake cart  -->
				<div class="col-md-3 order-md-2">
					<?php
					// Elegir Recetas
					WPBC_get_template_part('woocommerce/grouped_product/ordenar-mini_cart', array(
						'show_paso_2' => $show_paso_2,
						'show_paso_3' => $show_paso_3,
					)); ?>
				</div>
				<!-- Columna mini fake cart  END -->

			</div>

		</form>

	</div>

</div><!-- ordenar-paso-3 END -->

<!--

	Modals, right way will be to insert into footer -> modals action hook... but working

-->


<?php WPBC_get_template_part('woocommerce/modals/cart_not_empty'); ?>

<?php WPBC_get_template_part('woocommerce/modals/cart_max', array( 
	'grouped_personas' => $grouped_personas,
	'grouped_recetas' => $grouped_recetas 
)); ?>