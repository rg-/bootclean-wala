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

			$product_class .= ' '.$args['item_class'];
			
			$grouped_product_price = $grouped_product_child->get_price(); 
			
				?>

<div class="woocommerce-grouped-product-list-item <?php echo $product_class; ?>" data-product-price="<?php echo $grouped_product_price; ?>" id="product-<?php echo esc_attr( $grouped_product_child->get_id() ); ?>">

<div data-ordenar="receta" class="ui-box-card ordenar" data-is-inview="detect">

<div class="position-relative ui-box-image">

	<div class="ui-overlay-bl">
		<small class="ui-badge badge badge-naranja">
			<?php
			if ( $price_html = $grouped_product_child->get_price_html() ){
				$price = $price_html;
			}else{
				$price = '';
			} 
			echo $price;
			?>
		</small>
	</div>

	<div class="ui-overlay-br">
		<?php
		$category_ids = $grouped_product_child->get_category_ids();
		if(!empty($category_ids)){
			$cats = '';
			$cats_classes = '';
			foreach ($category_ids as $key => $value) {
				$term = get_term( $value, 'product_cat' );
				$term_name = $term->name;
				$term_slug = $term->slug;
				$term_link = get_term_link( $value, 'product_cat');
				$color = get_field('woo_extra_taxonomy__style', $term);
				$cats .= '<small class="ui-badge badge bg-'.$color.'">'.$term_name.'</small>'; 
				$cats_classes .= ' cat-'.$term->slug.'';
			} 
			echo $cats;
		} 
		?> 
	</div>
	
	<div class="ui-box-image-embed">
		<?php
		$image_id = $grouped_product_child->get_image_id();
		$img_hi = do_shortcode("[WPBC_get_attachment_image_src id='".$image_id."']");
		$img_low = do_shortcode("[WPBC_get_attachment_image_src id='".$image_id."' size='medium']");
		$img_mini = do_shortcode("[WPBC_get_attachment_image_src id='".$image_id."' size='thumbnail']");
		$img_blured = do_shortcode("[WPBC_get_attachment_image_src id='".$image_id."' size='wpbc_blured_image']");

		$attrs = ' data-is-inview-lazybackground="'.$img_hi.'" ';
		$attrs .= ' style="background-image: url('.$img_blured.');"';
		?>
		<div class="embed-responsive embed-responsive-16by9">
			<div class="embed-responsive-item image-cover" <?php echo $attrs; ?>>
			</div>
		</div>
	</div>

</div>

<div class="ui-box-content">

	<h3 class="section-subtitle"><?php echo $grouped_product_child->get_name(); ?></h3>

	<div class="ui-box-quantity">
		
		<div class="quantity-buttons" data-name="<?php echo $grouped_product_child->get_name(); ?>" data-id="<?php echo $grouped_product_child->get_id(); ?>" data-price="<?php echo $grouped_product_child->get_price(); ?>" data-price-html='<?php echo $grouped_product_child->get_price_html(); ?>' >
			<button type="button" class="qb btn-minus btn btn-primary btn-circle"><i class="fa fa-minus"></i></button>
			<span class="qb form-control qty form-control-circle" data-value="0">0</span>
			<button type="button" class="qb btn-plus btn btn-primary btn-circle"><i class="fa fa-plus"></i></button>
		</div>

		 <?php
		 if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
				woocommerce_template_loop_add_to_cart();
			} elseif ( $grouped_product_child->is_sold_individually() ) {
				echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" />';
			} else { 
				woocommerce_quantity_input(
					array(
						'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
						'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Missing
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
						'placeholder' => '0',
					)
				);  
			}
		 ?>

				</div>

			</div>

		</div>

	</div>
	
	<?php  
			 
		}
		$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $post ); 

		?> 

	</div><!-- .row-grouped_form END -->