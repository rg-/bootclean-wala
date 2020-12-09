<?php
$grouped_product_child = $args['grouped_product_child'];
$product_class = $args['product_class'];
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
	
	<div class="ui-box-image-embed">
		<?php
		$image_id = $grouped_product_child->get_image_id();  
		WPBC_build_lazyloader_image($image_id, 'inview');
		?> 
	</div>

</div>

<div class="ui-box-content pt-1 pb-0">
	<div class="pb-1"><?php
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
			echo $cats;
		} 
		?></div>
	<h3 class="section-subtitle"><?php echo $grouped_product_child->get_name(); ?></h3>

	<div class="ui-box-quantity">
		
		<div class="quantity-buttons" data-name="<?php echo $grouped_product_child->get_name(); ?>" data-id="<?php echo $grouped_product_child->get_id(); ?>" data-price="<?php echo $grouped_product_child->get_price(); ?>" data-price-html='<?php echo $grouped_product_child->get_price_html(); ?>' >
			<button type="button" class="qb btn-recetas btn-minus btn btn-primary btn-circle"><i class="fa fa-minus"></i></button>
			<span class="qb form-control qty form-control-circle" data-value="0">0</span>
			<button type="button" class="qb btn-recetas btn-plus btn btn-primary btn-circle"><i class="fa fa-plus"></i></button>
		</div>

		 <?php
		 if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
				woocommerce_template_loop_add_to_cart();
			} elseif ( $grouped_product_child->is_sold_individually() ) {
				echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" />';
			} else { 

				$grouped_personas = WPBC_get_field('grouped_personas', $grouped_product_child->get_id());
				$grouped_recetas = WPBC_get_field('grouped_recetas', $grouped_product_child->get_id());
				if( ! empty( $_POST['grouped_personas_option'] ) ) { 
					$grouped_personas = $_POST['grouped_personas_option'];  
				}
				if( ! empty( $_POST['grouped_recetas_option'] ) ) { 
					$grouped_recetas = $_POST['grouped_recetas_option']; 
				} 

				woocommerce_quantity_input(
					array(
						'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
						'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Missing
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
						'placeholder' => '0' 
					)
				);  
			}
		 ?>

				</div>

			</div>

		</div>

	</div>