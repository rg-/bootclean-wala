<?php

/*

	Show hide ACF front end form 

*/

add_filter('wpbc/filter/acf/enable_acf_form',function(){
	return false; // false default
}, 10, 1);

/*

	Show hide WPBC Theme Options back end

*/

add_filter('WPBC_options_show_menu',function(){
	return false; // false default
}, 10, 1);

/*
	Hide WPBC_layout_debug front-end
	(only loged users with admin capabilities)

*/
add_filter('WPBC_layout_debug',function(){
	return false; // true default
}, 10, 1);

/*

	Use a new database record into options for this theme if needed.
	
	Parent default one is "bootclean-options-theme"
	
	Functions to get options/defaults will keep working as well.
	
*/

/* 
add_filter('BC_theme_options_option_name', function(){
	return 'bootclean-child-options-theme'; 
});
*/


/* 
	Do not use Cleaner Login custom branding feature 

add_filter('BC_cleaner__login', function(){
	return false; 
});*/
 