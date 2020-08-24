<?php // $args passed ?>
<div id="ordenar-paso-2" class="ordenar-paso <?php if(!$args['show_paso_2']){echo "disabled";} ?>">

		<div class="row gpb-4">
			<?php
			
			global $product; 

			$grouped_recetas = WPBC_get_field('grouped_recetas', $product->get_id());
			$grouped_recetas_title = WPBC_get_field('grouped_recetas_title', $product->get_id());
			$grouped_recetas_opciones = WPBC_get_field('grouped_recetas_opciones', $product->get_id());
			$grouped_recetas_desc = WPBC_get_field('grouped_recetas_desc', $product->get_id());
			?>
			<div class="col-12 text-center">

				<h2 class="section-title"><?php echo $grouped_recetas_title; ?></h2>

				<div data-ordenar-field="#grouped_recetas" class="d-flex justify-content-center gpy-2">

					<?php
					
					if(!empty($grouped_recetas_opciones)){
						$grouped_recetas_opciones = explode(',', $grouped_recetas_opciones);
						foreach ($grouped_recetas_opciones as $value) { 
							$checked = '';
							if($value == $grouped_recetas){
								$checked = 'checked';
							}
							?>
							<div class="big-radio gm-1">
								<input <?php echo $checked; ?> value="<?php echo $value; ?>" type="radio" name="grouped_recetas_option" id="grouped_recetas_option_<?php echo $value; ?>" autocomplete="off">
						    <label for="grouped_recetas_option_<?php echo $value; ?>" class="btn btn-big-radio">
						        <?php echo $value; ?>
						    </label>
						  </div>
							<?php
						}

					}
					?>

					<div class="paso-ok"></div>

				</div>

			</div>

			<div class="col-md-8 col-lg-5 mx-auto text-center">
				<p class="font-size-13 text-center"><?php echo $grouped_recetas_desc; ?></p>

				<p class="text-center gmt-2">
					<?php
					$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
					?>
					<button id="grouped_recetas_siguiente" <?php if(!$args['show_paso_3']){echo "disabled";} ?> type="submit" class="btn btn-primary btn-action">Siguiente Paso</button>

				</p>

			</div>

		</div>

	</div>