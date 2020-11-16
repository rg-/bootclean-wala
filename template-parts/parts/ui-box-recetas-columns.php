<?php

//_print_code($args);

$use_recetas_ajax = false;

$_paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 

$_product_cat = get_query_var('product_cat_id','');  

if(!empty($_product_cat)){
	$_product_cat_id = get_term_by('slug', $_product_cat, 'product_cat');
	$_product_cat_term_id = $_product_cat_id->term_id;
	$_product_cat_term_name = $_product_cat_id->name;
	// _print_code($_product_cat_term_id);
} 

$general_post_object_recetas_cat = WPBC_get_theme_settings('general_post_object_recetas_cat');

$_WP_Query_args = array(
	'post_status' => 'publish',
	'post_type' => 'product',
	'posts_per_page' => 40, 
	'paged' => $_paged, 
);
if(!empty($general_post_object_recetas_cat)){
	$_WP_Query_args['tax_query'] = array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'term_id',
			'terms' => array($general_post_object_recetas_cat),
		)
	);
}
if(!empty($_product_cat)){
	$_WP_Query_args['tax_query'] = array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'term_id',
			'terms' => array($_product_cat_term_id),
		)
	);
}

$loop = new WP_Query( $_WP_Query_args );
$_total = $loop->max_num_pages; 
?>

<div id="recetas-container" class="container gpb-md-6">

	<div id="recetas-nav" class="row gpt-sm-2 gpb-1">
	
		<div class="col-12">
				<?php 
				
				$args = array(
					'taxonomy' => 'product_cat',
					'orderby' => 'name', // count, slug, term_group, term_id, id
					'order' => 'ASC',
					'hide_empty' => true, 
				);
				if(!empty($general_post_object_recetas_cat)){
					$args['child_of'] = number_format($general_post_object_recetas_cat);
				}
				$term_query = new WP_Term_Query( $args ); 

				$term = get_term_by('slug', 'sin-categorizar', 'product_cat');
				$term_id = $term->term_id; 

				if ( ! empty( $term_query->terms ) ) {
					$recetas_id = WPBC_get_theme_settings('general_post_object_recetas'); 

					?>

					<div class="d-flex justify-content-center flex-wrap">

						<?php if($recetas_id){
							$recetas_link = get_permalink($recetas_id);

							$btn_class = 'btn-primary';
							if(empty($_product_cat)){
								$btn_class = 'btn-outline-primary';
							}

							?>

							<?php if($use_recetas_ajax){ ?>
								<button data-btn="fx" data-href-id="all" data-href="<?php echo $recetas_link; ?>" data-ajax-scroll="#recetas-nav" data-ajax-load="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=get_template&name=ajax/get_recetas" data-ajax-target="#ajax-recetas-loader" class="btn mx-2 gmb-1 btn-sm <?php echo $btn_class; ?>">Todas</button>
							<?php } else { ?>
								<a data-btn="fx" href="<?php echo $recetas_link; ?>" class="btn mx-2 gmb-1 btn-sm <?php echo $btn_class; ?>">Todas</a>
							<?php } ?>
						
						<?php } ?>
						<?php
					foreach ($term_query->terms as $category) {
						$term_name = $category->name;
						$term_slug = $category->slug;
						$term_id = $category->term_id; 
						$term_link = get_term_link($category);
						$term_color = get_field('woo_extra_taxonomy__style', $category);

						$receta_url = get_permalink($recetas_id).$term_slug;

						$btn_class = 'btn-'.$term_color;
						if( !empty($_product_cat) && $_product_cat_term_id == $term_id){
							$btn_class = 'btn-outline-'.$term_color;
						}

						if($use_recetas_ajax){
							?>
							<button data-btn="fx" data-href-id="<?php echo $term_slug; ?>" data-href="<?php echo $receta_url; ?>" data-ajax-scroll="#recetas-nav" data-ajax-load="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=get_template&name=ajax/get_recetas&product_cat_id=<?php echo $term_id; ?>" data-ajax-target="#ajax-recetas-loader" class="btn mx-2 gmb-1 btn-sm <?php echo $btn_class; ?>"><?php echo $category->name; ?></button>
							<?php
						}else{
							?>
							<a data-btn="fx" href="<?php echo $receta_url; ?>" class="btn mx-2 gmb-1 btn-sm <?php echo $btn_class; ?>"><?php echo $category->name; ?></a>
							<?php
						}

					}
					?></div><?php
				} 
				?>

		</div>
	</div>

	<?php if($use_recetas_ajax){ ?>
	
	<div id="ajax-recetas-loader" class="row ajax-load-holder">
		
	</div>

	<p class="text-center"><button data-ajax-load="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=get_template&name=ajax/get_recetas" data-ajax-target="#ajax-recetas-loader" class="btn btn-primary gmt-1">Cargar más</button></p>
	
	<?php } else { ?>

	<?php  

		if ( $loop->have_posts() ) {
			?>
			<div class="row"> 
				<?php
				while ( $loop->have_posts() ) : $loop->the_post();  
					
					global $product;
					
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
					?>
					<div class="col-md-6 col-lg-4 gp-1" data-is-inview="detect">
					<?php WPBC_get_template_part('parts/ui-box-card', $value); ?>
					</div>
					<?php
					//wc_get_template_part( 'content', 'product' );
				endwhile;
				?>
				
			</div>
	
			<?php
			$big = 999999999; // need an unlikely integer
			$paginate_links = paginate_links( array(
			    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			    'format' => '?paged=%#%',
			    'current' => max( 1, $_paged ),
			    'total' => $loop->max_num_pages, 
			    'prev_text' => '<i class="fa fa-angle-left"></i>',
					'next_text' => '<i class="fa fa-angle-right"></i>', 
					'end_size'  => 3,
					'mid_size'  => 3,
			) );
			if(!empty($paginate_links)){
				?>
				<div class="row paginate_links gpy-2">
						<div class="col-12">
							<div class="d-flex align-items-center justify-content-center">
								<?php echo $paginate_links; ?>
							</div>
						</div>
				</div>
				<?php
			}
			?>
				
			<?php 

		} else {
			// echo __( 'No products found' );
		}
		wp_reset_postdata();
	?>

<?php } // $use_recetas_ajax else END ?>

</div>