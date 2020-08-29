<?php

/*

	$args passed

*/ 
$default_sub_type = $args['default_sub_type'];
$gallery_images = $args['gallery_images'];
$content =  $args['content'];
$call_to_action =  $args['call_to_action']; 
 
$slick = array(
	'dots' => true,
	'arrows' => true, 
	'infinite' => true,
	'speed' => 600,
	'autoplay' => true,
	'autoplaySpeed' => 6200, 
);
$slick = json_encode($slick); 

$slick_heights = array(
	'xs' => array(
		'default' => '100wh',
		'max' => '220px'
	),
	'sm' => array(
		'default' => '100wh',
		'max' => '420px'
	),
);
$slick_heights = json_encode($slick_heights); 
?>
<?php if(!empty($gallery_images) && $default_sub_type == 'default' ) {?>
<div class="theme-slick-slider" data-slick='<?php echo $slick; ?>' data-breakpoint-height='<?php echo $slick_heights; ?>' data-disable-affix-offset="true">
	<?php foreach($gallery_images as $k=>$v){  
		?>
		<div class="item"> 
				<?php
				$attachment_id = $v['id']; 
				$img_hi = "[WPBC_get_attachment_image_src id='".$attachment_id."']";
				$img_low = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']";
				?>
				<div class="item-container image-cover" data-lazybackground-src="<?php echo $img_hi; ?>" style="background-image: url(<?php echo $img_low; ?>);">
				</div>
		</div>
		<?php } ?>
</div>
<?php } ?>

<div class="page-header-overlay sub_type-<?php echo $default_sub_type; ?>" data-is-inview="detect">
	<div class="container">
		<div class="row">
			<div class="col-md-9 mx-auto gpt-2 gpt-sm-0">
				<div data-is-inview-once data-is-inview-fx="fadeInUp" data-transition-delay=".3s">
					[title_claim]<?php echo $content; ?>[/title_claim] 
				</div>
				<div class="gmt-1" data-is-inview-once data-is-inview-fx="fadeInUp" data-transition-delay=".9s">
					<?php

					if( !empty($call_to_action) && $call_to_action['call_to_action_type']=='html' ){
						?><div class="gmb-2"><?php
					}
					WPBC_get_acf_call_to_action_group($call_to_action);
					if($call_to_action['call_to_action_type']=='html'){
						?></div><?php
					}
					
					?>
				</div>
			</div>
		</div>
	</div>
</div>