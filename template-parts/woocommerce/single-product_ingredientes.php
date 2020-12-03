<?php

	$post_id = $args->get_id();
	$receta_ingredientes = WPBC_get_field('receta_ingredientes', $post_id);
	$receta_ingredientes_extras = WPBC_get_field('receta_ingredientes_extras', $post_id);
	// _print_code($receta_ingredientes);

	if(!empty($receta_ingredientes)){
?>

<div class="gpy-2">

	<h3 class="section-subtitle lg gmb-2">Ingredientes</h3>

	<div class="row">

		<div class="col-md-9 mx-auto mx-sm-0">

			<div class="d-flex flex-wrap justify-content-center justify-content-sm-start gml-md-n-3">

				<?php foreach ($receta_ingredientes as $key => $value) { 

					$ingrediente_id = $value['receta_ingredientes_post_object'];

					$ingrediente_cantidad = $value['receta_ingredientes_cantidad'];
					$ingrediente_name = get_the_title($ingrediente_id); 

					$ingrediente_image = WPBC_get_field('woo_ingrediente_image',$ingrediente_id);

					$img_pre = get_stylesheet_directory_uri().'/images/px-trans.png';

					if($ingrediente_image){
						$attachment_id = $ingrediente_image['id'];
						$img_hi = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."']");
						$img_low = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']");
						$img_mini = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='thumbnail']");
						$img_blured = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='wpbc_blured_image']");
					}else{
						$img_low = get_stylesheet_directory_uri().'/images/px-trans.png';
					}
					?>
					<div class="text-center font-size-15 gpx-2 gpx-md-3 gmb-2">
						<div data-is-inview="detect" class="ui-ingrediente-thumb d-flex align-items-center justify-content-center">
							<?php
							WPBC_build_lazyloader_image($attachment_id, $type='inview', '1by1', 'medium');
							?>
							<!--<img src="<?php echo $img_pre; ?>" data-is-inview-lazysrc="<?php echo $img_low; ?>" alt=" "/>-->
							
						</div>
						<span class="ui-ingrediente-text">
							<span class="text-violeta d-block"><?php echo $ingrediente_cantidad; ?></span>
							<span><?php echo $ingrediente_name; ?></span>
						</span>
					</div>
				<?php } ?>

			</div>

		</div>

		<div class="col-md-3 gpt-3 gpt-md-0">

			<div class="gml-md-n-4 bg-rosa gpy-1 gpx-2 font-size-15" style="border-radius: 4px;">
				
				<p class="mt-1"><b>VAS A NECESITAR</b></p>
				<?php
				if(!empty($receta_ingredientes_extras)){
					?><ul class="gpx-1"><?php
					foreach ($receta_ingredientes_extras as $key => $value) { 
						?>
						<li class="mb-1"><?php echo $value['receta_ingredientes_extra']; ?></li>
						<?php
					}
					?></ul><?php
				}
				?>

			</div>

		</div>

	</div>

</div>

<?php } ?>