<?php

include('woo_grouped_product/enqueue.php');
include('woo_grouped_product/acf.php');
include('woo_grouped_product/layout.php');
include('woo_grouped_product/filters-actions.php');


add_action('admin_init',function(){

	$ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');
	
	if(!empty( $ordenar_product_id )){

		$_children = get_post_meta( $ordenar_product_id, '_children', true );
		$_WP_Query_args = array(
			'post_status' => 'publish',
			'post_type' => 'product',
			'posts_per_page' => -1,  
			'tax_query' => array(
		        array(
		            'taxonomy' => 'product_type',
		            'field'    => 'slug',
		            'terms'    => 'simple', 
		        ),
		    ),
		);
		$loop = new WP_Query( $_WP_Query_args ); 
		$_children_temp = array(); 
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) {
				$loop->the_post();  
				global $product; 
				$_children_temp[] = $product->get_id();  
			}
		}
		wp_reset_postdata(); 
		$up = update_post_meta($ordenar_product_id, '_children', $_children_temp, $_children);
	}

});