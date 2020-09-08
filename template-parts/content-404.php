<?php 
	$post_class = apply_filters('wpbc/filter/post/404/class','gpt-4 gpb-6 col-md-9 mx-auto'); 
?>
<article id="post-404" <?php post_class($post_class); ?>>
	
	<header class="entry-header text-center gmb-4">
		[title_claim type="big"]Oops![/title_claim]
	</header>
	
	<div class="entry-content text-center">
		<p>Lamentamos que la página que estás viendo no exista o haya ocurrido un error. <br>Inténtalo de nuevo más tarde o contáctanos si el problema persiste. </p>
		<p><a class="btn btn-transparent text-primary" href="<?php echo get_bloginfo('url');?>">Ir al Inicio</a></p>
	</div>
	
</article><!-- article#post-404 --> 