<?php

/**
 * @snippet       WooCommerce Checkout date picker
 * @author        NCY Design https://wordpress.ncy.design
 * @compatible    WooCommerce 3.7.0
 */
// Register main datepicker jQuery plugin script
/*

	https://gijgo.com/
	See custom.js

*/
add_filter('WPBC_enqueue_scripts__head_styles', function($styles){
	$styles['gijgo'] = array( 
		'src' => 'addons/gijgo/css/gijgo.min.css'
	);
	return $styles;
},10,1);

add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){  
	$scripts['gijgo'] = array(
		'src'=> CHILD_THEME_URI .'/addons/gijgo/js/gijgo.min.js',
		'dependence' => array('jquery')
	); 
	$scripts['gijgo-es'] = array(
		'src'=> CHILD_THEME_URI .'/addons/gijgo/js/messages/messages.es-es.js',
		'dependence' => array('jquery')
	); 
	return $scripts;
},10,1);

add_action('wp_footer',function(){
	?>
<script>
    +function(t){
        $('#datepicker').each(function(){ 
				  	var me = $(this);

				  	var date = new Date();
  					var minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 2);

				  	me.datepicker({
								locale: 'es-es',
					      uiLibrary: 'bootstrap4',
					      header: true,
					      footer: true,
					      modal: true,
					      format: 'dd-mm-yyyy',
					      minDate: minDate,
					      open: function (e) {
				            //me.closest('.m-form-group').addClass('focused');
				        },
					      change: function (e) {
				           if(me.val() == ""){
									  //me.closest('.m-form-group').removeClass('focused');
									}
				        },
				        close: function (e) {
				           if(me.val() == ""){
										  //me.closest('.m-form-group').removeClass('focused');
										}
				       	},
				       	select: function (e,type) {
				          //me.closest('.m-form-group').addClass('focused');
				       	}
					  }); 
				  });
				  $('#timepicker').each(function(){ 
				  	var me = $(this);
				  	me.timepicker({
								locale: 'es-es',
					      uiLibrary: 'bootstrap4',
					      header: true,
					      footer: true,
					      modal: true, 
					      open: function (e) {
				            //$(this).closest('.m-form-group').addClass('focused');
				        },
					      change: function (e) {
				           if(this.value == ""){
									  //$(this).closest('.m-form-group').removeClass('focused');
									}
				        },
				        close: function (e) {
				           if(this.value == ""){
										  //$(this).closest('.m-form-group').removeClass('focused');
										}
				       	}
					  }); 
				  });
    }(jQuery); 
</script>
	<?php
},99);

// Call datepicker functionality in your custom text field
add_action('woocommerce_after_checkout_billing_form', 'WPBC_datepicker_field', 10, 1);

function WPBC_datepicker_field( $checkout ) {

    date_default_timezone_set('America/Los_Angeles');
    $mydateoptions = array('' => __('Select PickupDate', 'woocommerce' ));

    echo '<div id="woo-delivery-date" class="woo-delivery-date">
    <h3 class="gpt-1">'.__('Fecha de Envío').'*</h3>'; 
    echo '<div class="row">';
    echo '<div class="col-sm-6">';
    woocommerce_form_field( 'delivery_date', array(
        'type'          => 'text',
        'class'         => array('woo-datepicker form-row-wide'),
        'id'            => 'datepicker',
        'required'      => true,
        'label'         => __('Fecha'),
        'placeholder'       => __('Selecciona el día de entrega'),
        //'options'     =>   $mydateoptions
        ),
    $checkout->get_value( 'delivery_date' ));

    $mydateoptions = array(
    	'9-13' => '9 a 13hs',
    	'15-20' => '15 a 20 hs',
    );
    echo '</div>';
    echo '<div class="col-sm-6">';
    woocommerce_form_field( 'delivery_time', array(
        'type'          => 'radio',
        'class'         => array('woo-timepicker form-row-wide'),
        'id'            => 'timepicker',
        'required'      => true,
        'label'         => __('Horario de entrega'), 
        'options'     =>   $mydateoptions
        ),
    $checkout->get_value( 'delivery_time' ));
    echo '</div>';
    echo '</div>';
    echo '<p><i>* Los envíos pueden hacerse como mínimo 48 hs luego de pedido.</i></p>';

    echo '</div>';
}
/**
 * Process the checkout
 **/
add_action('woocommerce_checkout_process', 'WPBC_datepicker_checkout_process');

function WPBC_datepicker_checkout_process() {
    global $woocommerce;

    // Check if set, if its not set add an error.
    if (!$_POST['delivery_date'])
         wc_add_notice( '<strong>Fecha de Envío</strong> es requerido', 'error' );

    if (!$_POST['delivery_time'])
         wc_add_notice( '<strong>Horario de Envío</strong>  es requerido', 'error' );
}
 /**
 * Update the order meta with custom fields values
 * */
 add_action('woocommerce_checkout_update_order_meta', 'WPBC_datepicker_checkout_field_update_order_meta',10,1);

 function WPBC_datepicker_checkout_field_update_order_meta($order_id) {

	if (!empty($_POST['delivery_date'])) {
	    update_post_meta($order_id, 'Fecha de Envío', sanitize_text_field($_POST['delivery_date']));
	}
	if (!empty($_POST['delivery_time'])) {
	    update_post_meta($order_id, 'Horario de Envío', sanitize_text_field($_POST['delivery_time']));
	}
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'WPBC_datepicker_checkout_admin_order_meta', 10, 1 );

function WPBC_datepicker_checkout_admin_order_meta($order){
    echo '<p><strong>Fecha de Envío:</strong> <br/>' . get_post_meta( $order->get_id(), 'Fecha de Envío', true ) . '</p>';
    echo '<p><strong>Horario de Envío:</strong> <br/>' . get_post_meta( $order->get_id(), 'Horario de Envío', true ) . ' hrs</p>'; 

}