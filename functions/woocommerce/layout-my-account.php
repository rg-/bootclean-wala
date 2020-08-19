<?php

/* my-account.php */

add_filter('wpbc/filter/woocommerce/config', function ($wpbc_woocommerce_config){
	
	$wpbc_woocommerce_config['layout']['myaccount'] = array(
		'class' => 'col-navigation-12 col-navigation-order-1 col-content-md-10 col-content-order-2',
	); 
	
	return $wpbc_woocommerce_config;

},10,1);

add_filter('WPBC_post_header_show', function($show){
	if( is_account_page() ){
		//$show = false;
	}
	return $show; 
},10,1);  

add_filter('WPBC_post_header_title_class', function($title_class){ 
	if( is_account_page() ){
		$title_class .= ' text-center mb-0 section-title lg';
	} 
	return $title_class;  
}, 20, 1 );  

add_filter('wpbc/filter/page/single/class',function($class){
	if( is_account_page() ){
		$class .= ' woo-is_account gpb-5';
	} 
	return $class;
},10,1);


// add_action( 'woocommerce_account_navigation', 'WPBC_woocommerce_account_content', 0 );
function WPBC_woocommerce_account_content(){

	if( is_wc_endpoint_url( 'orders' ) ){
		$text = __('Orders','woocommerce');
	}
	if( is_wc_endpoint_url( 'downloads' ) ){
		$text = __('Downloads','woocommerce');
	}
	if( is_wc_endpoint_url( 'edit-address' ) ){
		$text = __('Addresses','woocommerce');
	}
	if( is_wc_endpoint_url( 'edit-account' ) ){
		$text = __('Account details','woocommerce');
	}

	// woocommerce_breadcrumb();
	?>
	<header class="woocommerce-products-header w-100">
			<h2 class="woocommerce-products-header__title page-title section-title text-center"><?php if(!empty($text)){ ?><?php echo '/'.$text; ?><?php } ?></h2>
	</header>
	<?php
}


add_action( 'woocommerce_login_form_start', function(){
	?>
<p>Accede con tu cuenta</p>
	<?php
} );

add_action( 'woocommerce_register_form_start', function(){
	?>
<p>O crea un cuenta</p>
	<?php
} );