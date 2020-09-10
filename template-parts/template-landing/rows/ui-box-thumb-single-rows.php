<?php
	$acf_fc_layout = $args['acf_fc_layout'];
	$prefix = ''; 
	if(!empty($args['from_builder'])){ $prefix = 'field_'; } 
	$_prefix = $prefix.$acf_fc_layout;  
	$section = WPBC_get_section_row_args($args, $_prefix);  
	if(!empty($section['section_options']['visible'])) return; 
	//_print_code($args); 
?>
<div id="<?php echo $section['section_id']; ?>" class="<?php echo $acf_fc_layout; ?> gpb-2 gpb-lg-6 bg-<?php echo $section['section_options']['style']; ?> text-<?php echo $section['section_options']['style_color']; ?>">

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
						$order_1 = 'col-lg-4 order-1 text-center';
						$order_2 = 'col-lg-8 order-2';
						$content_1 = 'gpy-lg-2 gpr-lg-6 text-center text-lg-left';
					}
					if($count==1){
						$order_1 = 'col-lg-5 order-1 order-lg-2 gpr-lg-6 text-center';
						$order_2 = 'col-lg-7 order-2 order-lg-1';
						$content_1 = 'gpy-lg-2 gpl-lg-6 text-center text-lg-right';
					} 

					?>
<div class="col-md-10 mx-auto" data-is-inview="detect">

	<div class="row ui-box-thumb-rows gpy-2">
		<div class="<?php echo $order_1; ?>">
			<?php 
			$img_hi = "[WPBC_get_attachment_image_src id='".$image."']";
			$img_low = "[WPBC_get_attachment_image_src id='".$image."' size='medium']";
			?>
			<img class="mx-auto" width="318" src="<?php echo $img_hi; ?>" alt=" "/>
		</div>
		<div class="<?php echo $order_2; ?>">
			<div class="<?php echo $content_1; ?>">
				<h2 class="section-subtitle"><?php echo $title; ?></h2>
				<p><?php echo $text; ?></p>
			</div>
		</div>
	</div> 

</div>
<?php
					$count++;
					if($count>1){
						$count = 0;
					}
					
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