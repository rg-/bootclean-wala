<?php
	
	$show_paso_inicio = true;
	$show_paso_2 = false;
	$show_paso_3 = false;

	if( ! empty( $_POST['grouped_personas_option'] ) ) { 
		$grouped_personas = $_POST['grouped_personas_option']; 
		$show_paso_2 = true;
	}
	if( ! empty( $_POST['grouped_recetas_option'] ) ) { 
		$grouped_recetas = $_POST['grouped_recetas_option']; 
	} 

	if( ! empty( $_POST['grouped_personas_option'] ) && ! empty( $_POST['grouped_recetas_option'] ) ) {
		$show_paso_3 = true;
		$show_paso_inicio = false;
	} 

	$show_paso_4 = false;
	if( is_cart() || is_checkout() ){
		$show_paso_2 = true;
		$show_paso_3 = true;
		$show_paso_4 = true;
		$show_paso_inicio = false;
	}

?>
<div class="pasos_main_nav order-2 d-flex">

	<div class="pasos d-flex mx-auto">

		<div class="paso d-flex flex-column align-items-center justify-content-start paso-plan <?php echo $show_paso_inicio ? 'current' : '';?> <?php echo $show_paso_3 ? 'current completed' : '';?>">
			<span class="dot"><i class="icon fa fa-check"></i></span>
			<span class="label">PLAN</span>
		</div>

		<div class="paso d-flex flex-column align-items-center justify-content-start paso-seleccion <?php echo $show_paso_3 ? 'current' : '';?> <?php echo $show_paso_4 ? 'current completed' : '';?>">
			<span class="dot"><i class="icon fa fa-check"></i></span>
			<span class="label">SELECCIÓN DE RECETAS</span>
		</div>

		<div class="paso d-flex flex-column align-items-center justify-content-start paso-checkout <?php echo $show_paso_4 ? 'current' : '';?> <?php echo is_wc_endpoint_url('order-received') ? 'completed' : '';?>">
			<span class="dot"><i class="icon fa fa-check"></i></span>
			<span class="label">CHECKOUT</span>
		</div>

	</div>

</div>

<div class="user_main_nav order-3 ml-auto pt-3 mt-2 gmr-1">
	<?php
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' ); 
	$myaccount_page_title = get_the_title($myaccount_page_id);
		$myaccount_menu_label = $myaccount_page_title;
	$myaccount_page_url = get_the_permalink($myaccount_page_id);

	if(is_user_logged_in()){
		$wp_get_current_user = wp_get_current_user();  
		$myaccount_menu_label = '<i><b>'.$wp_get_current_user->user_login.'</b></i>'; 
	}

	$start_menu_item .= '<a title="'.$myaccount_page_title.'" href="'.$myaccount_page_url.'" class="nav-link text-primary">'.$myaccount_menu_label.'</a>';

	echo $start_menu_item; 
	?>
</div>