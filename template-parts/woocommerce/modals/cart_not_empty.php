<div id="modal_cart_not_empty" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered ui-loader" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title section-title ">Atención</h5>
      </div>
      <div class="modal-body text-center">
        
        <p>Ya tienes un pedido en proceso.</p>
        
        <?php  
					if ( !WC()->cart->is_empty() ){ 

						$temp = array();
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							// _print_code($cart_item);
							if(!empty($cart_item['grouped_product'])){
								$temp[$cart_item['grouped_product']['id']]['grouped_personas'] = $cart_item['grouped_product']['grouped_personas'];
								$temp[$cart_item['grouped_product']['id']]['grouped_recetas'] = $cart_item['grouped_product']['grouped_recetas'];
								$temp[$cart_item['grouped_product']['id']]['item_key'] = $cart_item['grouped_product']['unique_key'];
								$temp[$cart_item['grouped_product']['id']]['items'][$cart_item_key] = $cart_item;
							}
						}

						//_print_code($temp); 

					}
				?>

				<?php 
				$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
				?>

				<p class="gmt-1">Revisa tu pedido en el Checkout, allí podrás continuar con la compra o cancelarla.</p> 
      
      </div>
      <div class="modal-footer justify-content-center">
        <a data-btn="fx" href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-primary">Ir al Checkout</a>
        <a class="btn btn-primary" data-woo="empty-cart" data-loading-target="#modal_cart_not_empty .ui-loader" href="<?php echo get_the_permalink($ordenar_page_id); ?>"><i class="fa fa-angle-left"></i> Cambiar Plan</a>
      </div>
    </div>
  </div>
</div>