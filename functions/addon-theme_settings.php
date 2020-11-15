<?php

/*

	Show helpers on fields on admin, that is
	front end function to get the field like 

*/

add_filter('wpbc/filter/theme_settigs/show_helpers', function($show_helpers){
	if(current_user_can('administrator')){
		$show_helpers = true;
	}else{
		$show_helpers = false;
	}
	return $show_helpers;
},10,1);



/*

	Remove tabs and fields from Theme Settings Groups

	Defaults are:

			'fields-general',
			'fields-header',
			'fields-footer',
			'fields-typography',
			'fields-custom-code',

*/ 

add_filter('wpbc/filter/theme_settings/file_path', function($file_path, $key){

	$excluded_groups = array(
		'fields-header',
		// 'fields-typography'
	);

	if( in_array($key, $excluded_groups) ){
		$file_path = '';
	}

	return $file_path;

},10,2);


/*

	Filter arguments for option page and default group

*/



add_filter('wpbc/filter/theme_settings/args',function($args){ 

	$args['options_page']['page_title'] = 'Walá settings';
	$args['options_page']['menu_title'] = 'Walá settings';
	$args['options_page']['icon_url'] = ''; 
	
	// $args['options_page']['menu_background'] = '#6639b7'; // admin menu background-color
	$args['options_page']['menu_color'] = '#eaab00'; // admin menu color

		$args['options_page']['menu_background_active'] = '#eaab00';  
		$args['options_page']['menu_color_active'] = '#fff'; 

	return $args;
},11,1);


add_filter('wpbc/filter/theme_settings/fields/general', 'WPBC_child_custom_theme_settings__general', 10, 1);

function WPBC_child_custom_theme_settings__general($fields){ 

	$fields[] = WPBC_acf_make_post_object_field(array(
		'name' => 'general_post_object_recetas',
		'label' => 'Página Principal de Recetas',
		'instructions' => 'Esta página <u>no</u> es, y no debe ser, la página <i>Tienda</i> usada por Woocommerce.',
		'post_type' => array( 'page' ),
		'multiple' => 0, 
		'ui' => 0,
	));

	$fields[] = WPBC_acf_make_post_object_wpbc_template(array(
		'name' => 'general_single_product_template',
		'label' => 'Incluír este template al pié de la página de cada Receta',
		'instructions' => '', 
		'width' => '60%',
		'multiple' => 0, 
		'ui' => 0,
	));

	$fields[] = WPBC_acf_make_true_false_field(array(
		'name' => 'general_single_product_prefooter',
		'label' => '¿Mostrar Subscribirse?',
		'default_value' => 1,
		'width' => '40%',
	));


	$choices_cats = array();
		$args = array(
			'taxonomy' => 'product_cat',
			'orderby' => 'name', // count, slug, term_group, term_id, id
			'order' => 'ASC',
			'hide_empty' => false, 
		);

		$choices_cats[0] = 'Selecciona una categoría';

		$term_query = new WP_Term_Query( $args );
		if ( ! empty( $term_query->terms ) ) {

			foreach ( $term_query ->terms as $term ) {
				// echo $term->name;
				if(empty($term->parent)){
					$choices_cats[$term->term_id] = $term->name;
				}
			}
		} 

	$fields[] = WPBC_acf_make_select_field(array(
		'name' => 'general_post_object_recetas_cat',
		'label' => 'Categoría usada para las Recetas',
		'instructions' => 'Categoría madre donde se administran las subcategorías de las Recetas.',
		//'post_type' => array( 'product' ),
		'choices' => $choices_cats,
		'multiple' => 0, 
		'allow_null' => 1,
		'required' => 0,
		'default_value' => array (0),
		'ui' => 1,
	));

	$fields[] = WPBC_acf_make_select_field(array(
		'name' => 'general_post_object_vinos_cat',
		'label' => 'Categoría usada para los Vinos',
		'instructions' => 'Categoría donde se administran las subcategorías de los Vinos.',
		//'post_type' => array( 'product' ),
		'choices' => $choices_cats,
		'multiple' => 0, 
		'allow_null' => 1,
		'required' => 0,
		'default_value' => array (0),
		'ui' => 1,
	));

	$fields[] = WPBC_acf_make_post_object_field(array(
		'name' => 'general_post_object_ordenar',
		'label' => 'Página Ordenar (pasos)',
		'instructions' => '',
		'post_type' => array( 'page' ),
		'multiple' => 0, 
		'ui' => 0,
	));

	$fields[] = WPBC_acf_make_post_object_field(array(
		'name' => 'general_post_object_ordenar_product',
		'label' => 'Producto Agrupado Ordenar (pasos)',
		'instructions' => '',
		'post_type' => array( 'product' ),
		'multiple' => 0, 
		'ui' => 0,
	));

	$fields[] = WPBC_acf_make_social_items_group_field(array(
		'name' => 'general_social',
		'label' => 'Redes Sociales', 
	));


	$fields[] = WPBC_acf_make_message_field(array(
		'key' => 'general_delivery',
		'label' => 'Opciones Delivery/Checkout', 
	));

	$fields[] = WPBC_acf_make_text_field(array(
		'name' => 'shipping_method_id_montevideo',
		'label' => 'ID Montevideo', 
	));
	$fields[] = WPBC_acf_make_text_field(array(
		'name' => 'shipping_method_id_miramar',
		'label' => 'ID Miramar', 
	));

	return $fields;
} 

add_filter('wpbc/filter/theme_settings/fields/footer', 'WPBC_child_custom_theme_settings__footer', 10, 1);

function WPBC_child_custom_theme_settings__footer($fields){  
	$fields[] =  WPBC_acf_make_text_field(
		array( 
			'name' => 'footer_whatsapp',
			'label' => 'Whatsapp',  
		)
	); 
	$fields[] =  WPBC_acf_make_post_object_wpcf7_field(
		array( 
			'name' => 'footer_form',
			'label' => 'Formulario de suscripción',  
		)
	); 
	return $fields;
} 



add_filter( 'display_post_states', 'WPBC_custom_display_post_states', 10, 2 );

/**
 * Add a post display state for special WC pages in the page list table.
 *
 * @param array   $post_states An array of post display states.
 * @param WP_Post $post        The current post object.
 */
function WPBC_custom_display_post_states( $post_states, $post ) {
    
    if ( WPBC_get_theme_settings('general_post_object_ordenar') === $post->ID ) {
        $post_states['wc_page_for_ordenar'] = 'Página de "Ordenar Pedido"';
    } 

    if ( WPBC_get_theme_settings('general_post_object_recetas') === $post->ID ) {
        $post_states['wc_page_for_recetas'] = 'Página de "Recetas"';
    }

    if ( WPBC_get_theme_settings('general_post_object_ordenar_product') === $post->ID ) {
        $post_states['wc_page_for_grouped'] = 'Recetas Agrupadas';
    }

    return $post_states;
}

function restrict_page_deletion($post_ID){
    $user = get_current_user_id();

    $restricted_pageId = 4;

    if($post_ID == WPBC_get_theme_settings('general_post_object_recetas'))
    {
        echo "You are not authorized to delete this page.";
        exit;
    }
}
//add_action('before_delete_post', 'restrict_page_deletion', 10, 1);


/*

	Adding a custom theme dashboard and removing WPBC one

*/

add_filter('wpbc/admin/dashboard', function($use){
	$wp_get_current_user = wp_get_current_user();
	if(!current_user_can('administrator')){
		$use = false;
	}
	return $use;
},10,1);

/**
 * Add a new dashboard widget.
 */
add_action( 'wp_dashboard_setup', 'wala_add_dashboard_widgets' );
function wala_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'wala_dashboard_widget', 'Walá > Resumen', 'wp_dashboard_widget_function' );
}

 
/**
 * Output the contents of the dashboard widget
 */
function wp_dashboard_widget_function( $post, $callback_args ) { 
	$wp_get_current_user = wp_get_current_user(); 

	$li_style = ' style="border-top: 1px solid #ececec; " ';
	$btn_style = ' style=" padding: 9px 12px; display: block; font-size: 18px; color:var(--primary);" ';
	$small_style = ' style="color:#aaa!important; font-size: 12px!important; display:block;" ';
	$icon_style = ' style="vertical-align: -2px;" ';
	$title_style = ' style="font-weight:400;" ';
  ?>
  <div class="main">

  	<?php // echo do_shortcode('[icon_walla color="var(--primary)"]');?>

  	<p>Hola <i><b><?php echo $wp_get_current_user->user_login; ?></b></i></p>

  </div>

  <ul class="" style="margin:0 -12px; overflow: hidden; margin-bottom:0">

		<li <?php echo $li_style; ?>>
			<a <?php echo $btn_style; ?> href="<?php echo menu_page_url('wpbc-site-settings',false); ?>">
				<span <?php echo $icon_style; ?>><i class="dashicons dashicons-admin-generic"></i></span>
				<b <?php echo $title_style; ?>>Walá Settings</b>
				<small <?php echo $small_style; ?>>Configura links a redes sociales, textos genéricos, copyright, etc.</small>
			</a>
		</li>

		<?php
		$args = array(
			'post_status' => 'publish',
			'post_type' => 'product',
			'posts_per_page' => -1, 
			'tax_query' => array(
				        array(
				            'taxonomy' => 'product_type',
				            'field'    => 'slug',
				            'terms'    => 'simple', 
				        ),
				    ),
			);
		$loop = new WP_Query( $args ); 
		?>
		<li <?php echo $li_style; ?>>
			<a <?php echo $btn_style; ?> href="<?php echo admin_url('edit.php?post_type=product'); ?>">
				<span <?php echo $icon_style; ?>><?php echo do_shortcode('[icon_porciones color="var(--primary)"]');?></span>
				<b <?php echo $title_style; ?>> <?php echo $loop->found_posts; ?> Recetas <small class="wpbc-badge" style="background-color: var(--primary);">administrar</small></b>
				<small <?php echo $small_style; ?>>Publicadas.</small>
			</a>
		</li>

		<?php
		$args = array(
			'post_status' => 'publish',
			'post_type' => 'ingrediente',
			'posts_per_page' => -1, 
			);
		$loop = new WP_Query( $args ); 
		?>
		<li <?php echo $li_style; ?>>
			<a <?php echo $btn_style; ?> href="<?php echo admin_url('edit.php?post_type=ingrediente'); ?>">
				<span <?php echo $icon_style; ?>><?php echo do_shortcode('[icon_heladera color="var(--primary)"]');?></span>
				<b <?php echo $title_style; ?>> <?php echo $loop->found_posts; ?> Ingredientes <small class="wpbc-badge" style="background-color: var(--naranja);">administrar</small></b>
				<small <?php echo $small_style; ?>>Todos los ingredientes en un solo lugar.</small>
			</a>
		</li>

	</ul>

	<?php
	$receas_id = WPBC_get_theme_settings('general_post_object_recetas');
	$ordenar_id = WPBC_get_theme_settings('general_post_object_ordenar');
	$ordenar_product_id = WPBC_get_theme_settings('general_post_object_ordenar_product');

	$small_style = ' style="color:#aaa!important; font-size: 12px!important; display:block; margin-top:10px;" ';
	$i_style = ' style="font-size: 12px!important;font-style: normal;color: #222;display: inline-block;vertical-align: 2px;" ';
	?>
	<hr>
	<div class="main">
		<br>
  	<h3>Páginas requeridas del sistema:</h3>
  	<br>
  </div>
	<ul style="margin:0 -12px; overflow: hidden; margin-bottom:0">
		
		<li <?php echo $li_style; ?>>
			<div <?php echo $btn_style; ?> >
				<b <?php echo $title_style; ?>><span class="dashicons dashicons-yes text-success"></span> <i <?php echo $i_style; ?>>Página</i> — Principal de Recetas</b>
				<small <?php echo $small_style; ?>>
					Donde se muestran todas las Recetas. <a href="<?php echo get_edit_post_link($receas_id); ?>" class="wpbc-btn-small button" style="background-color: var(--naranja)!important; border-color: var(--naranja)!important;">editar</a> <a href="<?php echo get_the_permalink($receas_id); ?>" class="wpbc-btn-small button" style="background-color: var(--naranja);" target="_blank" title="Abre en otra ventana">ver</a>
				</small>
			</div>
		</li>

		<li <?php echo $li_style; ?>>
			<div <?php echo $btn_style; ?> >
				<b <?php echo $title_style; ?>><span class="dashicons dashicons-yes text-success"></span> <i <?php echo $i_style; ?>>Página</i> — Ordenar (pasos)</b>
				<small <?php echo $small_style; ?>>
					Donde se selecciona el pedido. <a href="<?php echo get_edit_post_link($ordenar_id); ?>" class="wpbc-btn-small button" style="background-color: var(--naranja)!important; border-color: var(--naranja)!important;">editar</a> <a href="<?php echo get_the_permalink($ordenar_id); ?>" class="wpbc-btn-small button" style="background-color: var(--naranja);" target="_blank" title="Abre en otra ventana">ver</a>
				</small>
			</div>
		</li>

		<li <?php echo $li_style; ?>>
			<div <?php echo $btn_style; ?> >
				<b <?php echo $title_style; ?>><span class="dashicons dashicons-yes text-success"></span> <i <?php echo $i_style; ?>>Producto</i> — Agrupado Ordenar (pasos)</b>
				<small <?php echo $small_style; ?>>
					Producto donde se agrupan y procesan los pedidos. <a href="<?php echo get_edit_post_link($ordenar_product_id); ?>" class="wpbc-btn-small button" style="background-color: var(--naranja)!important; border-color: var(--naranja)!important;">editar</a>
				</small>
				<small <?php echo $small_style; ?>>Este producto no es visible directamente. Es el motor interno de todo el procesos. No puede ser borrado.</small>
			</div>
		</li>

	</ul>

  <?php
}