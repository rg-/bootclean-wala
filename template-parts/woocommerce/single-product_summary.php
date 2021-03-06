<?php

// $args passed

$product = $args;

$product_id = $product->get_id(); 

$recetas_id = WPBC_get_theme_settings('general_post_object_recetas');
$get_category_ids = $product->get_category_ids();
if(!empty($get_category_ids)){
	$cats = '';
	$cats_classes = '';
	foreach ($get_category_ids as $key => $value) {
		$term = get_term( $value, 'product_cat' );

		$term_name = $term->name;
		$term_slug = $term->slug;
		$term_link = get_term_link( $value, 'product_cat');
		$color = get_field('woo_extra_taxonomy__style', $term);
		$receta_url = get_permalink($recetas_id).$term_slug;
		if(!empty($term->parent)){
			$cats .= '<a data-btn="fx" href="'.$receta_url.'" class="gmr-1 btn btn-sm btn-'.$color.'">'.$term_name.'</a>'; 
		}
		$cats_classes .= ' cat-'.$term->slug.'';
	} 
}

$out_of_stock = false;
if( ! $product->managing_stock() && ! $product->is_in_stock() ) { 
	$out_of_stock = true; 
} 

if( $product->managing_stock() && $product->get_stock_quantity()==0 ) { 
	$out_of_stock = true; 
} 
?>
<div class="">

	<?php if($out_of_stock){ ?>
		<p class="">
			<small class="ui-badge btn btn-sm btn-outline-rojo" style="pointer-events: none; ">
				PRODUCTO AGOTADO
			</small>
		</p>
	<?php } ?>

	<h2 class="section-title gmb-1"><?php echo $product->get_name(); ?></h2>

	<div class="text-violeta d-flex align-items-center pt-2 gmb-1 font-roboto ui-box-meta flex-wrap">

		<?php
		$receta_tiempo = WPBC_get_field('receta_tiempo', $product_id);
		if(!empty($receta_tiempo)){
			?>
			<span class="meta gmb-1 gmb-md-0"><?php echo do_shortcode('[icon_time class="fill-violeta"]'); ?> <?php echo $receta_tiempo; ?></span> 
			<?php
		}
		?>
		<?php
		$show_porciones = false;
		$receta_porciones = WPBC_get_field('receta_porciones', $product_id);
		if(!empty($receta_porciones) && $show_porciones){
			?>
			<span class="meta gmb-1 gmb-md-0"><?php echo do_shortcode('[icon_porciones class="fill-violeta"]'); ?> <?php echo $receta_porciones; ?> Porciones</span> <span class="gmx-1 gmb-1 gmb-md-0">|</span>
			<?php
		}
		?>
		<?php if(!empty($cats)){ ?>
			<span class="gmx-1 gmb-1 gmb-md-0">|</span><span class="gmb-1 gmb-md-0"><?php echo $cats; ?></span>
		<?php } ?>

	</div>

	<div class="pt-3 gmb-2 font-size-15">
		<?php
			the_content();
		?>
		<p class="text-violeta mt-4" style="font-size: 18px; letter-spacing: 0.32px;"><?php echo $product->get_price_html(); ?></p>
	</div>

	<div class="pt-2 text-center text-md-left">
		<?php
		$ordenar_id = WPBC_get_theme_settings('general_post_object_ordenar');
		$ordenar_permalink = get_permalink($ordenar_id);
		if($ordenar_permalink){
			echo '<a href="'.$ordenar_permalink.'" class="btn btn-primary btn-order-now" data-btn="fx">Ordená Ahora</a>';
		}
		?>
	</div>

</div>