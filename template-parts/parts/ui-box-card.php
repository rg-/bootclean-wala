<?php

	/*

	$args passed

	like: 

	$args = array(
		'image_id' => 38,
		'price' => 'U$ 390',
		'title' => 'Receta Title lorem ipsum',
		'description' => 'Cras non rhoncus orci, non condimentum dolor. Maecenas accumsan lacinia ipsum dapibus ullamcorper.',
		'time' => '15-20 Min',
		'food-type' => 'Vegetariano' // not used
		'category' => array()
	);

	*/

	$attrs = '';

	$show_porciones = false;
	
	$attachment_id = $args['image_id'];
	$img_hi = "[WPBC_get_attachment_image_src id='".$attachment_id."']";
	$img_low = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']";
	$img_mini = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='thumbnail']";
	$img_blured = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='wpbc_blured_image']";
	if(!empty($args['is_slick'])){
		$attrs .= ' data-lazybackground-src="'.$img_hi.'" ';
		$attrs .= ' style="background-image: url('.$img_blured.');"';
		$box_attrs = '';
	}else{
		$attrs .= ' data-is-inview-lazybackground="'.$img_hi.'" ';
		$attrs .= ' style="background-image: url('.$img_blured.');"';
		$box_attrs = '  ';
	}

	if(!empty($args['category'])){
		$cats = '';
		$cats_classes = '';
		foreach ($args['category'] as $key => $value) {
			$term = get_term( $value, 'product_cat' );
			$term_name = $term->name;
			$term_slug = $term->slug;
			$term_link = get_term_link( $value, 'product_cat');
			$color = get_field('woo_extra_taxonomy__style', $term);
			$cats .= '<small class="ui-badge badge bg-'.$color.'">'.$term_name.'</small>'; 
			$cats_classes .= ' cat-'.$term->slug.'';
		} 
	} 

?>

<a href="<?php echo $args['permalink']; ?>" class="ui-box-card ui-hover-shadow bg-white text-dark <?php echo $cats_classes; ?>" <?php echo $box_attrs; ?>>

	<div class="position-relative ui-box-image">
	
		<div class="ui-overlay-bl">
			<small class="ui-badge badge badge-violeta">
				<?php echo $args['price']; ?>
			</small>
		</div>

		<div class="ui-overlay-br">
			<?php echo $cats; ?> 
		</div>
		
		<div class="ui-box-image-embed">
			<div class="embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item image-cover" <?php echo $attrs; ?>>
				</div>
			</div>
		</div>

	</div>
	<div class="ui-box-content">

		<h3 class="section-subtitle"><?php echo $args['title']; ?></h3>
		
		<?php if(!empty($args['description'])) { ?>
			<p><?php echo $args['description']; ?></p>
		<?php } else { ?>
			<?php WPBC_excerpt(array(
				'post' => $args['post_id'],
				'length' => 15,
				'readmore' => false,
				'excerpt_before'	=> '<p class="entry-excerpt">',
				'excerpt_after'	=> '</p>',
			)); ?>
		<?php } ?>
		
		<p class="m-0 text-violeta d-flex align-items-center font-roboto ui-box-meta">
			<?php if(!empty($args['time'])){ ?>
			<span class="mr-3 meta">[icon_time class="fill-violeta"]&nbsp;<?php echo $args['time']; ?></span>
			<?php } ?>
			<?php if(!empty($args['porciones']) && $show_porciones){ ?>
			<span class="mr-3 meta">[icon_porciones class="fill-violeta"]&nbsp;<?php echo $args['porciones']; ?>Porciones</span>
			<?php } ?>
		</p> 

	</div>

</a>