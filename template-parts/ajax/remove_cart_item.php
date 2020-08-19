<?php

// empty_cart by items ids, passed as comma separated argument like "?product_id=23,56,208"
if(isset($_GET['items'])){
	
	$items = explode(',', $_GET['items']);

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) { 
		foreach ($items as $key ) {
			if ( $cart_item['product_id'] == $key ) { 
	      WC()->cart->remove_cart_item( $cart_item_key ); 
	    }
		}   
	}

}

// empty_cart all
if (isset( $_GET['empty_cart'] ) ) { 
  WC()->cart->empty_cart();
}

?>