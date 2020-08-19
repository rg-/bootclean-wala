<?php


add_action('init',function(){

	$fields = array();  

		$fields[] = WPBC_acf_make_subtitle_field(array(
			'label' => '',
			'key' => 'field_grouped_personas_description', 
			'width' => '100%', 
			'message' => '<i><b>Opciones</b></i>: Separar con comas cada opción, ej. "2,5,7". <br><i><b>Opción por defecto</b></i>: Dejar en blanco para no usar ningúna opción seleccionada al iniciar los pasos.',
			'class' => 'wpbc-field-mo-label'
		));
		$fields[] = WPBC_acf_make_subtitle_field(array(
			'label' => '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="#6639b7" d="M16.5 13c-1.2 0-3.07.34-4.5 1-1.43-.67-3.3-1-4.5-1C5.33 13 1 14.08 1 16.25V19h22v-2.75c0-2.17-4.33-3.25-6.5-3.25zm-4 4.5h-10v-1.25c0-.54 2.56-1.75 5-1.75s5 1.21 5 1.75v1.25zm9 0H14v-1.25c0-.46-.2-.86-.52-1.22.88-.3 1.96-.53 3.02-.53 2.44 0 5 1.21 5 1.75v1.25zM7.5 12c1.93 0 3.5-1.57 3.5-3.5S9.43 5 7.5 5 4 6.57 4 8.5 5.57 12 7.5 12zm0-5.5c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 5.5c1.93 0 3.5-1.57 3.5-3.5S18.43 5 16.5 5 13 6.57 13 8.5s1.57 3.5 3.5 3.5zm0-5.5c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/></svg>'.' Cantidad Personas',
			'key' => 'field_grouped_personas_args', 
			'width' => '100%',  
		));

			$fields[] = WPBC_acf_make_text_field(array(
				'label' => 'Título',
				'name' => 'grouped_personas_title',
				'default_value' => '',
				'width' => '50%',  
			));

				$fields[] = WPBC_acf_make_text_field(array(
					'label' => 'Opciones',
					'name' => 'grouped_personas_opciones',
					'default_value' => '', 
					'width' => '25%', 
				));

				$fields[] = WPBC_acf_make_text_field(array(
					'label' => 'Opción por defecto',
					'name' => 'grouped_personas',
					'default_value' => '', 
					'width' => '25%', 
				)); 

				$fields[] = WPBC_acf_make_text_field(array(
					'label' => 'Descripción',
					'name' => 'grouped_personas_desc',
					'default_value' => '',
					'width' => '100%', 
				));

		$fields[] = WPBC_acf_make_subtitle_field(array(
			'label' => '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="#6639b7" d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/></svg>'.' Cantidad Recetas',
			'key' => 'field_grouped_recetas_args', 
			'width' => '100%', 
		));

		$fields[] = WPBC_acf_make_text_field(array(
			'label' => 'Título',
			'name' => 'grouped_recetas_title',
			'default_value' => '',
			'width' => '50%', 
		));

			$fields[] = WPBC_acf_make_text_field(array(
				'label' => 'Opciones',
				'name' => 'grouped_recetas_opciones',
				'default_value' => '', 
				'width' => '25%', 
			));

			$fields[] = WPBC_acf_make_number_field(array(
				'label' => 'Opción por defecto',
				'name' => 'grouped_recetas',
				'default_value' => '', 
				'width' => '25%', 
			));   

			$fields[] = WPBC_acf_make_text_field(array(
					'label' => 'Descripción',
					'name' => 'grouped_recetas_desc',
					'default_value' => '',
					'width' => '100%', 
				));

	if( function_exists('acf_add_local_field_group') ){ 

		acf_add_local_field_group(array(
			'key' => 'group_woo_grouped_product',
			'title' => '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="#fff" d="M4 14h4v-4H4v4zm0 5h4v-4H4v4zM4 9h4V5H4v4zm5 5h12v-4H9v4zm0 5h12v-4H9v4zM9 5v4h12V5H9z"/></svg>'.' Opciones del Plan (Pasos)',
			'fields' => $fields,
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'product',
					),
					array(
						'param' => 'post_taxonomy',
						'operator' => '==',
						'value' => 'product_type:grouped',
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

}); 

add_action('add_meta_boxes','WPBC_woo_grouped_meta_boxes', 50);

function WPBC_woo_grouped_meta_boxes(){
	$get_screen = get_current_screen();
    $current_screen = $get_screen->post_type; 
    if ($current_screen == 'product' && isset($_GET['post']) ) {  
    		$product = wc_get_product( $_GET['post'] );
    		if($product->get_type() == 'grouped'){
					remove_meta_box( 'postexcerpt' , 'product' , 'normal' );
					remove_meta_box( 'commentsdiv' , 'product' , 'normal' );
					remove_meta_box( 'woocommerce-product-images' , 'product' , 'side' );
					remove_meta_box( 'postimagediv' , 'product' , 'side' );
					remove_meta_box( 'product_catdiv' , 'product' , 'side' );
					remove_meta_box( 'tagsdiv-product_tag' , 'product' , 'side' );
				}
	    }  
}

add_action( 'current_screen', 'WPBC_woo_grouped_editor_support' );
function WPBC_woo_grouped_editor_support() { 
    $get_screen = get_current_screen();
    $current_screen = $get_screen->post_type; 
    if ($current_screen == 'product' && isset($_GET['post']) ) {  
    		$product = wc_get_product( $_GET['post'] );
    		if($product->get_type() == 'grouped'){
        	remove_post_type_support( $current_screen, 'editor' );   
        }
    }  
}
add_filter('admin_body_class', function($classes){

	$get_screen = get_current_screen();
  $current_screen = $get_screen->post_type; 
  if ($current_screen == 'product' && isset($_GET['post']) ) {  
  		$product = wc_get_product( $_GET['post'] );
  		if($product->get_type() == 'grouped'){
      	$classes .= ' woo_grouped_product';
      }
  }  
  return $classes;
},10,1);

add_action('admin_head',function(){ 
	$get_screen = get_current_screen();
  $current_screen = $get_screen->post_type; 
  if ($current_screen == 'product' && isset($_GET['post']) ) {  
  		$product = wc_get_product( $_GET['post'] );
  		if($product->get_type() == 'grouped'){
      	?>
<style>

	#acf-group_woo_grouped_product > .handlediv .toggle-indicator{
		color:#fff;
	}
	#acf-group_woo_grouped_product > .ui-sortable-handle{
		background-color: #6639b7;
		color:#fff;
	}
	#acf-group_woo_grouped_product > .ui-sortable-handle svg{
		vertical-align: -7px;
	}

</style>
<?php
      }
  } 

});



/*
	
	Remove delete buttons for a particular post id, in this case the grouped product used 

*/

//hide meta with styles 
//add_action('admin_head-post.php', 'WPBC_woo_grouped_product_hide_publishing_actions');
//add_action('admin_head-post-new.php', 'WPBC_woo_grouped_product_hide_publishing_actions');

//for quick edit
add_filter( 'post_row_actions', 'remove_row_actions_post', 1, 2 );
function remove_row_actions_post( $actions, $post ) {

	$ordenar_product_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar_product');
	
    if( !current_user_can('administrator') && $post->post_type === 'product' && $post->ID == $ordenar_product_id ) {
        //unset( $actions['clone'] );
      unset( $actions['delete'] );
        //unset( $actions['trash'] ); 
    }
    return $actions;
}

add_action( 'admin_head', 'wpse_237305_disable_trash' );

function wpse_237305_disable_trash() {
    global $pagenow;
    global $post;
    $ordenar_product_id = get_option('options_wpbc_theme_settings__general_post_object_ordenar_product');
    
    if ( $pagenow == 'edit.php' ) {
    	?>
<style>tr#post-408 td, tr#post-408 th{ background-color: #f1dcef; }
tr#post-408 .is_in_stock *,
tr#post-408 .price *,
tr#post-408 .product_cat *,
tr#post-408 .product_tag *,
tr#post-408 .featured *{
		visibility: hidden;
}
</style>
    	<?php
    }

    if ( $pagenow == 'post.php' ) {
    	if( !current_user_can('administrator') && $post->post_type === 'product' && $post->ID == $ordenar_product_id ) {
        ?>
        <style>#delete-action{display: none!important;}</style>
        <script type="text/javascript">
            jQuery( document ).ready( function( $ ) {
                $( '#delete-action' ).remove();
            } );
        </script>
        <?php
      }
    }
}