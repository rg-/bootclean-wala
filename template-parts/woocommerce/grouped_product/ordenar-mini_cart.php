<?php

	global $product; 

	$grouped_personas = WPBC_get_field('grouped_personas', $product->get_id());
	$grouped_recetas = WPBC_get_field('grouped_recetas', $product->get_id());

	if( ! empty( $_POST['grouped_personas_option'] ) ) { 
		$grouped_personas = $_POST['grouped_personas_option'];  
	}
	if( ! empty( $_POST['grouped_recetas_option'] ) ) { 
		$grouped_recetas = $_POST['grouped_recetas_option']; 
	} 

?>
<div id="grouped_recetas_mini_cart" class="ui-box-ordenar-cart ui-loader">

	<h3 class="ui-box-cart-title hide_on_mobile">SELECCIÓN DE RECETAS</h3>

	<div class="amout hide_on_mobile">
		<span id="grouped_recetas_rest" class="rest">0</span>/<span id="grouped_recetas_max" class="max"><?php echo !empty($grouped_recetas) ? $grouped_recetas : '0'; ?></span>
	</div>

	<?php

		if($grouped_recetas<=1){
			$rest_count_class = 'is_singular'; 
		}else{
			$rest_count_class = 'is_plural';
		} 

	?>
	<p id="grouped_recetas_rest_amout" class="amout-msg font-size-13">

		<span id="grouped_recetas_rest_count" class="count"><?php echo !empty($grouped_recetas) ? $grouped_recetas : '0'; ?></span> 
		
		<span class="rest_count <?php echo $rest_count_class; ?>">
			<span class="singular <?php echo $singular_class; ?>">receta pendiente para elegir</span>
			<span class="plural <?php echo $plural_class; ?>">recetas pendientes para elegir</span>
			<span class="msg"><span class="ui-badge badge badge-success">Has completado <?php echo !empty($grouped_recetas) ? $grouped_recetas : '0'; ?> recetas</span></span>
		</span>
	
	</p>

	<hr class="hide_on_mobile">

	<h3 class="ui-box-cart-title hide_on_mobile">PLAN</h3>

	<p class="hide_on_mobile"><span id="grouped_personas_count" class="count_personas"><?php echo $grouped_personas; ?></span> 
		<?php 
		if($grouped_personas<=1){
			$singular_class = '';
			$plural_class = 'd-none';
		}else{
			$singular_class = 'd-none';
			$plural_class = '';
		}
		?>
		<span class="singular <?php echo $singular_class; ?>">Persona</span>
		<span class="plural <?php echo $plural_class; ?>">Personas</span>
		<br> <span id="grouped_recetas_count" class="count_recetas"><?php echo $grouped_recetas; ?></span> 
		<?php 
		if($grouped_recetas<=1){
			$singular_class = '';
			$plural_class = 'd-none';
		}else{
			$singular_class = 'd-none';
			$plural_class = '';
		}
		?>
		<span class="singular <?php echo $singular_class; ?>">Receta</span>
		<span class="plural <?php echo $plural_class; ?>">Recetas</span>
	</p>

	<hr class="hide-on-affix hide_on_mobile">

	<h3 class="d-none ui-box-cart-title">SELECCIÓN</h3>
	<div id="grouped_recetas_list" class="d-none grouped_recetas_list">

	</div>
	<div id="grouped_recetas_list_out" class="hide-on-affix hide_on_mobile mt-2 gmb-1 grouped_recetas_list_out empty-result">

	</div>

	<div id="grouped_recetas_list_totals" class="d-none">

	</div>

	<div class="ui-box-cart-footer hide_on_mobile gmb-2">
		<div class="d-flex delivery mb-2 hide-on-affix">
			Envío <span class="ml-auto">Gratis</span>
		</div>
		<div class="d-flex total mb-2">
			Total <span class="ml-auto"><span id="total_calculated" class="price" data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>?action=get_template&name=ajax/wc_price"><?php echo wc_price(0); ?></span> <small>IVA INCL.</small></span>
		</div>
	</div>
	<?php
	// echo do_shortcode('[WPBC_woo_mini_cart title="SELECCIÓN DE RECETAS"]');
	?>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

	<?php
	$get_children = $product->get_children(); 
	$grouped_products_temp = array();
	if(!empty($get_children)){
		foreach ($get_children as $key => $value) {
			$grouped_products_temp[] = wc_get_product( $value );
		}
		$grouped_products = $grouped_products_temp;
	}
	$quantites_required      = false;  
	foreach ( $grouped_products as $grouped_product_child ) { 
		$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() ); 
	}

	if ( $quantites_required ) : ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php if( $grouped_personas ) { ?>
			
			<input readonly type="hidden" id="grouped_personas" name="grouped_personas" value="<?php echo $grouped_personas; ?>">
		<?php } ?>
		<?php if( $grouped_recetas ) { ?>
			
			<input readonly type="hidden" id="grouped_recetas" name="grouped_recetas" value="<?php echo $grouped_recetas; ?>">
		<?php } ?>

		<button id="grouped_recetas_add_to_cart" disabled type="submit" class="single_add_to_cart_button btn btn-primary btn-block btn-action">Finalizar Pedido</button>

		<?php
		$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
		?>
		<p class="text-center hide_on_mobile gmt-1 m-0 small"><a href="<?php echo get_the_permalink($ordenar_page_id); ?>">Cambiar Plan <i class="fa fa-angle-right"></i></a></p>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php endif; ?>


</div>