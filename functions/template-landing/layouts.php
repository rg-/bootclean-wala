<?php

include('layouts/ui-box-thumb.php'); 
include('layouts/ui-box-icon.php'); 
include('layouts/ui-box-thumb-rows.php');
include('layouts/ui-box-recetas.php');
include('layouts/ui-box-full-cover.php');
include('layouts/ui-box-heading.php');

include('layouts/ui-box-template.php');
include('layouts/ui-box-template-part.php');

add_filter('acf/fields/flexible_content/layout_title', function($title, $field, $layout, $i){

	$check = array(
		'ui-box-thumb',
		'ui-box-icon',
		'ui-box-thumb-rows',
		'ui-box-recetas',
		'ui-box-full-cover',
		'ui-box-heading',
		'ui-box-template',
		'ui-box-template-part',
	);

	if( in_array($layout['name'], $check) ){

		if( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && isset($_POST['value']) ){ 
			// code to handle the AJAX
    	$value = $_POST['value'];  
    }else{
    	// code normal php load
    	$value = !empty($field['value'][$i]) ? $field['value'][$i] : '';
    }
    $t = '';
    if(!empty($value)){ 
    	if( $layout['name']=='ui-box-template' || $layout['name']=='ui-box-template-part' ){
    		if( $layout['name']=='ui-box-template' ){
					$id = $value['field_'.$layout['name'].'__template'];
					$t = get_the_title($id);
					$l = get_edit_post_link($id);
					$title = $title.' -> '.$t . ' <a title="Edit <'.$t.'> Template" class="wpbc-btn-small button" href="'.$l.'"><small>EDIT</small></a>';
				}
				if( $layout['name']=='ui-box-template-part' ){ 
					$title = $title.' -> <small><em>template-parts/theme/</em></small> '.$value['field_'.$layout['name'].'__template'] . '.php';
				}
				
    	}else{
    		$t = $value['field_'.$layout['name'].'__section-title']; 
    		$title = '<small class="wpbc-badge" style="background-color:#6639b7">'.$title.'</small> '.$t;
    	}
    	$section_options = !empty($value['field_'.$layout['name'].'__section_options']) ? $value['field_'.$layout['name'].'__section_options'] : '';

    	$layout_style = !empty($section_options['field_'.$layout['name'].'__section_options_style']) ? $section_options['field_'.$layout['name'].'__section_options_style'] : ''; 
    	
    	//_print_code($value);
    	
    	if(!empty($layout_style)){
				$title = '<small title="Esquema de color" style="background-color:var(--'.$layout_style.');" class="wpbc-badge wpbc-badge-style bg-'.$layout_style.'">'.$layout_styl.'</small> ' . $title;
    	}
    	

    } 
		
	}

	return $title;

}, 10, 4); 

add_action('admin_head',function(){
	$check = array(
		'ui-box-thumb',
		'ui-box-icon',
		'ui-box-thumb-rows',
		'ui-box-recetas',
		'ui-box-full-cover',
		'ui-box-heading',
	);
	?>
<style>
<?php foreach ($check as $value) { ?>
	.acf-tooltip [data-layout="<?php echo $value; ?>"] .dot-badge{
		background-color:#6639b7;
		width: 10px;
		height: 10px;
		display: inline-block;
		border-radius: 100%;
		margin-right: 4px;
		border: 1px solid #fff;
		vertical-align: -1px;
	}
	.wpbc-badge-style{
		position: relative;
		border: 1px solid rgba(1,1,1,.2);
		display: inline-block;
		height: 10px;
		padding: 0;
		width: 10px;
		top: 2px;
		cursor: default;
	}

	[data-layout="template_row"].-collapsed .acf-fc-layout-handle svg path{
		fill:#333333 !important;
	}
<?php } ?>
</style>
	<?php
}); 