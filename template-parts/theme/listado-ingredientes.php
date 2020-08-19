<div class="container gpy-3">
	<div class="row">
	<?php 
	  $args = array(
			'post_status' => 'publish',
			'post_type' => 'ingrediente',
			'posts_per_page' => -1,
			'orderby' => 'name',
			'order'=>'ASC',
			);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {

			while ( $loop->have_posts() ){

				$loop->the_post(); 

				$ingrediente_image = WPBC_get_field('woo_ingrediente_image', get_the_ID() ); 

				$img_pre = get_stylesheet_directory_uri().'/images/px-trans.png';

				if($ingrediente_image){
					$attachment_id = $ingrediente_image['id'];
					$img_hi = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."']");
					$img_low = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']");
					$img_mini = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='thumbnail']");
					$img_blured = do_shortcode("[WPBC_get_attachment_image_src id='".$attachment_id."' size='wpbc_blured_image']");
				}else{
					$img_low = get_stylesheet_directory_uri().'/images/px-trans.png';
				}

				$get_edit_post_link = get_edit_post_link(get_the_ID());
				?>
				<div data-is-inview="detect" class="col-md-2 text-center gmb-1">
					<a title="Editar > <?php echo get_the_title(); ?>" href="<?php echo $get_edit_post_link; ?>" class="d-block">
						<div class="ui-ingrediente-thumb mx-auto">
							<img src="<?php echo $img_pre; ?>" data-is-inview-lazysrc="<?php echo $img_low; ?>" alt=" "/>
						</div>
						<br><?php the_title();?>
					</a>
				</div>
				<?php

			} 

		}

		wp_reset_postdata();

	?>
	</div>
</div>