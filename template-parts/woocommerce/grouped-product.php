<?php

global $product;
global $wp_query;
if(empty($product)){
	$product = wc_get_product( $wp_query->queried_object->ID );
}
//_print_code($product);

?>
<?php
	
	/*

	Javascript required under:

		- functions/woocommerce/woo_grouped_product/script.js (enqueued)

	- ver si no pasar eso a un enqueued js independiente como modulo
	- idem con los filtros/actions que ahora estan junto a los ACF fields para el producto agrupado
	- de hecho lo ideal seria juntar todos lo relacionado a el producto agrupado en un solo lugar, ej
		class del main nav, shortcodes, etc.


	TODO
	
		- woo_grouped_product/script.js solo enqueue para esta pagina.

		- terminar carrito, empty cart, productos child, etc. y aplicar luego exactamente lo mismo para el finalizar compra, pero con el estilo del mini cart... cuack? y de hecho lo mismo en la orden.

		- ver como meter otro mensaje en el carrito cuando se redirigue desde los pasos
		- sacar el boton de actualizar carrito y solo dejar el de empty cart
		- ver de meter capaz otro que diga "volver a seleccionar recetas" ??
			aca hay que ver porque en si, hay que hacer un empty cart y volver a la pagina pero ya con el setup de personas y recetas... o no vale la pena.

			- o incluso... y si directamente vamos a finalizar-compra y no hay pagina de carrito?

		- terminar plurales/singluares al cambiar el cart
			 y ver la confi del resto de titulos, subtitulos y textos, recopilar en un array antes de nada por ej.

		- terminar filtros/actions en functions/woocommerce/acf-woo_grouped_product.php
			
			- checkout
			- orders
			- emails

		- Ver que hacer si ya hay algo en el carrito y se vuelve a esta pagina
		- Dejar un empty_cart via ajax como hide con el wc_price
		- Ocultar el "ordená ahora" en donde sea si se esta en esta pagina o en e chekcout
		- Menu al costado con nombre de usuario si esta logueado, y sino Mi Cuenta.
		- centrar copy right en footer alt

	*/


	// https://stackoverflow.com/questions/48722178/add-a-quantity-field-to-ajax-add-to-cart-button-on-woocommerce-shop-page
	// https://stackoverflow.com/questions/62371839/get-product-id-name-and-quantity-on-woocommerce-ajax-added-to-cart-to-display-a

	// https://stackoverflow.com/questions/48907055/display-parent-grouped-product-name-in-woocommerce-orders-details

	// https://wisdmlabs.com/blog/add-custom-data-woocommerce-order/

	// http://thewebfosters.com/adding-custom-data-woocommerce-order-add-cart/

	// https://www.tychesoftwares.com/delete-child-products-woocommerce-grouped-product-cart-page/
 
	
	// empty_cart all if user is redirected from an "empty cart" link/button/action
	
	if (isset( $_POST['empty_cart'] ) ) { 
	  WC()->cart->empty_cart();
	}

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

		<div class="container">
		<?php
			// Cantidad Personas
			WPBC_get_template_part('woocommerce/grouped_product/ordenar-paso-1', array()); ?>

		<?php
			// Cantidad Recetas
			WPBC_get_template_part('woocommerce/grouped_product/ordenar-paso-2', array(
				'show_paso_2' => $show_paso_2,
				'show_paso_3' => $show_paso_3,
			)); ?>
		</div>

	</form>

</div>

<div id="ordenar-paso-3" class="ordenar-paso gpb-6 <?php if($show_paso_inicio) echo 'd-none';?>">

	<div class="container">
		<div class="row gpb-2">
			<div class="col-12 text-center">

				<h2 class="section-title position-relative">

					<span class="visible_recetas">ELEGIR RECETAS</span>

					<span class="visible_vinos d-none">

						<span class="d-inline-block">
							AGREGAR VINO
							<a href="#" id="grouped_recetas_hide_vinos" class="paso-volver btn btn-sm btn-transparent">
									<i class="fa fa-angle-left"></i> <span>Volver</span>
								</a>
						</span>

					</span>

				</h2>

			</div>
		</div>
	</div>

	<?php

		$col_content_class = 'col-lg-8 col-xl-9 order-md-1';
		$col_aside_class = 'col-lg-4 col-xl-3 order-md-2 ml-auto';

	?>

	<div id="grouped_recetas_form" class="position-relative min-h-100vh">

		<form class="cart grouped_form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

			<div class="container position-relative z-index-30">

				<div class="row"> 

					<!-- col order -->
					<div class="<?php echo $col_content_class; ?>">
						<?php
						// Elegir Recetas
						WPBC_get_template_part('woocommerce/grouped_product/ordenar-paso-3', array(
							'show_paso_2' => $show_paso_2,
							'show_paso_3' => $show_paso_3,
							'item_class' => 'col-md-4 col-lg-6 col-xl-4 gmb-2',
							'full_item_class' => 'col-12 gmb-2',
						)); ?>
					</div>
					<!-- col order END --> 

				</div>

			</div>

			<div id="affix-column" class="affix-container-absolute z-index-40" data-toggle="nav-affix" data-affix-position="top" data-affix-breakpoint="xs" data-affix-target="#grouped_recetas_form" data-affix-simulate="false" data-affix-scrollify="true" data-affix-detect="bottom" data-affix-inner-element=".affix-column">

				<div class="container affix-container">
					
					<!-- Columna mini fake cart  -->
					<div class="<?php echo $col_aside_class; ?> affix-column">
						<?php
						// Elegir Recetas
						WPBC_get_template_part('woocommerce/grouped_product/ordenar-mini_cart', array(
							'show_paso_2' => $show_paso_2,
							'show_paso_3' => $show_paso_3,
						)); ?>
					</div>
					<!-- Columna mini fake cart  END -->
				
				</div>
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