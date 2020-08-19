<?php

$args = array(
	'post_type' => 'product',
	'posts_per_page' => isset($_GET['posts_per_page']) ? $_GET['posts_per_page'] : 6, 
);

$_product_cat = isset($_GET['product_cat_id']) ? $_GET['product_cat_id'] : false; 

if(!empty($_product_cat)){ 
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'term_id',
			'terms' => array($_product_cat),
		)
	);
}  

$loop = new WP_Query( $args );
if ( $loop->have_posts() ) {

	$count = 0;

	while ( $loop->have_posts() ){

		$loop->the_post(); 

		global $product;
		
		if ( $price_html = $product->get_price_html() ){
			$price = $price_html;
		}else{
			$price = '';
		}
		if ( empty( $product ) || ! $product->is_visible() ) {
			return;
		} 

		$value = array(
			'image_id' => $product->image_id,
			'price' => $price,
			'title' => $product->name,
			'description' => $product->short_description,
			'time' => '15-20 Min',
			'food-type' => '3',
			'category' => $product->category_ids,
			'from_ajax' => true,
		); 

		$delay = .3 * ($count+1) . 's';
		?>
		<div class="col-md-6 col-lg-4 gp-1" data-is-inview="detect">
			<div data-is-inview-once="true" data-is-inview-fx="fadeInUp" data-transition-delay="<?php echo $delay; ?>">
				<?php WPBC_get_template_part('parts/ui-box-card', $value); ?>
			</div>
		</div>
		<?php
		$count++;
	}
}else{

}
wp_reset_postdata();
?>