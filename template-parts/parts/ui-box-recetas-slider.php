
<?php

$slick = array( 

	'dots' => true,
	'arrows' => true, 
	'infinite' => false,
	'speed' => 300,
	'autoplay' => false,
	'autoplaySpeed' => 6200, 
	'slidesToShow' => 3,
	'slidesToScroll' => 1,
	
	'equalHeightSlides' => true, // custom

	'responsive' => array(
	
		array(
			'breakpoint' => 932,
			'settings' => array(
				'slidesToShow' => 2,
				'slidesToScroll' => 1,
			)
		),

		array(
			'breakpoint' => 768,
			'settings' => array(
				'slidesToShow' => 1,
				'slidesToScroll' => 1,
			)
		),

	)

);
$slick = json_encode($slick);  
?>

<div class="container-fluid gpt-1 gpt-md-2 px-0">
	<div data-is-inview="detect">
		<div data-is-inview-once data-is-inview-fx="translateTop">
			<div class="theme-slick-slider slick-dots-relative slick-dots-primary slick-focus-active-items slick-adjust-width slick-adjust-width-arrows row row-no-gutters" data-slick='<?php echo $slick; ?>'>

				<?php 
					$args = array(
						'post_status' => 'publish',
						'post_type' => 'product',
						'posts_per_page' => 12, 
					);
					$general_post_object_recetas_cat = WPBC_get_theme_settings('general_post_object_recetas_cat');

					if(!empty($general_post_object_recetas_cat)){
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'product_cat',
								'field' => 'term_id',
								'terms' => array($general_post_object_recetas_cat),
							)
						);
					}

					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ) {
						?>
							<?php
							while ( $loop->have_posts() ) : $loop->the_post();  
								global $product;
								// _print_code($product);
								if ( $price_html = $product->get_price_html() ){
									$price = $price_html;
								}else{
									$price = '';
								}
								if ( empty( $product ) || ! $product->is_visible() ) {
									return;
								}

								$receta_tiempo = WPBC_get_field('receta_tiempo', $product->get_id());
								$receta_porciones = WPBC_get_field('receta_porciones', $product->get_id());

								$out_of_stock = false;
								if( ! $product->managing_stock() && ! $product->is_in_stock() ) { 
									$out_of_stock = true; 
								} 

								if( $product->managing_stock() && $product->get_stock_quantity()==0 ) { 
									$out_of_stock = true; 
								} 

								$value = array(
									'post_id' => $product->get_id(),
									'permalink' => get_permalink( $product->get_id() ),
									'image_id' => $product->get_image_id(),
									'price' => $price,
									'title' => $product->get_name(),
									'description' => $product->get_short_description(),
									'time' => $receta_tiempo, 
									'porciones' => $receta_porciones,
									'category' => $product->get_category_ids(),
									'out_of_stock' => $out_of_stock,
								); 
								$value['is_slick'] = 1;
								?>
								<div class="item col-md-6 col-lg-4 gp-1">
								<?php WPBC_get_template_part('parts/ui-box-card', $value); ?>
								</div>
								<?php
								//wc_get_template_part( 'content', 'product' );
							endwhile;
							?>
						<?php
					} else {
						// echo __( 'No products found' );
					}
					wp_reset_postdata();
				?>

			</div>
		</div>
	</div>
</div>