<div id="contacto" class="bg-violeta text-white">

	<div class="container py-4">

		<div class="row gpx-md-6 gpy-lg-2">
			<div class="col-lg-6 gpt-2 gpb-1 gpy-lg-2 gpx-2 gpx-xl-6 text-center border-right order-2 order-md-1">
				<div class="gpx-3">
					<p class="font-size-15">Seguínos</p>

					<div class="d-flex justify-content-center">
						<?php

							$social = WPBC_get_theme_settings("general_social"); 
							if(!empty($social)){
								foreach ($social as $key => $value) {
									$type = $value['social_items_type'];
									$href = $value['social_items_url'];
									?>
									<a data-btn="fx" class="my-2 mx-3 btn btn-icon btn-icon-lg btn-square" href="<?php echo $href; ?>">
										<?php echo do_shortcode('[social_'.$type.' color="#fff"]'); ?>
									</a>
									<?php
								}
							}

						?>
					</div>

				</div>
			</div>
			<div class="col-lg-6 gpt-2 gpb-1 gpy-lg-2 gpx-2 gpx-xl-6 order-1 order-md-2">
				<p class="font-size-15 text-center text-lg-left">Suscríbete y recibí ideas para cocinar</p>
				<?php
				$form = WPBC_get_theme_settings('footer_form');
				if(!empty($form)){
					echo do_shortcode('[contact-form-7 id="'.$form.'"]');
				}
				?>
			</div>
		</div>

	</div>

</div>