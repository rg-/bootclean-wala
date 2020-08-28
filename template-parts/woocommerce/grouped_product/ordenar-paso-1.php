<div id="ordenar-paso-1" class="ordenar-paso">

	<div class="row gpb-md-3">
		<?php
		
		global $product; 

		$grouped_personas = WPBC_get_field('grouped_personas', $product->get_id());
		$grouped_personas_title = WPBC_get_field('grouped_personas_title', $product->get_id());
		$grouped_personas_opciones = WPBC_get_field('grouped_personas_opciones', $product->get_id());
		$grouped_personas_desc = WPBC_get_field('grouped_personas_desc', $product->get_id()); 
		?>
		<div class="col-12 text-center">

			<h2 class="section-title"><?php echo $grouped_personas_title; ?></h2>

			<div data-ordenar-field="#grouped_personas" class="d-flex flex-wrap justify-content-center gpy-md-2">

				<?php
				
				if(!empty($grouped_personas_opciones)){
					$grouped_personas_opciones = explode(',', $grouped_personas_opciones);
					foreach ($grouped_personas_opciones as $value) { 
						$checked = '';
						if($value == $grouped_personas){
							$checked = 'checked';
						}
						?>
						<div class="big-radio gm-1">
							<input <?php echo $checked; ?> value="<?php echo $value; ?>" type="radio" name="grouped_personas_option" id="grouped_personas_option_<?php echo $value; ?>" autocomplete="off">
					    <label for="grouped_personas_option_<?php echo $value; ?>" class="btn btn-big-radio">
					        <?php echo $value; ?>
					    </label>
					  </div>
						<?php
					}

				}
				?>

				<div class="paso-ok"></div>

			</div>

			<p class="font-size-13 text-center"><?php echo $grouped_personas_desc; ?></p>

		</div>
	</div>

</div>