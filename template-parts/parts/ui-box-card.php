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

	$general_post_object_recetas_cat = WPBC_get_theme_settings('general_post_object_recetas_cat');

	if(!empty($args['category'])){
		$cats = '';
		$cats_classes = '';
		foreach ($args['category'] as $key => $value) {
			$term = get_term( $value, 'product_cat' );
			$term_name = $term->name;
			$term_slug = $term->slug;
			if($term->term_id != $general_post_object_recetas_cat){
				$term_link = get_term_link( $value, 'product_cat');
				$color = get_field('woo_extra_taxonomy__style', $term);
				$cats .= '<span class="gmr-1 text-'.$color.'">'.$term_name.'</span>'; 
				$cats_classes .= ' cat-'.$term->slug.'';
			}
			
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
		
		<div class="ui-box-image-embed">
			<?php 

			if(!empty($args['is_slick'])){
				$type= 'slick'; 
			}else{
				$type= 'inview'; 
			}
			$attachment_id = $args['image_id']; 
			WPBC_build_lazyloader_image($attachment_id, $type);
			?>
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
				'excerpt_after'	=> '...</p>',
			)); ?>
		<?php } ?>
		
		<p class="m-0 text-violeta d-flex align-items-center font-roboto ui-box-meta">
			<?php if(!empty($cats)){
				$cats = '&nbsp;&nbsp;|&nbsp;&nbsp;'.$cats;
			}?>
			<?php if(!empty($args['time'])){ ?>
			<span class="mr-3 meta">[icon_time class="fill-violeta"]&nbsp;<?php echo $args['time']; ?>
			<?php echo $cats; ?></span>
			<?php } ?>
			<?php if(!empty($args['porciones']) && $show_porciones){ ?>
			<span class="mr-3 meta">[icon_porciones class="fill-violeta"]&nbsp;<?php echo $args['porciones']; ?>Porciones</span>
			<?php } ?>
		</p> 

	</div>

</a>