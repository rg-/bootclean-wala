<?php
/*

	$args passed
	$args['acf_field'] passed from temmplate landing functions 

	Used like:

		$args['acf_field'] = the array containing the ACF field group holing this template fields
	
		So: $acf_field = $args['acf_field'];

*/

$acf_field = $args['acf_field'];   
$page_header_type = $acf_field['page_header_type']; 
$page_header_args = !empty($acf_field['page_header_'.$page_header_type]) ? $acf_field['page_header_'.$page_header_type] : ''; 

if($page_header_type=='none') return;

//_print_code($acf_field); 
?>
<div id="inicio" class="page-header gpb-2 gpb-md-0">
	<?php do_action('wpbc/template-landing/page-header/before', $page_header_type, $page_header_args); ?>
	<?php
		WPBC_get_template_part('template-landing/page-header/'.$page_header_type, $page_header_args);
	?>
	<?php do_action('wpbc/template-landing/page-header/after', $page_header_type, $page_header_args); ?>
</div>