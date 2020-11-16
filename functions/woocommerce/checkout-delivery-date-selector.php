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



// Call datepicker functionality in your custom text field
add_action('woocommerce_after_checkout_billing_form', 'WPBC_datepicker_field', 10, 1);

function WPBC_datepicker_field( $checkout ) {

    date_default_timezone_set('America/Los_Angeles');
    $mydateoptions = array('' => __('Select PickupDate', 'woocommerce' ));

    echo '<div id="woo-delivery-date" class="woo-delivery-date">
    <h3 class="gpt-1">'.__('Fecha de Envío').'*</h3>'; 
    echo '<div class="row">';
    echo '<div class="col-xl-6">';
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
    	'9-11' => '9 a 11hs',
    	'12-14' => '12 a 14 hs',
    	'15-17' => '15 a 17 hs',
    	'18-20' => '18 a 20 hs',
    	'18-21' => '18 a 21 hs',
    );
    echo '</div>';
    echo '<div class="col-xl-6">';
    /**/
    woocommerce_form_field( 'delivery_time', array(
        'type'          => 'select',
        'class'         => array('woo-timepicker form-row-wide'),
        'id'            => 'timepicker',
        'required'      => true,
        'label'         => __('Horario de entrega'), 
        'options'     =>   $mydateoptions
        ),
    $checkout->get_value( 'delivery_time' ));
		
    ?> 
    <?php


    echo '</div>';
    echo '</div>';

    echo '<p class="hide_for_18-21 d-none"><i>* Envios mínimo 72 horas de realizado el pedido. Domingos no entregamos. Feriados no laborables tampoco (1 de enero, 1 de mayo, 18 de julio, 25 de agosto y 25 de diciembre).</i></p>';

    echo '<p class="show_for_18-21 d-none"><i>* Envios Martes de cada semana. Feriados no laborables no entregamos (1 de enero, 1 de mayo, 18 de julio, 25 de agosto y 25 de diciembre).</i></p>';

    echo '</div>'; 


    /*
	Horario de entrega: 4 franjas de horario así asegurar que la gente esté en su casa y lo pueda recibir, las opciones son: 9 am a 11 am; 12 pm a 14 pm; 15 pm a 17 pm; 18 pm a 20 pm. 
    */
    //_print_code(WC()->shipping->get( 'chosen_shipping_methods' ));

}

add_filter( 'woocommerce_form_field', function($field, $key, $args, $value){
	if($key=='delivery_time'){
		$field = str_replace('<input type="radio"', '<span class="delivery_time_radio"><input type="radio"', $field);
		$field = str_replace('label>', 'label></span>', $field);
		$field = $field;
	}
	return $field;

},10, 4 );
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

/*

	Adding data into user orders (font-end)

*/
add_action( 'woocommerce_order_details_after_order_table', function($order){
	?>
	<div class="woocommerce-customer-details gpt-1">
		<h2 class="woocommerce-column__title">Fecha y Horario de Envío</h2>
		<address>
			<div class="row">
				<p class="col-6 m-0"><strong>Fecha:</strong> <?php echo get_post_meta( $order->get_id(), 'Fecha de Envío', true ) ?></p>
				<p class="col-6 m-0"><strong>Horario:</strong> <?php echo get_post_meta( $order->get_id(), 'Horario de Envío', true ) ?>hrs</p>
			</div>
		</address>
	</div>
	<?php 

},10,1 );


 




/*

	Interacting with shipping zones and delivery areas

*/

add_action('woocommerce_review_order_after_shipping',function(){ 

	$shipping_methods = WC()->shipping->get_shipping_methods(); 
	foreach($shipping_methods as $shipping_method){
	    $shipping_method->init(); 
	    foreach($shipping_method->rates as $key=>$val){
	    	//_print_code($val);
	    	$rate_table[$key] = $val;
	    }
	}

	$used_method = $rate_table[WC()->session->get( 'chosen_shipping_methods' )[0]];
 
		if(!empty($used_method)){ 
			$method_id = $used_method->method_id;
			$instance_id = $used_method->instance_id;

			if($method_id == 'szbd-shipping-method'){
				if($instance_id==3){ 
				}
				if($instance_id==4){ 
				}
			}

		} 

});


// Jquery script for checkout page

add_action('wp_footer',function(){
	?>
<script>
    +function(t){ 

        $('#datepickerXX').each(function(){ 
			  	var me = $(this); 
			  	var date = new Date();
					var minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 3); 
			  	me.datepicker({

							locale: 'es-es',
				      uiLibrary: 'bootstrap4',
				      header: true,
				      footer: true,
				      modal: true,
				      format: 'dd-mm-yyyy',
				      minDate: minDate, 

				      // disableDaysOfWeek : [0,1,3,4,5,6],

				      disableDates: function (date) { 
			      		return delivery_disableDates(date);  
             	},
 
				  }); 
			  });

				  $('#timepickerXX').each(function(){ 
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

add_action('wp_footer', 'refresh_checkout_on_shipping_method_change',999 );
function refresh_checkout_on_shipping_method_change() {
    // Only checkout page

	/*
	
	$( document.body ).trigger( 'wc_cart_emptied' );
	$( document.body ).trigger( 'update_checkout' );
	$( document.body ).trigger( 'updated_wc_div' );
	$( document.body ).trigger( 'updated_cart_totals' );
	$( document.body ).trigger( 'country_to_state_changed' );
	$( document.body ).trigger( 'updated_shipping_method' );
	$( document.body ).trigger( 'applied_coupon', [ coupon_code ] );
	$( document.body ).trigger( 'removed_coupon', [ coupon ] );

	*/	

		//$shipping_method_id_montevideo = 3;
		//$shipping_method_id_miramar = 4;

		$shipping_method_id_montevideo = WPBC_get_theme_settings('shipping_method_id_montevideo');
		$shipping_method_id_miramar = WPBC_get_theme_settings('shipping_method_id_miramar');


    if( is_checkout() && ! is_wc_endpoint_url() ):
    ?>
    <script type="text/javascript">
   	
  	function delivery_disableDates(date){
  		$return = true;  
      var day = date.getDate(); // 1-31
      var month = date.getMonth(); // 0-11

      if( day==1 && month==0 || // 1 de enero
      		day==1 && month==4 || // 1 de mayo
      		day==18 && month==5 || // 18 de julio
      		day==25 && month==7 || // 25 de agosto
      		day==25 && month==11 // 25 de diciembre
      	){
      	$return = false;  
      } 

		  return $return;
  	}

    jQuery(function($){
 

    	$(document.body).on('updated_cart_totals',function(){ 
    		//console.log('updated_cart_totals changed');  
    	});
    	$(document.body).on('updated_wc_div',function(){ 
    		//console.log('updated_wc_div changed');  
    	});
    	$(document.body).on('updated_shipping_method',function(){ 
    		//console.log('updated_shipping_method changed');  
    	});

    	$(document.body).on('update_checkout',function(){  
    		update_shipping_and_delivery();  
    	});
    	$(document.body).on('updated_checkout',function(){  
    		update_shipping_and_delivery();  
    	});

    	function update_shipping_and_delivery(){

    		var shipping_method_id = $('#shipping_method input:checked').val(); 

    		var delivery_fields = $('#woo-delivery-date');
    		
    		/*
    		delivery_fields.find('[name="delivery_time"]').prop('checked', false);
    		delivery_fields.find('[name="delivery_time"]').each(function(){ 
    			var label = $(this).next('label');
    			label.addClass('d-none');
    			$(this).addClass('d-none'); 
    		});
				*/

				delivery_fields.val("").change(); 

    		$('#datepicker').datepicker('destroy');

    		// Parque Miramar
    		if( shipping_method_id == 'szbd-shipping-method:<?php echo $shipping_method_id_miramar; ?>'){  

    			// $('#datepicker').datepicker({disableDaysOfWeek: '[0,1,3,4,5,6]'}).datepicker('destroy'); 

    			var date = new Date();
					var minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 3); 
			  	$('#datepicker').datepicker({ 
							locale: 'es-es',
				      uiLibrary: 'bootstrap4',
				      header: true,
				      footer: true,
				      modal: true,
				      format: 'dd-mm-yyyy',
				      minDate: minDate,  
				      disableDaysOfWeek : [0,1,3,4,5,6], 
				      disableDates: function (date) { 
			      		return delivery_disableDates(date);  
             	}, 
				  }); 

    			$('.show_for_18-21').removeClass('d-none'); 
    			$('.hide_for_18-21').addClass('d-none'); 
 
    			delivery_fields.find('option').removeAttr('selected').addClass('d-none'); 
    			delivery_fields.find('option[value="18-21"]').removeClass('d-none').prop('selected', true); 
    			delivery_fields.change();

    			/*
    			delivery_fields.find('[name="delivery_time"][value="18-21"]').next('label').removeClass('d-none');
    			delivery_fields.find('[name="delivery_time"][value="18-21"]').removeClass('d-none');
    			delivery_fields.find('[name="delivery_time"][value="18-21"]').prop('checked', true); 
    			*/
    		}

    		// Montevideo
    		if( !shipping_method_id || shipping_method_id == 'szbd-shipping-method:<?php echo $shipping_method_id_montevideo; ?>'){  

    			var date = new Date();
					var minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 3); 
			  	$('#datepicker').datepicker({ 
							locale: 'es-es',
				      uiLibrary: 'bootstrap4',
				      header: true,
				      footer: true,
				      modal: true,
				      format: 'dd-mm-yyyy',
				      minDate: minDate, 
				      disableDaysOfWeek : [0], 
				      disableDates: function (date) { 
			      		return delivery_disableDates(date);  
             	}, 
				  });

			  	/*
    			delivery_fields.find('[name="delivery_time"]').each(function(){ 
	    			var label = $(this).next('label');
	    			label.removeClass('d-none');
	    			$(this).removeClass('d-none'); 
	    		});
	    		$('.show_for_18-21').addClass('d-none'); 
    			$('.hide_for_18-21').removeClass('d-none'); 
	    		delivery_fields.find('[name="delivery_time"][value="9-11"]').prop('checked', true); 
    			*/	
 
	    		delivery_fields.find('option').removeAttr('selected').removeClass('d-none');  
	    		delivery_fields.find('option[value="18-21"]').addClass('d-none'); 
    			delivery_fields.find('option[value="9-11"]').removeClass('d-none').prop('selected', true); 
    			delivery_fields.change();

    		}
    	}
 
    })
    </script>
    <?php
    endif;
}