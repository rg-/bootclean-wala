<?php

/*

	$args passed

*/ 

if(!empty($args['template_id'])){
	echo do_shortcode('[WPBC_get_template id="'.$args['template_id'].'"]');
}