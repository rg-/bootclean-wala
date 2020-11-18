<?php 

_print_code(wc_get_order_statuses());

$args = array(
      'post_type'=>'shop_order',
      'posts_per_page'=> 10,
      'post_status' => 'any', // array_keys( wc_get_order_statuses() )
      'offset' => 0,
      //'post_status'=> self::get_statuses(),
      //'offset'=> (self::get_request_params('offset') * self::get_chunk_size())
  );


$current_query = new WP_Query($args);

// _print_code($orders_query);

if( $current_query->have_posts() ){

  while( $current_query->have_posts() ){

      $current_query->the_post();

      $order = wc_get_order(get_the_ID());

      echo '<div style="padding:20px; margin:20px auto; border-bottom:1px solid black;">';
      
      echo get_the_title() . '<br>';

      echo 'order_ID: '.get_the_ID().'<br>';
      echo 'order_number: '.$order->get_order_number().'<br>';
      echo 'order_status: '.$order->get_status().'<br>';


      $order_date = $order->get_date_created();
      $order_currency = $order->get_currency();
      $price_include_tax = $order->get_prices_include_tax('edit');

      $order_subtotal = woooe_format_price($order->get_subtotal(), $order->get_currency());
      $order_total = woooe_format_price($order->get_total(), $order->get_currency());
      $order_total_tax = woooe_format_price($order->get_total_tax(), $order->get_currency());
      $order_shipping_total = woooe_format_price($order->get_shipping_total(), $order->get_currency());
      $order_shipping_tax = woooe_format_price($order->get_shipping_tax(), $order->get_currency());

      echo 'order_date: '.$order_date.'<br>';
      echo 'order_subtotal: '.$order_subtotal.'<br>';
      echo 'order_total: '.$order_total.'<br>';
      echo 'order_shipping_total: '.$order_shipping_total.'<br>';

      woocommerce_email_grouped_details_custom($order);

  		echo '</div>';

  }
  
  wp_reset_postdata();

}

?>