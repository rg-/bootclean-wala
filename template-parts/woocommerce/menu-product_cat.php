<?php

$type = $args['type'];
$class = !empty($args['class']) ? $args['class'] : '';
//$general_post_object_recetas_cat = WPBC_get_theme_settings('general_post_object_recetas_cat');
//$general_post_object_vinos_cat = WPBC_get_theme_settings('general_post_object_vinos_cat'); 

$child_of  = WPBC_get_theme_settings('general_post_object_'.$type.'_cat'); 

$vinos_cat_args = array(
	'taxonomy' => 'product_cat',
	'orderby' => 'name', // count, slug, term_group, term_id, id
	'order' => 'ASC',
	'hide_empty' => true, 
);
if(!empty($child_of)){
	$vinos_cat_args['child_of'] = number_format($child_of);
}

$vinos_cat_term_query = new WP_Term_Query( $vinos_cat_args ); 
if ( ! empty( $vinos_cat_term_query->terms ) ) {
		?>
	<div id="<?php echo $type; ?>-nav" class="filter-nav row <?php echo $class; ?>">
		<div class="col-12">
			<div class="d-flex justify-content-center flex-wrap">
				<button type="button" data-active-class="btn-outline-primary" data-default-class="btn-primary" data-filter-nav="#<?php echo $type; ?>-nav" data-filter-target="#grouped_recetas_items" data-filter-item=".is_<?php echo $type; ?>" data-filterby=".is_<?php echo $type; ?>" class="btn mx-2 gmb-1 btn-sm btn-outline-primary">Todos</button>
				<?php
				foreach ($vinos_cat_term_query->terms as $category) {

					$term_name = $category->name;
					$term_slug = $category->slug;
					$term_id = $category->term_id; 
					$term_link = get_term_link($category);

					$btn_class = 'btn-primary';
					$btn_active_class = 'btn-outline-primary';

					$term_color = get_field('woo_extra_taxonomy__style', $category);
					if(!empty($term_color) && $type == 'recetas'){
						$btn_class = 'btn-'.$term_color;
						$btn_active_class = 'btn-outline-'.$term_color;
					}
					?>
					<button type="button" data-active-class="<?php echo $btn_active_class; ?>" data-default-class="<?php echo $btn_class; ?>" data-filter-nav="#<?php echo $type; ?>-nav" data-filter-target="#grouped_recetas_items" data-filter-item=".is_<?php echo $type; ?>" data-filterby=".receta_cat-<?php echo $term_slug; ?>" class="btn mx-2 gmb-1 btn-sm <?php echo $btn_class; ?>"><?php echo $term_name; ?></button>
					<?php
				}
				?>
			</div>
		</div>
	</div><?php
	}
?>