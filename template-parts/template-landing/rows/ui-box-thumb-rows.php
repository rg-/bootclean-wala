<?php
	$acf_fc_layout = $args['acf_fc_layout'];
	$prefix = ''; 
	if(!empty($args['from_builder'])){ $prefix = 'field_'; } 
	$_prefix = $prefix.$acf_fc_layout;  
	$section = WPBC_get_section_row_args($args, $_prefix);  
	if(!empty($section['section_options']['visible'])) return; 
	//_print_code($args); 
?>
<div id="<?php echo $section['section_id']; ?>" class="<?php echo $acf_fc_layout; ?> gpy-2 gpy-md-4 bg-<?php echo $section['section_options']['style']; ?> text-<?php echo $section['section_options']['style_color']; ?>">

	<div class="container">

		<?php if(!empty( $section['section_title'] )){ ?>
			<div class="row">
				<div class="col-md-11 mx-auto" data-is-inview="detect">
					<div data-is-inview-once data-is-inview-fx="fadeInUp" data-transition-delay=".4s">
						<h2 class="section-title text-center"><?php echo $section['section_title']; ?></h2>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php
		$section_boxes = $args[$prefix.$acf_fc_layout.'__boxes'];  
		
		if(!empty($section_boxes)){ 
			$count = 0;
		?>
		<div class="row">
			<?php foreach ($section_boxes as $key => $value) {
				//_print_code($value);
				$image = $value[$prefix.$acf_fc_layout.'__boxes_'.'image']; 
				if(empty($prefix)){
					$image = $image['id'];
				} 
					$image_large = wp_get_attachment_image_src($image, 'large');
					$image_medium = wp_get_attachment_image_src($image, 'medium'); 
					$image_blured = wp_get_attachment_image_src($image, 'wpbc_blured_image'); 

				if(!empty($image)){
				$group = $value[$prefix.$acf_fc_layout.'__boxes_'.'group'];
					$title = $group[$prefix.$acf_fc_layout.'__boxes_'.'title'];
					$text = $group[$prefix.$acf_fc_layout.'__boxes_'.'text']; 

					if($count==0){
						$order_1 = 'order-1 text-right';
						$order_2 = 'order-2 text-center text-lg-left ';
						$content_1 = 'gpy-1 gp-lg-3';
						$content_2 = 'gpy-1 gpy-md-3 gpr-lg-4';
					}
					if($count==1){
						$order_1 = 'order-1 order-lg-2 text-right';
						$order_2 = 'order-2 order-lg-1 text-center text-lg-right ';
						$content_1 = 'gpy-1 gpy-lg-3 gpr-lg-6 gpl-lg-0';
						$content_2 = 'gpy-1 gpy-md-3 gpl-lg-4 gpr-lg-3';
					}

					$shortcode = $value[$prefix.$acf_fc_layout.'__boxes_'.'shortcode']; 

					?>
<div class="col-11 mx-auto gpt-1" data-is-inview="detect">

	<?php

	$part_args = array(

		'shortcode' => $shortcode,
		
		'image_id' => $image,
		'title' => $title,
		'description' => $text,

		'col_img_class' => $order_1,
		'col_content_class' => $order_2,

		'content_img_class' => $content_1,
		'content_content_class' => $content_2,

	);

	WPBC_get_template_part('parts/ui-box-card-row', $part_args);

	?> 

</div>
<?php
					if($count==1){
						$count = 0;
					}
					$count++;
					}
			} ?>

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