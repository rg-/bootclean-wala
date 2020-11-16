<?php

/*
	
	See bootclean-wala/woocommerce/emails/

		email-order-details.php
		email-order-items.php

		Small changes used.

*/

// add_action('woocommerce_email_header', 'wpbc_woocommerce_email_header');

function wpbc_woocommerce_email_header() {
?>
<style type="text/css">
/* Put your CSS here */
</style>
<?php
}
 

/*

	Insert custom data on emails before order resume table

*/

function woocommerce_email_grouped_details_custom($order){
	$items = $order->get_items();
	if(!empty($items)){
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

		foreach ( $temp as $key => $value ) {

			?>
<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
	<tbody>
		<tr>
			<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
				<h3 style="color:#6639b7">PLAN</h3>
				<p><span class="count_personas"><?php echo $value['grouped_personas']; ?></span> Personas<br> <span class="count_recetas"><?php echo $value['grouped_recetas']; ?></span> Recetas</p>
			</td>
			<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
				<h3 style="color:#6639b7">Fecha y Horario de Envío</h3>
				<p><strong>Fecha:</strong> <?php echo get_post_meta( $order->get_id(), 'Fecha de Envío', true ) ?> <br><strong>Horario:</strong> <?php echo get_post_meta( $order->get_id(), 'Horario de Envío', true ) ?>hrs</p>
			</td>
		</tr>
	</tbody>
</table>
			<?php 

		}
	}
}