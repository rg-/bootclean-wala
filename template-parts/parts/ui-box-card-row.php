<?php

	/*

	$args passed

	Like:

		array(
			
			'image_id' => $image['id'],
			'title' => $title,
			'description' => $text,

			'col_img_class' => $order_1,
			'col_content_class' => $order_2,

			'content_img_class' => $content_1,
			'content_content_class' => $content_2,

		)

	*/

	// _print_code($args);

	$order_1 = $args['col_img_class'];
	$order_2 = $args['col_content_class'];

	$content_1 = $args['content_img_class'];
	$content_2 = $args['content_content_class'];

	$attachment_id = $args['image_id'];
	$title = $args['title'];
	$description = $args['description'];

?>
<div class="ui-box-thumb-rows">

	<div class="row">

		<div class="col-lg-6 <?php echo $order_1; ?>">
			<div class="ui-box-content <?php echo $content_1; ?>">
				<div class="position-relative ui-box-image mx-auto">
					<?php 
						$img_hi = "[WPBC_get_attachment_image_src id='".$attachment_id."']";
						$img_low = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']";
						$img_blured = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='wpbc_blured_image']";
						
						$attrs = ' data-is-inview-lazybackground="'.$img_hi.'" ';
						$attrs .= ' style="background-image: url('.$img_blured.');"';
					?>
					<div class="embed-responsive embed-responsive-16by9">
						<div class="embed-responsive-item image-cover" <?php echo $attrs; ?>>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="col-lg-6 <?php echo $order_2; ?>">
			<div class="ui-box-content <?php echo $content_2; ?>">
				<h3 class="section-subtitle"><?php echo $title; ?></h3>
				<p><?php echo $description; ?></p>
			</div>
		</div>

	</div>

</div>