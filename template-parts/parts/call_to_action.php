<?php
// _print_code($args);
 
$call_to_action = $args['call_to_action'];
$prefix = $args['prefix'];

$call = WPBC_get_acf_call_to_action_group($call_to_action, $prefix, false);  
if(!empty($call)){

?>
<div class="row gpt-1 gpt-md-3" data-is-inview="detect">
	<div class="col-md-9 mx-auto">
		<div data-is-inview-once data-is-inview-fx="fadeInUp" data-transition-delay=".6s">
			<p class="text-center m-0"><?php echo $call; ?></p>
		</div>
	</div>
</div>

<?php } ?>