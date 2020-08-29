<?php

  // $args passed

?>
<div id="modal_cart_max" class="modal fade" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-dialog-centered ui-loader" role="document">
    <div class="modal-content">
      <div class="modal-header flex-column justify-content-center flex-wrap align-items-center gpt-3">
        <?php echo do_shortcode('[icon_big_alert]');?>
        <h5 class="modal-title section-title gpt-2">Atención</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        
        <p>Este Plan no admite seleccionar más recetas.</p> 

        <?php 
        $ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
        ?>

        <p class="gmt-1">Si lo deseas puedes Cambiar el Plan o Continuar con tu selección.</p> 
      
      </div>
      <div class="modal-footer flex-column justify-content-center flex-wrap align-items-center gmt-1">
        <button data-btn="fx" type="button" class="btn btn-primary btn-action gpx-2" data-dismiss="modal">Continuar</button>
        <a class="gmt-1" data-woo="empty-cart" data-loading-target="#modal_cart_not_empty .ui-loader" href="<?php echo get_the_permalink($ordenar_page_id); ?>"><i class="fa fa-angle-left"></i> Cambiar Plan</a>
      </div>
    </div>
  </div>

</div>