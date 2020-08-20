<?php  

add_filter( 'woocommerce_add_to_cart_redirect', 'WPBC_woo_skip_cart_redirect_checkout' ); 
function WPBC_woo_skip_cart_redirect_checkout( $url ) {
    return wc_get_checkout_url();
}


add_action('woocommerce_before_calculate_totals' , 'WPBC_woo_add_shipping_terms_before_totals' , 10, 1);

function WPBC_woo_add_shipping_terms_before_totals($wc_cart){

    if( count($wc_cart->get_cart()) == 0 ){
        return;
    }

    // Here you need to edit the slug_to_edit with your custom slug
    $shipping_terms = get_term_by( 'slug', 'gratis', 'product_shipping_class' );

    // If can't find the terms, return
    if( empty($shipping_terms) ){
        return;
    } 

    foreach( $wc_cart->get_cart() as $item){
        $product = new WC_Product( $item['product_id'] );

        $product_shipping_class = $product->get_shipping_class();

        if( !empty($product_shipping_class) ){
            continue;
        }

        wp_set_post_terms( $product->id, array( $shipping_terms->term_id ), 'product_shipping_class' );
    }

}

/*

	ESTO ESTA OK
	Acá agrego los custom fields como data del cart
	Esa data es la que luego voy a mostrar en el checkout, emails, order, etc.

*/

add_filter( 'woocommerce_add_cart_item_data', 'save_custom_fields_data_to_cart', 20, 2 );
function save_custom_fields_data_to_cart( $cart_item_data, $product_id ) {
    if( ! empty($_REQUEST['add-to-cart']) && $product_id != $_REQUEST['add-to-cart']
    && is_numeric($_REQUEST['add-to-cart']) ){
        $group_prod = wc_get_product($_REQUEST['add-to-cart']);
        if ( ! $group_prod->is_type( 'grouped' ) )
            return $cart_item_data; // Exit
 
        $cart_item_data['grouped_product'] = array(
            'id' => $_REQUEST['add-to-cart'],
            'name' => $group_prod->get_name(),
            'link' => $group_prod->get_permalink(),
            'visible' => $group_prod->is_visible(),
        );

        if( ! empty( $_POST['grouped_personas'] ) ) {
        	$cart_item_data['grouped_product']['grouped_personas'] = $_POST['grouped_personas'];
        }
        if( ! empty( $_POST['grouped_recetas'] ) ) {
        	$cart_item_data['grouped_product']['grouped_recetas'] = $_POST['grouped_recetas'];
        }

        // Below statement make sure every add to cart action as unique line item
        $cart_item_data['grouped_product']['unique_key'] = md5( microtime().rand() );
    }
    return $cart_item_data;
}


add_action('woocommerce_add_order_item_meta','save_custom_fields_data_to_order',1,2);
function save_custom_fields_data_to_order($item_id, $values) {
  global $woocommerce,$wpdb;
  $user_custom_values = $values['grouped_product'];
  if(!empty($user_custom_values)) {
      wc_add_order_item_meta($item_id,'grouped_product',$user_custom_values);  
  }
}

add_action( 'woocommerce_after_cart_contents',  function(){

	global $woocommerce;
	$cart_url = $woocommerce->cart->get_cart_url();  

} );


/*

	Remove items that has grouped_product passed 
	the idea is to re-make them as a grouped ... using woocommerce_before_cart_contents

*/

add_filter( 'woocommerce_cart_item_visible', function($visible, $cart_item, $cart_item_key){
	//_print_code($cart_item['product_id']);
	//_print_code($cart_item['grouped_product']);
	if(!empty($cart_item['grouped_product'])){
		$visible = false;
	}
	return $visible;

},10,3 );

add_filter( 'woocommerce_checkout_cart_item_visible', function($visible, $cart_item, $cart_item_key){
	//_print_code($cart_item['product_id']);
	//_print_code($cart_item['grouped_product']);
	if(!empty($cart_item['grouped_product'])){
		$visible = false;
	}
	return $visible;

},10,3 );  

add_filter( 'woocommerce_order_item_visible', '_hide_woocommerce_order_item',10,2 );  

function _hide_woocommerce_order_item($visible, $cart_item){
	if(!empty($cart_item['grouped_product'])){
		$visible = false;
	}
	return $visible;
}


/*

	Rebuild cart contents to group child products

*/ 
$is_cart = true;
add_action('woocommerce_before_cart_contents', function() use ($is_cart){
	woocommerce_before_cart_contents_custom($is_cart);
});

$is_cart = false;
add_action('woocommerce_review_order_after_cart_contents', function() use ($is_cart){
	woocommerce_before_cart_contents_custom($is_cart);
});

$is_cart = false;
$is_order = false;
add_action('woocommerce_order_details_after_order_table_items', function($order) use ($is_cart, $is_order){
	woocommerce_before_cart_contents_custom($is_cart, $order);
},10,1);
 
function woocommerce_before_cart_contents_custom($is_cart=true,$order=false){
	
	//$cart = WC_CP()->cart;
	//_print_code($cart);
	if($order){ 
		$items = $order->get_items();
		$items_cart_order = $items;
		// _print_code($items);
	}else{
		$items_cart_order = WC()->cart->get_cart();
	}
	$temp = array();
	foreach ( $items_cart_order as $cart_item_key => $cart_item ) {
		// _print_code($cart_item);
		if(!empty($cart_item['grouped_product'])){
			$temp[$cart_item['grouped_product']['id']]['grouped_personas'] = $cart_item['grouped_product']['grouped_personas'];
			$temp[$cart_item['grouped_product']['id']]['grouped_recetas'] = $cart_item['grouped_product']['grouped_recetas'];
			$temp[$cart_item['grouped_product']['id']]['item_key'] = $cart_item['grouped_product']['unique_key'];
			$temp[$cart_item['grouped_product']['id']]['items'][$cart_item_key] = $cart_item;
		}
	}
	
	foreach ( $temp as $key => $value ) { 

		$grouped_product = wc_get_product( $key ); 

		$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
		$redirect_url = get_the_permalink($ordenar_page_id);
		$children_ids = array();

		foreach ( $value['items'] as $cart_item_key => $cart_item ) {
			$children_ids[] = $cart_item['product_id'];
		}

		// TODO conditional if order and if cart, diferent td´s involved
		?>
	<tr class="woocommerce-cart-form__cart-item grouped_product">

		<?php if(!$order) { ?>

			<td class="product-remove">
				<?php if($is_cart){ ?>
				<a href="#" class="remove" aria-label="Borrar el Plan" data-redirect-url="<?php echo $redirect_url; ?>" data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>?action=get_template&name=ajax/remove_cart_item" data-remove-product_ids='<?php echo implode(',', $children_ids); ?>'>×</a>
				<?php } ?>
			</td> 
			<td class="product-thumbnail"></td>

		<?php } ?>

		<td class="product-name" colspan="4">
			<h3 class="ui-box-cart-title mt-3 mb-2">PLAN</h3>
			<p><span class="count_personas"><?php echo $value['grouped_personas']; ?></span> Personas<br> <span  class="count_recetas"><?php echo $value['grouped_recetas']; ?></span> Recetas</p>
		</td>
		<?php if(!$order) { ?>
			<td class="product-price"><?php wc_cart_totals_subtotal_html(); ?></td>
			<td class="product-quantity"></td>
			<td class="product-subtotal"><?php wc_cart_totals_order_total_html(); ?></td>
			<?php } ?>
		</tr>
	</tr>
	<?php } ?>

	<?php 

	if($order){
		$order_items = $value['items'];
		$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) ); 
		remove_filter( 'woocommerce_order_item_visible', '_hide_woocommerce_order_item',10,2 ); 
		foreach ( $order_items as $item_id => $item ) {

				$product = $item->get_product();

				wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				);
			}
			add_filter( 'woocommerce_order_item_visible', '_hide_woocommerce_order_item',10,2 ); 

	}else{  

		foreach ( $value['items'] as $cart_item_key => $cart_item ) { 

			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-remove">
					</td>

					<td class="product-thumbnail">
					<?php
					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

					if ( ! $product_permalink ) {
						echo $thumbnail; // PHPCS: XSS ok.
					} else {
						printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
					}
					?>
					</td>

					<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
					<?php
					if ( ! $product_permalink ) {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
					}

					do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

					// Meta data.
					echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

					// Backorder notification.
					if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
					}
					?>
					</td>

					<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
						?>
					</td>

					<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
					<?php
					if ( $_product->is_sold_individually() ) {
						$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
					} else {
						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							),
							$_product,
							false
						);
					}
					echo $cart_item['quantity'];
					//echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
					?>
					</td>

					<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
						<small><i class="fa fa-arrow-right"></i> subtotal <?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
						?></small>
					</td>
				</tr>
				<?php
			}
		} 

	}

}


add_action( 'woocommerce_after_order_itemmeta', 'WPBC_gropued_product_woocommerce_after_order_itemmeta',10, 3 );
 
function WPBC_gropued_product_woocommerce_after_order_itemmeta( $item_id, $item, $product ){
 
    global $wpdb; 
    //$all_meta_data = wc_get_order_item_meta( $item_id, 'bc_bike_config', true); 

    if(!empty($all_meta_data)) {

      // $all_meta_data = unserialize($all_meta_data);
	
			if(!empty($all_meta_data['twf_user_custom_datas'])) {
				 
			}
    }
}

// or woocommerce_admin_order_data_after_shipping_address
add_action( 'woocommerce_admin_order_data_after_billing_address', function(){ 

}, 10, 1 );


add_action( 'woocommerce_admin_order_items_after_line_items', function($order_id){
	/*

	Aca es donde levanto de nuevo la data custom pasada primero al item cart, y luego al item orden

	*/
	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	if(empty($items)) return;

	$temp = array();

	foreach ( $items as $cart_item_key => $cart_item ) {
		// _print_code($cart_item);
		if(!empty($cart_item['grouped_product'])){
			$temp[$cart_item['grouped_product']['id']]['grouped_personas'] = $cart_item['grouped_product']['grouped_personas'];
			$temp[$cart_item['grouped_product']['id']]['grouped_recetas'] = $cart_item['grouped_product']['grouped_recetas'];
			$temp[$cart_item['grouped_product']['id']]['item_key'] = $cart_item['grouped_product']['unique_key'];
			$temp[$cart_item['grouped_product']['id']]['items'][$cart_item_key] = $cart_item;
		}
	}
	
	//_print_code($temp);
	if(empty($temp)) return;
	foreach ( $temp as $key => $value ) { 
		$grouped_personas = $value['grouped_personas'];
		$grouped_recetas = $value['grouped_recetas'];
	?>

		<div style="padding: 12px 24px 12px; background-color: var(--primary); color:#fff;">
			<h2 style="padding: 0; color:#fff;">PLAN ELEGIDO</h2>
		</div>

		<div style="padding: 12px 24px 12px; display: flex; justify-content: center; align-items: center;">

			<p style="font-size: 16px; padding: 12px; text-align: center; ">

				<label style=""><svg style="vertical-align: -6px;" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="#6639b7" d="M16.5 13c-1.2 0-3.07.34-4.5 1-1.43-.67-3.3-1-4.5-1C5.33 13 1 14.08 1 16.25V19h22v-2.75c0-2.17-4.33-3.25-6.5-3.25zm-4 4.5h-10v-1.25c0-.54 2.56-1.75 5-1.75s5 1.21 5 1.75v1.25zm9 0H14v-1.25c0-.46-.2-.86-.52-1.22.88-.3 1.96-.53 3.02-.53 2.44 0 5 1.21 5 1.75v1.25zM7.5 12c1.93 0 3.5-1.57 3.5-3.5S9.43 5 7.5 5 4 6.57 4 8.5 5.57 12 7.5 12zm0-5.5c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 5.5c1.93 0 3.5-1.57 3.5-3.5S18.43 5 16.5 5 13 6.57 13 8.5s1.57 3.5 3.5 3.5zm0-5.5c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/></svg> Cantidad de Personas x <span style="display:inline-block;"><b style="display: flex; width: 32px; height: 32px; align-items: center; justify-content: center; background-color: var(--success); color:#fff; border-radius: 100%;"><?php echo $grouped_personas; ?></b></span></label>

			</p>

			<p style="font-size: 16px; padding: 12px; text-align: center; ">

				<label style=""><svg style="vertical-align: -6px;" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="#6639b7" d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/></svg> Cantidad de Recetas x <span style="display:inline-block;"><b style="display: flex; width: 32px; height: 32px; align-items: center; justify-content: center; background-color: var(--success); color:#fff; border-radius: 100%;"><?php echo $grouped_recetas; ?></b></span></label>

			</p>

		</div>
		<?php
	}

}, 99, 2 );