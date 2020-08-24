<?php

	$post_id = $args->get_id();
	$receta_ingredientes = WPBC_get_field('receta_ingredientes', $post_id);

	// _print_code($receta_ingredientes);

	if(!empty($receta_ingredientes)){
?>

<div class="gpy-2">

	<h3 class="section-subtitle lg gmb-2">Ingredientes</h3>

	<div class="row">

		<div class="col-md-8">

			<div class="d-flex flex-wrap">

				<?php foreach ($receta_ingredientes as $key => $value) {
					$ingrediente_id = $value['receta_ingredientes_post_object'];
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
					<div data-is-inview="detect" class="ui-ingrediente-thumb gmx-2 gmy-1 d-flex align-items-center justify-content-center">
						<img src="<?php echo $img_pre; ?>" data-is-inview-lazysrc="<?php echo $img_low; ?>" alt=" "/>
					</div>
				<?php } ?>

			</div>

		</div>

		<div class="col-md-4 gml-lg-n-4">

			<table class="table table-sm table-borderless font-roboto-mono table-ingredientes">
				<tbody>
					<?php foreach ($receta_ingredientes as $key => $value) {
						$ingrediente_cantidad = $value['receta_ingredientes_cantidad'];
						$ingrediente_id = $value['receta_ingredientes_post_object'];
						$ingrediente_name = get_the_title($ingrediente_id); 
						?>
						<tr>
				      <td class="text-violeta text-right font-roboto cantidad"><?php echo $ingrediente_cantidad; ?></td>
				      <td><?php echo $ingrediente_name; ?></td>
				    </tr>
					<?php } ?>
			  </tbody>
			</table>

		</div>

	</div>

</div>

<?php } ?>