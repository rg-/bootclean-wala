<?php

// Disable option page for this addon
add_filter('wpbc/filter/custom_login/options_page/enable','__return_false',10,1);

// Enable adddon
add_filter('wpbc/filter/custom_login/enable','__return_true',10,1);

// Set arguments by default
add_filter('wpbc/filter/custom_login/default_args', function($args){

	$args['login_brand'] = array(
		'background-image' => get_stylesheet_directory_uri().'/images/theme/wala-blanco.svg',
		'background-size' => '220px auto',
		'width' => '220px',
		'height' => '78px',
	);
	
	return $args;

},10,1); 


add_action( 'login_head', function(){

	$args = WPBC_get_theme_settings_custom_login_default_args(); 
	// _print_code($args);
	$theme_uri = CHILD_THEME_URI.'/fonts/theme/';
?>

<style>

	@font-face {
	    font-family: 'Roboto Mono';
	    src: url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.eot');
	    src: url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.eot?#iefix') format('embedded-opentype'),
	        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.woff2') format('woff2'),
	        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.woff') format('woff'),
	        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.ttf') format('truetype'),
	        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.svg#RobotoMono-Regular') format('svg');
	    font-weight: normal;
	    font-style: normal;
	    font-display: swap;
	} 
	#login{
		width: 400px;
		max-width: 100%;
	}
	body{
		font-family: 'Roboto Mono'; 
		background-color:#6639b7!important;
		color:#fff;
	}
	.login #login_error, .login .message, .login .success,
	form{
		color:#222222;
	}
	.login #backtoblog a, .login #nav a{
		color:#fff;
	}
	a:active, a:hover {
	    color: #fff!important;
	    text-decoration: underline;
	}
	.wp-core-ui .button, .wp-core-ui .button-secondary{
		color: #6639b7;
    border-color: #6639b7;
	}
	.wp-core-ui .button-primary{
		background-color: #6639b7;
		border-color: #6639b7;
		color: #fff;
		    font-size: 0.938rem;
    line-height: 1.5;
    border-radius: 24px;
    padding: 6px 15px; 
	}
	.wp-core-ui .button.button-large{
		min-height: auto;
		line-height: 1.5;
		padding: 6px 15px; 
	}
	.wp-core-ui .button-primary:hover{
		background-color: #56309a;
    border-color: #502d90;
	}


	input[type=checkbox]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=datetime]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, select:focus, textarea:focus {
	    border-color: #6639b7;
	    box-shadow: 0 0 0 1px #6639b7;
	    outline: 2px solid transparent;
	} 

</style>

<?php

} );