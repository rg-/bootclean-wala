<?php
add_filter('wpbc/filter/layout/main-page-header/defaults', function($params){

	if( !empty($params['use_page_title']) ){

		$params['custom_class'] .= ' gpb-2 gpb-md-0';
		$params['custom_attrs'] .= ' data-is-inview="detect"';

		$params['use_page_title']['container_class'] .= ' page-header-title';
		$params['use_page_title']['col_class'] = 'col-md-9 mx-auto gpt-2 gpt-sm-0 text-center';

		$title = $params['use_page_title']['title'];

		$params['use_page_title']['title'] = '<div data-is-inview-once data-is-inview-fx="fadeInUp" data-transition-delay=".3s">[title_claim]'.$title.'[/title_claim]</div>';

		if( !empty($params['use_page_title']['subtitle']) ){
			$subtitle = $params['use_page_title']['subtitle'];
			$params['use_page_title']['subtitle'] = '<div class="gmt-1 gmb-2" data-is-inview-once data-is-inview-fx="fadeInUp" data-transition-delay=".9s">'.$subtitle.'</div>';
		}

	}

	return $params;

},10,1);

add_filter('wpbc/page_header/slick/item/before', function($text){
	$text = '<div class="container text-center">';
	return $text;
},10,1);

add_filter('wpbc/page_header/slick/item/after', function($text){
	$text = '</div>';
	return $text;
},10,1);