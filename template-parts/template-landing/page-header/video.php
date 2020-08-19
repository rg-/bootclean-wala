<?php

/*

	$args passed

*/

// _print_code($args);

if( !empty($args) && !empty($args['video_youtube_id']) ){

$youtube_id = $args['video_youtube_id'];
$embedby =  $args['video_youtube_embedby'];

?>
<div class="embed-responsive embed-responsive-<?php echo $embedby; ?>">
	<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<?php
}