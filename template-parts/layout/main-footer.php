<?php

$use_footer = WPBC_get_field('layout_footer_template');
$alt_footer = WPBC_get_field("layout_general_alt_footer"); 

$use_footer = apply_filters('wpbc/woo/layout/use_footer', $use_footer);
$alt_footer = apply_filters('wpbc/woo/layout/alt_footer', $alt_footer);

if($use_footer=='none') return;
// _print_code($use_footer); 
?>

<footer id="main-footer" class="bg-white">

	<?php
	$show_prefooter = WPBC_get_field('layout_general_show_prefooter');
	$show_prefooter = apply_filters('wpbc/woo/layout/show_prefooter', $show_prefooter);
	if( !empty($show_prefooter) ){
		WPBC_get_template_part('theme/prefooter');  
	}
	?>

	<?php if(!$alt_footer) { ?>

	<div class="container gpt-2 gpb-1">

		<div class="row">

			<div class="col-md-3 text-center text-md-left order-3 order-md-1">
				<?php
				$logo = '[WPBC_get_stylesheet_directory_uri]/images/theme/wala-violet.svg'; 
				?>
				<img class="footer-brand" width="120" src="<?php echo $logo; ?>" alt="<?php echo get_bloginfo('title'); ?>" />
			</div>

			<div class="col-md-3 col-lg-3 col-xl-3 text-center text-md-left gpy-1 gpy-md-0 order-2">
				<?php
						$m_ar = array(
							'theme_location'  => 'left_footer',
							'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
							'container'       => 'div',
							'container_class' => '',
							'container_id'    => 'navbar-left_footer',
							'menu_class'      => 'navbar-nav navbar-nav-footer left_footer',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker(), 
							'before_menu'			=> '',
							'after_menu'			=> '',
						);
						wp_nav_menu($m_ar);
						?>
			</div>

			<div class="col-md-3 col-lg-3 col-xl-3 text-center text-md-left gpy-1 gpy-md-0 order-2">
				<?php
						$m_ar = array(
							'theme_location'  => 'right_footer',
							'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
							'container'       => 'div',
							'container_class' => '',
							'container_id'    => 'navbar-right_footer',
							'menu_class'      => 'navbar-nav navbar-nav-footer right_footer',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker(), 
							'before_menu'			=> '',
							'after_menu'			=> '',
						);
						wp_nav_menu($m_ar);
						?>
						<p class="ui-footer-social mx-n2"><?php

							$social = WPBC_get_theme_settings("general_social"); 
							if(!empty($social)){
								foreach ($social as $key => $value) {
									$type = $value['social_items_type'];
									$href = $value['social_items_url'];
									?>
									<a data-btn="fx" class="btn btn-icon btn-square" href="<?php echo $href; ?>">
										<?php echo do_shortcode('[social_'.$type.' color="#999"]'); ?>
									</a>
									<?php
								}
							}

						?></p>
			</div>

			<div class="col-md-3 col-lg-3 col-xl-3 text-center text-md-right order-1 order-md-3">
				<?php
				$m_ar = array(
					'theme_location'  => 'call_to_action_footer',
					'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
					'container'       => 'div',
					'container_class' => '',
					'container_id'    => 'navbar-call_to_action_footer',
					'menu_class'      => 'navbar-nav navbar-nav-footer call_to_action_footer',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap_Navwalker(), 
					'before_menu'			=> '',
					'after_menu'			=> '',
				);
				wp_nav_menu($m_ar);
				?>
			</div>

		</div>

		<div class="row align-items-center gpt-2 gpt-md	-4">

			<div class="col-md-6 text-center text-md-left order-2 order-md-1">
				<p class="ui-footer-copy footer_copyright"><?php echo WPBC_get_theme_settings("footer_copyright"); ?> <?php
				$m_ar = array(
					'theme_location'  => 'copyright_footer',
					'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
					'container'       => '',
					'container_class' => '',
					'container_id'    => 'navbar-copyright_footer',
					'menu_class'      => 'navbar-nav navbar-nav-footer copyright_footer',
					//'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					//'walker'          => new WP_Bootstrap_Navwalker(), 
					'before_menu'			=> '',
					'after_menu'			=> '',
					'items_wrap' => '%3$s',
					'echo' => false, 
				);
				$menu = wp_nav_menu($m_ar);
				echo strip_tags($menu, '<a>' );
				?></p>
			</div>

			<div class="col-md-3 text-center text-md-left order-3 order-md-2">
				<p class="ui-footer-copy"><a href="http://vrij.com.uy/" target="_blank">Vrij Diseño</a></p>
			</div>

			<div class="col-md-3 text-center text-md-right order-1 order-md-3 gmb-1 gmb-md-0">
				<div class="d-flex flex-wrap d-flex flex-wrap flex-row align-items-center justify-content-center justify-content-md-end">
					<img width="61" class="mx-1" src="[WPBC_get_stylesheet_directory_uri]/images/theme/visa@2x.png" alt="VISA" /> <img width="64" class="mx-1" src="[WPBC_get_stylesheet_directory_uri]/images/theme/mastercard@2x.png" alt="Mastercard" />
				</div>
			</div>
		
		</div>
	
	</div>

	<?php } ?>

	<?php if($alt_footer) { ?>

		<div class="container gpt-2 gpb-4 gpb-md-2 position-relative">

			<div class="d-flex justify-content-start align-items-center">

				<div class="text-center text-md-left mx-auto mx-md-0">
					<?php
					$logo = '[WPBC_get_stylesheet_directory_uri]/images/theme/wala-violet.svg'; 
					?>
					<img class="footer-brand" width="120" src="<?php echo $logo; ?>" alt="<?php echo get_bloginfo('title'); ?>" />
				</div>

				<div class="text-center mx-auto footer-copyright gpb-1 gpb-md-2">
					<p class="ui-footer-copy m-0"><?php echo WPBC_get_theme_settings("footer_copyright"); ?></p>
					<p class="ui-footer-copy m-0"><a href="http://vrij.com.uy/" target="_blank">Vrij Diseño</a></p>
				</div>

			</div>

		</div>

	<?php } ?>

</footer>

<div id="modal_zonas" class="modal fade" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-dialog-centered ui-loader " role="document">
    <div class="modal-content bg-rosa-claro">
      <div class="modal-header flex-column justify-content-center flex-wrap align-items-center gpt-3">
        
        <h5 class="modal-title section-title ">Zonas de envío</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body gpb-2">
        
        <ul class="list-tick">
        	<li>Pocitos</li>
					<li>Punta Carretas</li>
					<li>Malvín</li>
					<li>Punta Gorda</li>
					<li>Carrasco</li>
					<li>Parque Rodó</li>
					<li>Etc</li>
        </ul>

        <?php

        $delivery_zones = WC_Shipping_Zones::get_zones();

        $active_methods   = array();
		    foreach ($delivery_zones as $delivery_zone) {
		    	$shipping_methods = $delivery_zone['shipping_methods']; 
			    foreach ( $shipping_methods as $id => $shipping_method ) {
			      if ( isset( $shipping_method->enabled ) && 'yes' === $shipping_method->enabled ) {
			        $active_methods[ $id ] = array(
			          'title'      => $shipping_method->title,
			          'rate' => $shipping_method->rate,
			          'tax_status' => $shipping_method->tax_status,
			        );
			      }
			    }
		    	
		    }
		    // Testeando aca para mostrar directo de las zonas, eso, las zonas de delivery
				// _print_code($active_methods);
        ?>
      
      </div>
    </div>
  </div>

  
</div>

<?php WPBC_get_template_part('theme/modal_subscribe_form'); ?>
