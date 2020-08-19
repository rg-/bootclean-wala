<?php
	$acf_fc_layout = $args['acf_fc_layout'];
	$prefix = ''; 
	if(!empty($args['from_builder'])){ $prefix = 'field_'; } 
	$_prefix = $prefix.$acf_fc_layout;  
	$section = WPBC_get_section_row_args($args, $_prefix);  
	if(!empty($section['section_options']['visible'])) return; 
	//_print_code($args); 
?>

<div id="<?php echo $section['section_id']; ?>" class="bg-<?php echo $section['section_options']['style']; ?> text-<?php echo $section['section_options']['style_color']; ?>">

	<?php
		
		$content = $args[$_prefix.'__content']; 

		$content_options = $args[$_prefix.'__content_options']; 
		$content_options_side = $content_options[$_prefix.'__content_options_side'];

		$content_side = $content_options_side;
		if($content_side == 'right'){
			$content_class = 'gpx-2 gpr-lg-4 gpl-lg-5 gpt-4 gpb-4 text-center text-md-left';
		}
		if($content_side == 'left'){
			$content_class = 'gpx-2 gpr-lg-5 gpl-lg-4 gpt-4 gpb-4 text-center text-md-right';
		}
	?>

	<div class="wpbc-full-aside-cols content-<?php echo $content_side; ?> break-md">

		<div class="col-md-6 p-0 col-fullside">

			<?php
			$content_images = $args[$_prefix.'__content_images']; 
			if(!empty($content_images)){

				$slick = array(
					'dots' => false,
					'arrows' => false, 
					'infinite' => true,
					'speed' => 600,
					'autoplay' => true,
					'autoplaySpeed' => 6200, 
				);
				$slick = json_encode($slick); 

			?>
			
			<div class="embed-responsive embed-responsive-21by9">
				<div class="embed-responsive-item">

					<div class="theme-slick-slider type-background" data-slick='<?php echo $slick; ?>'>
						<?php foreach($content_images as $id){  
							?>
							<div class="item"> 
									<?php 
									$img_hi = "[WPBC_get_attachment_image_src id='".$id."']";
									$img_low = "[WPBC_get_attachment_image_src id='".$id."' size='medium']";
									?>
									<div class="item-container image-cover" data-lazybackground-src="<?php echo $img_hi; ?>" style="background-image: url(<?php echo $img_low; ?>);">
									</div>
							</div>
							<?php } ?>
					</div>
	 
				</div>
			</div>

			<?php } ?>

		</div>

		<div class="container">
		  <div class="row">
		    <div class="col-md-6 col-content">
		    	
		    	<div class="<?php echo $content_class; ?>" data-is-inview="detect">

		    		<?php if(!empty( $section['section_title'] )){ ?>
			    		<div data-is-inview-fx="fadeInUp" data-transition-delay=".4s">
								<h2 class="section-title gmb-2"><?php echo $section['section_title']; ?></h2>
							</div>
						<?php } ?>

						<?php echo $content; ?>

		    	</div>

		    </div>
		  </div>
		</div>

	</div>

</div>