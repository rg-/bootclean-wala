<?php

add_filter('wpbc/filter/flexible-layout-row/style_color', function($style_color, $options){

	if( !empty( $options['style'] ) ) {
			if( !in_array( $options['style'], array( 'transparent', 'white', 'rosa', 'rosa-claro' ) )){
				$style_color = 'white';
			}
		} 
	
	return $style_color;

},10,2);


add_filter('wpbc/body/data', 'custom_body_data',10,1 ); 

function custom_body_data($out){
	global $post;
	$out .= ' data-loader-delay="600" data-is-inview-offset="0" data-scroll-time-1X="1000" '; 
	return $out;
}

add_filter('wpbc/filter/layout/go-up', function($goup){

	return '<a href="#" data-btn="fx" data-fx="up" class="gmb-1 gmr-1 d-none d-md-block btn btn-light btn-circle"><i class="fa fa-angle-up"></i></a>';

},10,1);

/* 
	This will run if no Theme Settings or custom used. 
	Use it if no Theme Settings used, and to set defaults
*/
add_filter('wpbc/filter/layout/locations', function($locations){ 
	$locations['404']['id'] = 'a1';
	return $locations;  
}, 20, 1 );


/* 
	This will run at the last, last, last 
*/
add_filter('wpbc/filter/layout/location', function($layout, $template, $using_theme_settings, $using_page_settings){
	if($template == 'page'){
		//$layout = 'a2-ml';
	}
	return $layout;
},10,4);
/* 
	And same thing for the container type
*/
add_filter('wpbc/filter/layout/container_type', function($container_type, $template, $using_theme_settings, $using_page_settings){
	if($template == 'page'){
		//$container_type = 'fixed-left';
	}
	return $container_type;
},10,4);


add_action('wpbc/layout/start', function(){?><?php
}, 40 );

add_filter('wpbc/filter/layout/start/defaults', function($args){  
	// $args['main_content']['wrap']['class'] = 'gpy-1';
	return $args;
}); 

add_filter('WPBC_post_header_title_class', function($title_class){ 
	/*
	default
	$title_class = 'entry-title';
	*/
	$title_class .= '';
	return $title_class;  
}, 20, 1 );  




/*

	For Flexible Layouts

*/

add_filter('wpbc/filter/make_flexible_content_layout/pre/args', function($args,$layout_name){

	$args['hide_attributes_classes'] = true;

	return $args;
},10,2);

add_filter('wpbc/filter/flexible-layout-row/args', function($return, $args){
	// _print_code($return);
	if($args['acf_fc_layout'] == 'accordion_row'){
		$return['section_options']['container_class'] = 'gpt-md-2 gpb-2 gpb-md-6';
		$return['section_options']['row_class'] = 'gpb-4';
		$return['section_options']['column_class'] = 'col-lg-10 mx-auto';
	}

	if($args['acf_fc_layout'] == 'wysiwyg_row'){
		$return['section_options']['container_class'] = 'gpt-md-2 gpb-2 gpb-md-6';
		$return['section_options']['row_class'] = '';
		$return['section_options']['column_class'] = 'col-md-9 mx-auto';
	}

	return $return;
},10,2);


add_filter('wpbc/slick/slick_class', function($slick_class, $params){

	//$slick_class .= ' slick-lazyload-blured';

	return $slick_class;
},10,2);
 
function WPBC_build_lazyloader_image($attachment_id=null, $type=null, $embed='16by9', $size='full'){
	if(!empty($attachment_id) && !empty($type)){

		$img_hi = wp_get_attachment_image_src( $attachment_id, $size, false );
		$img_low = wp_get_attachment_image_src( $attachment_id, 'medium', false ); 
		$img_mini = wp_get_attachment_image_src( $attachment_id, 'thumbnail', false ); 
		$img_blured = wp_get_attachment_image_src( $attachment_id, 'wpbc_blured_image', false ); 

		if($type=='slick'){

			$attrs = ' data-lazybackground-spinner="false" data-lazybackground-target="parent" data-lazybackground="simple" data-lazybackground-src="'.$img_hi[0].'" ';
			$attrs .= ' style="background-image: none;"';
			$box_attrs = '';

		}

		if($type=='inview'){

			$attrs .= ' data-lazybackground-spinner="false" data-lazybackground-target="parent" data-lazybackground="simple" data-is-inview-lazybackground="'.$img_hi[0].'" ';
			$attrs .= ' style="background-image: none;"';
			$box_attrs = '  ';

		}
		?>
<div class="embed-responsive embed-responsive-<?php echo $embed; ?>">
	<div class="embed-responsive-item image-cover lazyload-blured" style="background-image: url(<?php echo $img_blured[0]; ?>);">
		<div class="w-100 h-100 image-cover " <?php echo $attrs; ?>>

		</div>
	</div>
</div>
		<?php

	}
}