<?php
	$acf_fc_layout = $args['acf_fc_layout'];
	$prefix = ''; 
	if(!empty($args['from_builder'])){ $prefix = 'field_'; } 
	$_prefix = $prefix.$acf_fc_layout;  
	$section = WPBC_get_section_row_args($args, $_prefix);  
	if(!empty($section['section_options']['visible'])) return; 
	//_print_code($section); 
?>
<div id="<?php echo $section['section_id']; ?>" class="gpy-2 gpy-md-4 bg-<?php echo $section['section_options']['style']; ?> text-<?php echo $section['section_options']['style_color']; ?>">

	<div class="container">

		<?php if(!empty( $section['section_title'] )){ ?>
			<div class="row">
				<div class="col-md-11 mx-auto" data-is-inview="detect">
					<div data-is-inview-fx="fadeInUp" data-transition-delay=".3s">
						<h2 class="section-title text-center m-0"><?php echo $section['section_title']; ?></h2>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php
			WPBC_get_template_part('parts/call_to_action', array(
				'call_to_action' => $section['call_to_action'], 
				'prefix' => $prefix
			)); 
		?>

	</div>

</div>