<div id="modal_subscribe_form" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered ui-loader" role="document">
    <div class="modal-content">
      <div class="modal-header flex-column justify-content-center flex-wrap align-items-center gpt-3">
      	
        <h5 class="modal-title section-title gpt-1">Suscripción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        
        <p class="font-size-15 text-center">Suscríbete y recibí ideas para cocinar</p>
				<div class="gpb-2 footer_form text-left">
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
</div>