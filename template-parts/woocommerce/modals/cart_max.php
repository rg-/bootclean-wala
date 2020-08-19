<?php

  // $args passed

?>
<div id="modal_cart_max" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title section-title ">Atención</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        
        <p>Este Plan no admite seleccionar más recetas.</p>
        
        <div class="ui-box-card py-2 gmb-2" style="max-width: 220px;">
	        <h3 class="ui-box-cart-title pt-2">TU PLAN</h3>
					<p><span id="grouped_personas_count_modal" class="count_personas"><?php echo $args['grouped_personas']; ?></span> Personas<br> <span id="grouped_recetas_count_modal" class="count_recetas"><?php echo $args['grouped_recetas']; ?></span> Recetas</p>
				</div>

        <p class="gmb-2 small">Si lo deseas puedes volver a empezar y elegir otro Plan o continuar y elegir otra/s Recetas.</p>

				<?php $ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar'); ?>
      
      </div>

      <div class="modal-footer justify-content-center">
        <a data-btn="fx" href="<?php echo esc_url( get_permalink($ordenar_page_id) ); ?>" class="btn btn-outline-primary">Empezar de nuevo</a> <button data-btn="fx" type="button" class="btn btn-primary" data-dismiss="modal">Continuar</button>
      </div>
    </div>
  </div>
</div>