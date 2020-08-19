<?php


add_filter('wpbc/page_header/slick/item/before', function($text){
	$text = '<div class="container text-center">';
	return $text;
},10,1);

add_filter('wpbc/page_header/slick/item/after', function($text){
	$text = '</div>';
	return $text;
},10,1);