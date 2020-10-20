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
				<div >
					<p class="font-size-15 text-center text-lg-left">Suscríbete y recibí ideas para cocinar</p>
					
					<div class="form-controls-alt">
						<div class="input-group">
							
							<input id="modal_subscribe_email" type="email" name="your-email" value="" size="40" class="form-control" aria-required="true" aria-invalid="true" placeholder="Ingresar email">

								<div class="input-group-append">
							    <button data-toggle="modal" data-modal-email="#modal_subscribe_email" data-target="#modal_subscribe_form" type="button" data-btn="fx" data-fx="right" class="btn btn-secondary btn-icon"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
							<path fill="#ffffff" d="M12,4l-1.41,1.41L16.17,11H4v2h12.17l-5.58,5.59L12,20l8-8L12,4z"></path>
							</svg></button>
							  </div>
							</div>
					</div>

				</div>
			</div>
		</div>

	</div>

</div>