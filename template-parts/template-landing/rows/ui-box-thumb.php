<?php
	$acf_fc_layout = $args['acf_fc_layout'];
	$prefix = ''; 
	if(!empty($args['from_builder'])){ $prefix = 'field_'; } 
	$_prefix = $prefix.$acf_fc_layout;  
	$section = WPBC_get_section_row_args($args, $_prefix);  
	if(!empty($section['section_options']['visible'])) return; 
	//_print_code($args); 
?>
<div id="<?php echo $section['section_id']; ?>" class="gpy-2 gpy-md-4 bg-<?php echo $section['section_options']['style']; ?> text-<?php echo $section['section_options']['style_color']; ?>">

	<div class="container">

		<?php if(!empty( $section['section_title'] )){ ?>
			<div class="row">
				<div class="col-md-11 mx-auto" data-is-inview="detect">
					<div data-is-inview-fx="fadeInUp" data-transition-delay=".3s">
						<h2 class="section-title text-center"><?php echo $section['section_title']; ?></h2>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php
		$section_boxes = $args[$prefix.$acf_fc_layout.'__boxes'];

		if(!empty($section_boxes)){
		?>
		<div class="row justify-content-center row-twice-gutters gmt-2 gmt-sm-4" >
			<?php
			$count = 0;
			foreach ($section_boxes as $key => $value) {  
				$image = $value[$prefix.$acf_fc_layout.'__boxes_'.'image']; 
				if(empty($prefix)){
					$image = $image['id'];
				} 
					$image_large = wp_get_attachment_image_src($image, 'large');
					$image_medium = wp_get_attachment_image_src($image, 'medium'); 

				$group = $value[$prefix.$acf_fc_layout.'__boxes_'.'group'];
					$title = $group[$prefix.$acf_fc_layout.'__boxes_'.'title'];
					$text = $group[$prefix.$acf_fc_layout.'__boxes_'.'text']; 
				
				$delay = .3 * (($count+1)/2) . 's';  
				?>
<div class="col-lg-4 text-center gmb-1 gmb-lg-0" data-is-inview="detect">
	<div data-is-inview-fx="fadeInUp" data-transition-delay="<?php echo $delay; ?>">
		<div class="ui-box-thumb">
			<div class="position-relative ui-box-image">
				<img data-test="3" alt=" " width="293" data-is-inview-lazysrc='<?php echo $image_large[0]; ?>' src='<?php echo $image_medium[0]; ?>'/>
			</div>
			<div class="ui-box-content gpx-2">
				<h3 class="section-subtitle"><?php echo $title; ?></h3>
				<p><?php echo $text; ?></p>
			</div>
		</div>
	</div>
</div>
				<?php
				$count++;
			}
			?>
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