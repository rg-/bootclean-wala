<?php	
	$row = get_row(); 
	$row['from_builder'] = true;
	WPBC_get_template_part('template-landing/rows/ui-box-recetas', $row); 
?>