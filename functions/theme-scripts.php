<?php 

/*
	Dont include iconmoon styles
*/

add_filter('wpbc/filter/enqueue/iconmoon/uri', function($iconmoon_uri){
	
	return '';

},10,1);

/*

	Add inline head styles

*/

add_filter('WPBC_add_inline_style',function($css){
	/* On old days i use to put this on the project css file, but that will not work till the css is loaded. To prevent similar situations, just put inline styles on the most top of the <head> element, like this one here. */
	$css .= 'body.loading{overflow:hidden!important;}'; 
	$css .= '.no-touchevents ::-webkit-scrollbar { width: 10px; height: 10px; }';
	return $css;
},20,1);

/*

	Add custom js scripts on footer

*/ 

add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){ 

	$scripts['custom'] = array(
		'src'=> CHILD_THEME_URI .'/js/custom.js',
		'dependence' => array('jquery')
	);

	return $scripts;
},10,1);


/*
	
	ADDON smooth-scroll

*/
add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){  
	$scripts['smooth-scroll'] = array(
		'src'=> THEME_URI .'/addons/smooth-scroll/SmoothScroll.min.js',
		'dependence' => array('jquery')
	);  
	return $scripts;
},10,1);