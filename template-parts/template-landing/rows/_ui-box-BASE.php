<?php 
	$acf_fc_layout = $args['acf_fc_layout'];
	$prefix = '';
	if(!empty($args['from_builder'])){
		$prefix = 'field_';
	}

	$section_title = $args[$prefix.$acf_fc_layout.'__section-title']; 
	$call_to_action = $args[$prefix.$acf_fc_layout.'__call_to_action']; 

	$section_id = sanitize_title($section_title);  

	$section_options = $args[$prefix.$acf_fc_layout.'__section_options']; 
		$section_options_visible = $section_options[$prefix.$acf_fc_layout.'__section_options_visible']; 
	if(!empty($section_options_visible)) return; 
	//_print_code($args); 
?>
<div id="<?php echo $section_id; ?>" class="gpy-4">

	<div class="container">

		<div class="row">

			<div class="col-md-11 mx-auto" data-is-inview="detect">
 
				<div data-is-inview-fx="fadeInUp" data-transition-delay=".4s">
					<h2 class="section-title text-center"><?php echo $section_title; ?></h2>
				</div>

			</div>

		</div>

		<!-- REST OF THINGS COULD BE HERE -->

		<?php
			WPBC_get_template_part('parts/call_to_action', array(
				'call_to_action' => $call_to_action, 
				'prefix' => $prefix
			)); 
		?>

	</div>

</div>