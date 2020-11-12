<?php
$grouped_product_child = $args['grouped_product_child'];
$product_class = $args['product_class'];
?>

<div class="woocommerce-grouped-product-list-item <?php echo $product_class; ?>" data-product-price="<?php echo $grouped_product_price; ?>" id="product-<?php echo esc_attr( $grouped_product_child->get_id() ); ?>">

<div data-ordenar="receta" class="ui-box-card ordenar" data-is-inview="detect">

<div class="w d-flex">

	<div class="position-relative ui-box-image"> 
		
		<div class="ui-box-image-embed">
			<?php
			$image_id = $grouped_product_child->get_image_id();  
			$img_mini = do_shortcode("[WPBC_get_attachment_image_src id='".$image_id."' size='thumbnail']");
			$img_blured = do_shortcode("[WPBC_get_attachment_image_src id='".$image_id."' size='wpbc_blured_image']"); 
			?>
			<img class="embed-rounded" src="<?php echo $img_blured; ?>" width="62" data-is-inview-lazysrc="<?php echo $img_mini; ?>"/> 
		</div>

	</div>

<div class="ui-box-content">

	<div class="c">

		<?php

		$cats = '';
		$general_post_object_recetas_cat = WPBC_get_theme_settings('general_post_object_recetas_cat');
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

				if($general_post_object_recetas_cat == $term->term_id){
					$term_name = '&nbsp;';
				}

				$cats .= '<small class="mr-2 text-'.$color.'">'.$term_name.'</small>'; 
				$cats_classes .= ' cat-'.$term->slug.'';
			} 
			
		} 
		?>
	<h3 class="section-subtitle"><?php echo $grouped_product_child->get_name(); ?> <i class="text-primary"><?php echo $cats; ?></i></h3>

	<?php
			if ( $price_html = $grouped_product_child->get_price_html() ){
				$price = '<p class="section-price"><b>'.$price_html.'</b></p>';
			}else{
				$price = '';
			} 
			echo $price;
			?>
		</div> 

	</div>

	</div>

	<div class="ui-box-quantity">
		
		<div class="quantity-buttons" data-name="<?php echo $grouped_product_child->get_name(); ?>" data-id="<?php echo $grouped_product_child->get_id(); ?>" data-price="<?php echo $grouped_product_child->get_price(); ?>" data-price-html='<?php echo $grouped_product_child->get_price_html(); ?>' >
			<button type="button" class="qb btn-vinos btn-minus btn btn-primary btn-circle"><i class="fa fa-minus"></i></button>
			<span class="qb form-control qty form-control-circle" data-value="0">0</span>
			<button type="button" class="qb btn-vinos btn-plus btn btn-primary btn-circle"><i class="fa fa-plus"></i></button>
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