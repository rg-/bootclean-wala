<?php

/* my-account.php */

add_filter('wpbc/filter/woocommerce/config', function ($wpbc_woocommerce_config){
	
	$class = '';
	if( is_account_page() && is_user_logged_in() ){
		$class = 'col-navigation-12 col-navigation-order-1 col-content-md-10 col-content-order-2';
	}
	if(is_wc_endpoint_url('view-order')){

	}

	$wpbc_woocommerce_config['layout']['myaccount'] = array(
		'class' => $class,
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
		$title_class .= ' text-center mb-0 section-title ';
		if( !is_wc_endpoint_url() ){
			$title_class .= ' lg ';
		}
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

add_action( 'woocommerce_before_account_navigation', function(){
	?>
	<div class="dropdown woocommerce-MyAccount-dropdown-navigation d-md-none gmb-2">
	  <button class="btn btn-block btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <?php
	    $wc_get_account_menu_items = wc_get_account_menu_items();
	    if( is_account_page() && !is_wc_endpoint_url() ){
	    	echo "Entrada";
	    }
	    if( is_wc_endpoint_url('orders') || is_wc_endpoint_url('view-order') ){
	    	echo $wc_get_account_menu_items['orders'];
	    }
	    if( is_wc_endpoint_url('edit-address') ){
	    	echo $wc_get_account_menu_items['edit-address'];
	    }
	    if( is_wc_endpoint_url('edit-account') ){
	    	echo $wc_get_account_menu_items['edit-account'];
	    }
	    ?>
	  </button>
	  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	    <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
					<a class="dropdown-item" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				</li>
			<?php endforeach; ?>
	  </div>
	</div>
	<div class="d-none d-md-block">
	<?php
} );
add_action( 'woocommerce_after_account_navigation', function(){
	?>
	</div>
	<?php
} );	

add_filter( 'woocommerce_account_menu_items', function($items, $endpoints){ 
	$items['dashboard'] = 'Entrada'; 
	return $items; 
},10,2);


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



add_action('woocommerce_before_reset_password_form', function(){
	?>
	<div class="col-lg-5 mx-auto">
	<?php
});

add_action('woocommerce_after_reset_password_form', function(){
	?>
	</div>
	<?php
});

add_action('woocommerce_before_lost_password_form', function(){
	?>
	<div class="col-lg-5 mx-auto">
	<?php
});

add_action('woocommerce_after_lost_password_form', function(){
	?>
	</div>
	<?php
});