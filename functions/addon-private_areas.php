<?php 

/*
	
	##################################################

	IMPORTANT, all this things can be done directly on admin settings page "PRIVATE AREAS"

	##################################################

	This is de basic description in this scenario settings

	- Entire site is private unless you have a "subscriber" user, logged, role.
	- "administrator" has, of course, access anyway.
	- You can choose on each private page to make it not private anyway.
	- Since we are using woocommerce, and the idea is to sell subscriptions,
	all the woocommerce pages also are not private. So user can purchase a subscription and access private areas/contents.
	- Not private pages also can have (shortcodes), some private parts and some not-private parts.
	- Alerts actived (template-parts available)

	So:

	- visitors will pushed to purchase a subscription to access private areas.
	- users can create an account, they will become "client" role.
	- when they purchase a subscription, they will become "subscriber" user role.
	- while "subscriber" role is actived, user gain access to private areas.
	- when subscription expires, user return to "client" role and lost access to private areas again.

	You can choose where the user will be redirected once logged:

	- if user came from a private page, "private" parameter will tell the plugin to redirect to that "last visitd" url.
	- or, you can filter that and make the user to stay at My Account/Login page
	- or, you can redirect user to home page, shop page, or custom url if needed.
	- By default user will be redirected to the Shop page (see wooocommerce wpbc addon and filter, child customize enabled too.)

*/

/*

	Define the allowed roles to use
	Defaults are "administrator" and "subscriber"

	Ej:

	$default_allowed_roles = array(
		'administrator',
		'subscriber'
	);

*/
// This will run first of all, use it to define initial theme setup values
add_filter( 'WPBC/filter/private_areas/default_allowed_roles', function($allowed_roles){
	return $allowed_roles;
},10,1); 

// This will run last, use it on theme/template conditionals if needed far away the settings used.
// For example here you can do something like if_is_page()... and allow anyway some other user role.
add_filter( 'WPBC/filter/private_areas/allowed_roles', function($allowed_roles){
	return $allowed_roles;
},10,1);  

/*
	Bypass the private zone by.. here you can condition like if is_page('some-page')
*/
add_filter( 'WPBC/filter/private_areas/bypass', function($bypass,$url){ 
	// default $bypass = false;
	return $bypass;
},10,2);


/*
	Redirect users to this page if not allowed and not logged
*/
add_filter( 'WPBC/filter/private_areas/redirect_url', function($redirect_url, $url){
	/*
	default $redirect_url = wp_login_url();
	*/
	// $redirect_url = get_permalink( wc_get_page_id( 'myaccount' ) );
	return $redirect_url;
},10,2);
/*
	Redirect users to this page if not allowed and not logged (defaults is last visited url )
*/
add_filter( 'WPBC/filter/private_areas/redirect_login_url', function($redirect_login_url){
	/*
	default $redirect_login_url = last visited url;
	*/ 
	return $redirect_login_url;
},10,2);
 

/*
	
	Show mesages on front-end depending on user allowed or not ?

*/
	// Should go to core ?
add_filter( 'WPBC/filter/private_areas/show_alerts', function($show_alerts){
	return $show_alerts;
},10,1);  