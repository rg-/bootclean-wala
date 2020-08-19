<div class="container gpb-6">

	<div class="row"> 

		<div class="col-md-9 mx-auto">

			<div class="position-relative gmt-1 gmb-2" data-is-inview="detect">
				<?php
					$attachment_id = 99;
					$img_hi = "[WPBC_get_attachment_image_src id='".$attachment_id."']";
					$img_low = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']";
					$img_mini = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='thumbnail']";
					$img_blured = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='wpbc_blured_image']";
					?>
					<img class="mx-auto w-100" data-is-inview-lazysrc="<?php echo $img_hi; ?>" src="<?php echo $img_blured; ?>" alt=" "/>
			</div>

			<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget mi dui. Vestibulum vehicula dolor metus, eget condimentum massa tristique id. Ut semper luctus nisl vel euismod. Mauris quis orci non metus consequat accumsan in eu purus. Sed ornare vestibulum mauris non mollis. Donec consequat luctus porta. Suspendisse ultrices sem nec ligula imperdiet, vitae faucibus lorem finibus. Nullam tristique ligula ac egestas venenatis. Aliquam vel leo purus.</p>

			<p class="text-center">Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc ultrices libero neque. Ut dapibus ex at felis porta porta eget sit amet nulla. Duis ullamcorper velit vestibulum dignissim facilisis. Aenean ut elit dignissim, elementum erat feugiat, lacinia magna. Integer eu aliquet nisi. </p>

		</div>

	</div>

</div>