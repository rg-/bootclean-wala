<?php

/*

	Resumen:

		- Custom post_type para administrar los ingredientes
		usados en un selector custom en los productos simples (recetas)

		- usa ademas un upload_dir diferente al uploads de wp
			Los uploads a este post type quedan en:

			ej: wp-uploads/ingrediente

*/

add_action( 'init', 'WPBC_create_post_type__ingrediente' );

function WPBC_create_post_type__ingrediente(){
	$labels = array(
		'name' => _x('Ingredientes', 'wala'),
		'singular_name' => _x('Ingrediente', 'wala'),
		'add_new' => _x('Agregar Ingrediente', 'wala'),
		'add_new_item' => __('Nuevo Ingrediente'),
		'edit_item' => __('Editar Ingrediente'),
		'new_item' => __('Nuevo Ingrediente'),
		'all_items' => __('Todos los Ingredientes'),
		'view_item' => __('Ver Ingrediente'),
		'search_items' => __('Buscar Ingredientes'),
		'not_found' =>  __('No encontrado/s'),
		'not_found_in_trash' => __('No hay Ingredientes'), 
		'parent_item_colon' => '',
		'menu_name' => 'Ingredientes', 
	);

	$svg_img = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMjRweCIgaGVpZ2h0PSIyNHB4IiB2aWV3Qm94PSIwIDAgMjQgMjQiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDI0IDI0IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxwYXRoIGZpbGw9IiNGRkZGRkYiIGQ9Ik0xOCwyLjAxTDYsMkM0LjksMiw0LDIuODksNCw0djE2YzAsMS4xLDAuOSwyLDIsMmgxMmMxLjEsMCwyLTAuOSwyLTJWNEMyMCwyLjg5LDE5LjEsMi4wMSwxOCwyLjAxeiBNMTgsMjANCglINnYtOS4wMmgxMlYyMHogTTE4LDlINlY0aDEyVjl6Ii8+DQo8cmVjdCB4PSI4IiB5PSI1IiBmaWxsPSIjRkZGRkZGIiB3aWR0aD0iMiIgaGVpZ2h0PSIzIi8+DQo8cmVjdCB4PSI4IiB5PSIxMiIgZmlsbD0iI0ZGRkZGRiIgd2lkdGg9IjIiIGhlaWdodD0iNSIvPg0KPC9zdmc+DQo=';

	$args = array(
		'labels' => $labels,
		'description' => '',
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'query_var' => true,
		'hierarchical' => false,
		'supports' => array('title'),
		'rewrite' => false,
		'has_archive' => false,
		'menu_icon' => $svg_img,
		'menu_position' => 3,
		'show_in_menu' => true,
	);
	register_post_type('ingrediente',$args);
} 

/* ADMIN STYLES */

add_action('admin_head', function(){
	?>
	<style>
#adminmenu #menu-posts-ingrediente > a{ 
  color: #eaab00!important;
} 
#adminmenu #menu-posts-ingrediente > a svg{
	vertical-align: -7px;
}
#adminmenu #menu-posts-ingrediente.wp-menu-open > a,
#adminmenu #menu-posts-ingrediente > a.current{
	background-color: #eaab00!important;
	color: #fff!important;
}
</style>
	<?php
});

/* ADMIN COLUMNS */

add_filter( 'manage_ingrediente_posts_columns', 'wpbc_manage_ingrediente_posts_columns' );  
function wpbc_manage_ingrediente_posts_columns( $defaults ) { 
   $defaults['featured-image'] = 'Imagen';
   return $defaults;
}
add_action( 'manage_ingrediente_posts_custom_column', 'wpbc_manage_ingrediente_posts_custom_column', 5, 2 );
function wpbc_manage_ingrediente_posts_custom_column( $column_name, $id ) { 
   if ( $column_name === 'featured-image' ) { 
   	$ingrediente_image = WPBC_get_field('woo_ingrediente_image',$id);
   	//  _print_code($ingrediente_image );
   	if($ingrediente_image){ 
   		echo '<img width="50" src="'. $ingrediente_image['sizes']['thumbnail'] .'"/>'; 
   	}else{
   		echo "No hay una imágen asignada.";
   	}
   }
}


/* ACF Fields */

if( function_exists('acf_add_local_field_group') ){ 

	acf_add_local_field_group(array(
		'key' => 'group_woo_ingrediente',
		'title' => 'Opciones Ingrediente',
		'fields' => array(
			array(
				'key' => 'field_woo_ingrediente_image',
				'label' => 'Imagen',
				'name' => 'woo_ingrediente_image',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'ingrediente',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));

}

/* Custom Upload folder for "ingrediente" post_type */

add_filter( 'acf/upload_prefilter/name=woo_ingrediente_image', 'woo_ingrediente_image_upload_prefilter' );
add_filter( 'acf/prepare_field/name=woo_ingrediente_image', 'woo_ingrediente_image_field_display' );

function woo_ingrediente_image_upload_prefilter( $errors ) { 
  add_filter( 'upload_dir', 'woo_ingrediente_upload_directory' ); 
  return $errors; 
}
function woo_ingrediente_image_field_display( $field ) {  
  add_filter( 'upload_dir', 'woo_ingrediente_upload_directory' ); 
  return $field; 
}

function woo_ingrediente_upload_directory( $args ) {
        
  $folder = '/ingredientes';

  // Get the current post_id
  $id = ( isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : '' );

  if( $id && get_post_type( $id ) == 'ingrediente' ) {    
     // Set the new path depends on current post_type
     $newdir = '/' . get_post_type( $id );

     $args['path']    = str_replace( $args['subdir'], '', $args['path'] ); //remove default subdir
     $args['url']     = str_replace( $args['subdir'], '', $args['url'] );      
     $args['subdir']  = $newdir;
     $args['path']   .= $newdir; 
     $args['url']    .= $newdir; 
  }
  return $args; 

}  