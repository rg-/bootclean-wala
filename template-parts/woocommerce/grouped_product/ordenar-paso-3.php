<?php

	global $product;  
	 
	$post = get_post($product->get_id());  

	$get_children = $product->get_children(); 
	$grouped_products_temp = array();
	if(!empty($get_children)){
		foreach ($get_children as $key => $value) { 

			$grouped_products_temp[] = wc_get_product( $value );
		}
		$grouped_products = $grouped_products_temp;
	} 
 
	?>


	<?php 

	WPBC_get_template_part('woocommerce/menu-product_cat', array(
		'type' => 'vinos',
		'class' => 'd-none visible_vinos'
	));

	WPBC_get_template_part('woocommerce/menu-product_cat', array(
		'type' => 'recetas',
		'class' => 'visible_recetas'
	));

	?>


<div id="grouped_recetas_items" class="row row-grouped_form ui-loader">

		<?php
		$quantites_required      = false;
		$previous_post           = $post; 

		foreach ( $grouped_products as $grouped_product_child ) {
			$post_object        = get_post( $grouped_product_child->get_id() );
			$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
			$post               = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );

			$product_class = esc_attr( implode( ' ', wc_get_product_class( '', $grouped_product_child ) ) );
			$product_class = str_replace('product', 'receta', $product_class); 
			
			$template_type = 'thumb-recetas';
			$grouped_product_price = $grouped_product_child->get_price(); 
			 
			$recetas_include_cats = WPBC_woo_get_included_terms('general_post_object_recetas_cat');
			if(has_term( $recetas_include_cats, 'product_cat', $grouped_product_child->get_id() )) { 
				 $product_class .= ' '.$args['item_class'];
				 $product_class .= ' is_recetas';
			}
			$vinos_include_cats = WPBC_woo_get_included_terms('general_post_object_vinos_cat');
			if(has_term( $vinos_include_cats, 'product_cat', $grouped_product_child->get_id() )) { 
				$product_class .= ' '.$args['full_item_class'];
				 $product_class .= ' is_vinos not_visible';
				 $template_type = 'thumb-vinos';
			}

			WPBC_get_template_part('woocommerce/grouped_product/'.$template_type, array(
				'grouped_product_child' => $grouped_product_child,
				'product_class' => $product_class
			));

				?>

	<!-- woocommerce-grouped-product-list-item END -->
	
	<?php  
			 
		}
		$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $post ); 

		?> 

	</div><!-- .row-grouped_form END -->