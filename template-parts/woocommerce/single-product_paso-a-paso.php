<?php

	$post_id = $args->get_id();
	$receta_pasos = WPBC_get_field('receta_pasos', $post_id);

	// _print_code($receta_pasos);

	if(!empty($receta_pasos)){
?>

<div class="gpt-2 gpb-4">

	<h3 class="section-subtitle lg gmb-2">Paso a Paso</h3>

	<div class="row">

		<?php $count = 1; foreach ($receta_pasos as $key => $value) {
				
			$attachment_id = $value['receta_pasos_image']['id'];

				$img_hi = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."']");
				$img_low = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']");
				$img_mini = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='thumbnail']");
				$img_blured = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='wpbc_blured_image']");

			$title = $value['receta_pasos_content']['title'];
			$description = $value['receta_pasos_content']['description'];
			?>
<div class="col-md-4 gmb-3" data-is-inview="detect">

	<div class="ui-box-paso">

		<div class="embed-responsive embed-responsive-16by9">
			<div class="embed-responsive-item image-cover" data-is-inview-lazybackground="<?php echo $img_hi; ?>" style="background-image: url(<?php echo $img_blured; ?>); ">

			</div>
		</div>

		<h4 class="title font-rubik d-flex align-items-center"><span class="ui-step"><?php echo $count; ?></span> <?php echo $title; ?></h4>

		<div class="content">
			<?php echo $description; ?>
		</div>

	</div>

</div>
			<?php
			$count ++;
		} ?>

	</div>

	<div class="pt-2 text-center">
		<?php
		$ordenar_id = WPBC_get_theme_settings('general_post_object_ordenar');
		$ordenar_permalink = get_permalink($ordenar_id);
		if($ordenar_permalink){
			echo '<a href="'.$ordenar_permalink.'" class="btn btn-primary btn-order-now" data-btn="fx">Ordená Ahora</a>';
		}
		?>
	</div>

</div>

<?php } ?>