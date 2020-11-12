<?php

function WPBC_woo__template_redirect(){
    if(is_shop()){
      //wp_redirect(site_url(), '302');
    }
   /* 
   	is_woocommerce() 
		or 
		is_shop() || is_product_category() || is_product_tag() 
	*/ 
	if(  is_shop() || is_product_category() || is_product_tag() ){  
		$recetas_id = WPBC_get_theme_settings('general_post_object_recetas');
		$url = !empty($recetas_id) ? get_the_permalink($recetas_id) : site_url();

		$queried_object = get_queried_object(); 
		if( $queried_object->taxonomy == 'product_cat' ){
			$url = $url.$queried_object->slug; 
		}

		if( WPBC_woo__if_page_product_cat_id() ){
			wp_redirect($url, '302');
		} else {
			wp_redirect(site_url(), '302');
		}
		
  }

  $ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
  $ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');
  if( !empty($ordenar_page_id) && !empty($ordenar_product_id) ){
  	$page_name = 'ordena-ahora';
  	$product_name = 'producto-agrupado';
  	if(is_product($ordenar_product_id)){
  		$url = get_the_permalink($ordenar_page_id);
  		//wp_redirect($url, '302');
  	}
  }
}
add_action('template_redirect', 'WPBC_woo__template_redirect');

function WPBC_woo_get_included_terms($theme_settings){
	$include_cats = array();  
	$recetas_cat = WPBC_get_theme_settings($theme_settings);
	$include_cats[] = $recetas_cat; 
	$recetas_childrens = get_term_children( $recetas_cat, 'product_cat' );  
	foreach ( $recetas_childrens as $child ) {  
		$include_cats[] = $child;
	} 
	return $include_cats; 
}

function WPBC_woo__if_page_product_cat_id(){

	$return = false;

	$queried_object = get_queried_object();  

	$recetas_id = WPBC_get_theme_settings('general_post_object_recetas');

	$include_cats = array();  
	$recetas_cat = WPBC_get_theme_settings('general_post_object_recetas_cat');
	$include_cats[] = $recetas_cat; 
	$recetas_childrens = get_term_children( $recetas_cat, 'product_cat' );  
	foreach ( $recetas_childrens as $child ) {  
		$include_cats[] = $child;
	} 

	if( is_page($recetas_id) ){  

		$product_cat_id = get_query_var('product_cat_id');
		$recetas_term = get_term_by( 'slug', $product_cat_id, 'product_cat' ); 
		$current_term_id = $recetas_term->term_id;   

	} else {

		if(!empty($queried_object->term_id)){
			$current_term_id = $queried_object->term_id; 
		}

	}

	if( !empty($current_term_id) && !empty($include_cats) && in_array( $current_term_id, $include_cats ) ){
		$return = true;
	} 

	return $return; 

}

add_action('wpbc/layout/body/start', function(){ 
	
	if( WPBC_woo__if_page_product_cat_id() ){
		//echo "YES";
	}else{
		//echo "NO";
	} 

}, 0 );

/*

	ENDPOINTS FOR RECETAS/[PRODUCT_CAT_NAME]

	ej:

	/recetas/carne/

	hay un segundo parametro opcional para por ej:

	/recetas/carne/something

	donde something va a ser la query_var "product_cat_test", cambiar obviamente a algo si se usa.

*/ 
add_filter( 'query_vars', function( $query_vars ){
  $query_vars[] = 'product_cat_id'; 
  return $query_vars;
} ); 

add_action( 'init', function (){
  
	$recetas_id = WPBC_get_theme_settings('general_post_object_recetas');
	if(!empty($recetas_id)){
		$page = get_post($recetas_id);
		$pagename = $page->post_name;
	 
	  // ex: recetas/page/1
	  add_rewrite_rule(
	      'recetas/page/([0-9]{1,})?/?',
	      'index.php?pagename='.$pagename.'&paged=$matches[1]',
	      'top'
	  );

	  if( WPBC_woo__if_page_product_cat_id() ){
		  

	  }
	  // ex: recetas/carne/page/1
		  add_rewrite_rule(
		      'recetas/([^/]+)?/page/([0-9]{1,})?/?',
		      'index.php?pagename='.$pagename.'&product_cat_id=$matches[1]&paged=$matches[2]',
		      'top'
		  );

		  // ex: recetas/carne
		  add_rewrite_rule(
		      'recetas/([^/]+)?/?',
		      'index.php?pagename='.$pagename.'&product_cat_id=$matches[1]',
		      'top'
		  );

	  $ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
	  $ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');
	  if( !empty($ordenar_page_id) && !empty($ordenar_product_id) ){
	  	
	  	//$page_name = 'ordena-ahora';
	  	//$product_name = 'producto-agrupado';

	  	$page_post = get_post($ordenar_page_id); 
	  	$product_post = get_post($ordenar_product_id); 
	  	$page_name = $page_post->post_name;
	  	$product_name = $product_post->post_name;
			add_rewrite_rule('^'.$page_name.'/?','index.php?post_type=product&name='.$product_name.'','top');
	  }
	  

  } 

} ); 
 

add_filter('post_type_link', 'WPBC_woo_post_type_link', 1, 3);

function WPBC_woo_post_type_link( $link, $post = 0 ){
	$ordenar_page_id = WPBC_get_theme_settings('general_post_object_ordenar');
	$page_post = get_post($ordenar_page_id); 
	$page_name = $page_post->post_name;
	$ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');
    if ( $post->post_type == 'product' && $post->ID == $ordenar_product_id ){
        return get_the_permalink($ordenar_page_id);
    } else {
        return $link;
    }
}