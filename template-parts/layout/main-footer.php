<?php

$use_footer = WPBC_get_field('layout_footer_template');
$alt_footer = WPBC_get_field("layout_general_alt_footer"); 

$use_footer = apply_filters('wpbc/woo/layout/use_footer', $use_footer);
$alt_footer = apply_filters('wpbc/woo/layout/alt_footer', $alt_footer);

if($use_footer=='none') return;
// _print_code($use_footer); 
?>

<footer id="main-footer">

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

			<div class="col-md-3 text-center text-md-left">
				<?php
				$logo = '[WPBC_get_stylesheet_directory_uri]/images/theme/wala-violet.svg'; 
				?>
				<img class="footer-brand" width="120" src="<?php echo $logo; ?>" alt="<?php echo get_bloginfo('title'); ?>" />
			</div>

			<div class="col-md-4 col-lg-6 col-xl-5 text-center text-md-left gpy-1 gpy-md-0	">
				<div class="row">
					<div class="col-lg-6">
						<?php
						$m_ar = array(
							'theme_location'  => 'left_footer',
							'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
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
					<div class="col-lg-6">
						<?php
						$m_ar = array(
							'theme_location'  => 'right_footer',
							'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
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
					</div>
				</div>
			</div>

			<div class="col-md-5 col-lg-3 col-xl-4 text-center text-md-right">
				<?php
				$m_ar = array(
					'theme_location'  => 'call_to_action_footer',
					'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
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

		<div class="row align-items-center gpt-4">

			<div class="col-md-6 text-center text-md-left">
				<p class="ui-footer-copy"><?php echo WPBC_get_theme_settings("footer_copyright"); ?></p>
			</div>

			<div class="col-md-6 text-center text-md-right">
				<p class="ui-footer-social"><?php

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
		
		</div>
	
	</div>

	<?php } ?>

	<?php if($alt_footer) { ?>

		<div class="container gpt-2 gpb-2 position-relative">

			<div class="d-flex justify-content-start align-items-center">

				<div class="text-center text-md-left">
					<?php
					$logo = '[WPBC_get_stylesheet_directory_uri]/images/theme/wala-violet.svg'; 
					?>
					<img class="footer-brand" width="120" src="<?php echo $logo; ?>" alt="<?php echo get_bloginfo('title'); ?>" />
				</div>

				<div class="text-center mx-auto footer-copyright gpb-md-2">
					<p class="ui-footer-copy m-0"><?php echo WPBC_get_theme_settings("footer_copyright"); ?></p>
				</div>

			</div>

		</div>

	<?php } ?>

</footer>