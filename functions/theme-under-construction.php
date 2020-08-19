<?php


// Filter args used
add_filter('wpbc/filter/mainteneance_mode/args',function($args){
	$args['title'] = get_bloginfo('title');
	$args['html'] = '';
	return $args;
},10,1);

// output body html
add_action('wpbc/mainteneance_mode/body',function(){
	?>
<table width="100%" border="0">
	<tr>
		<td>
			<img width="200" src="<?php echo get_stylesheet_directory_uri(); ?>/images/theme/bootclean-logo-color-@2.png" alt="<?php echo get_bloginfo('title'); ?>" />
		</td>
	</tr>
</table>
	<?php
});

// add some styles
add_action('wpbc/mainteneance_mode/head',function(){
?>
<style>
	html{
		height: 100%;
	}
	body{
		background-color: #fef;
		height: 100%;
	}
	table{
		height: 100%;
	}
	tr{
		height: 100%
	}
	td{
		height: 100%;
		text-align: center;
	}
</style>
<?php
});