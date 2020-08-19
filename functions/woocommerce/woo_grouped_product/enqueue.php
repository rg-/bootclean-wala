<?php

add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){ 

	$scripts['woo_grouped_product'] = array(
		'src'=> CHILD_THEME_URI .'/functions/woocommerce/woo_grouped_product/script.js',
		'dependence' => array('jquery')
	);

	return $scripts;
},10,1);