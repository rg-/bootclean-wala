<?php

$rows = WPBC_get_field('landing_flexible_rows');
if(!empty($rows)){
	foreach ($rows as $layout) {
		$acf_fc_layout = $layout['acf_fc_layout']; 
		WPBC_get_template_part('template-landing/rows/'.$acf_fc_layout, $layout);  
	}
}