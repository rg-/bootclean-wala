<?php 
	$acf_fc_layout = $args['acf_fc_layout'];
	$prefix = ''; 
	if(!empty($args['from_builder'])){ $prefix = 'field_'; } 
	$_prefix = $prefix.$acf_fc_layout;  
	$section = WPBC_get_section_row_args($args, $_prefix);  
	if(!empty($section['section_options']['visible'])) return; 
	
	$template = $args[$prefix.$acf_fc_layout.'__template']; 
?>

<div id="ui-box-template-part-<?php echo $template; ?>">

	<?php 
	echo do_shortcode('[WPBC_get_template_theme name="'.$template.'" /]'); 
	?>
	
</div>