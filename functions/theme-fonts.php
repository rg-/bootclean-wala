<?php 


/* Embed Font Awesome */

add_filter('BC_enqueue_scripts__fonts', 'wpbc_child_enqueue_custom_font_awesome'); 

function wpbc_child_enqueue_custom_font_awesome($fonts){ 
    $fonts['fontawesome-all'] = array( 
        'src'=>'css/fontawesome/all.min.css'
    ); 
    return $fonts; 
}


/*

    Custom fonts

*/


add_filter('wpbc/body/class', 'wpbc_child_body_class__fonts', 0, 1);
add_action('wp_head', 'wpbc_child_wp_head__fonts', 0); 

function wpbc_child_body_class__fonts($body_class){
	$body_class .= ' using-theme-fonts';
	return $body_class;
}

function wpbc_child_wp_head__fonts() {
	$theme_uri = CHILD_THEME_URI.'/fonts/theme/';
 	?>
<style>
@font-face {
    font-family: 'Rubik';
    src: url('<?php echo $theme_uri; ?>subset-Rubik-Bold.eot');
    src: url('<?php echo $theme_uri; ?>subset-Rubik-Bold.eot?#iefix') format('embedded-opentype'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Bold.woff2') format('woff2'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Bold.woff') format('woff'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Bold.ttf') format('truetype'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Bold.svg#Rubik-Bold') format('svg');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'Rubik';
    src: url('<?php echo $theme_uri; ?>subset-Rubik-Medium.eot');
    src: url('<?php echo $theme_uri; ?>subset-Rubik-Medium.eot?#iefix') format('embedded-opentype'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Medium.woff2') format('woff2'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Medium.woff') format('woff'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Medium.ttf') format('truetype'),
        url('<?php echo $theme_uri; ?>subset-Rubik-Medium.svg#Rubik-Medium') format('svg');
    font-weight: 500;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'Rubik Mono One';
    src: url('<?php echo $theme_uri; ?>subset-RubikMonoOne-Regular.eot');
    src: url('<?php echo $theme_uri; ?>subset-RubikMonoOne-Regular.eot?#iefix') format('embedded-opentype'),
        url('<?php echo $theme_uri; ?>subset-RubikMonoOne-Regular.woff2') format('woff2'),
        url('<?php echo $theme_uri; ?>subset-RubikMonoOne-Regular.woff') format('woff'),
        url('<?php echo $theme_uri; ?>subset-RubikMonoOne-Regular.ttf') format('truetype'),
        url('<?php echo $theme_uri; ?>subset-RubikMonoOne-Regular.svg#RubikMonoOne-Regular') format('svg');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'Roboto Mono';
    src: url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.eot');
    src: url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.eot?#iefix') format('embedded-opentype'),
        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.woff2') format('woff2'),
        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.woff') format('woff'),
        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.ttf') format('truetype'),
        url('<?php echo $theme_uri; ?>subset-RobotoMono-Regular.svg#RobotoMono-Regular') format('svg');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'Roboto';
    src: url('<?php echo $theme_uri; ?>subset-Roboto-Regular.eot');
    src: url('<?php echo $theme_uri; ?>subset-Roboto-Regular.eot?#iefix') format('embedded-opentype'),
        url('<?php echo $theme_uri; ?>subset-Roboto-Regular.woff2') format('woff2'),
        url('<?php echo $theme_uri; ?>subset-Roboto-Regular.woff') format('woff'),
        url('<?php echo $theme_uri; ?>subset-Roboto-Regular.ttf') format('truetype'),
        url('<?php echo $theme_uri; ?>subset-Roboto-Regular.svg#Roboto-Regular') format('svg');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}
.font-rubik{
    font-family: 'Rubik';
}
.font-rubik-medium{
    font-family: 'Rubik';
    font-weight: 500;
}
.font-rubik-mono{
    font-family: 'Rubik Mono One';
}
.font-roboto-mono{
    font-family: 'Roboto Mono';
}
.font-roboto{
    font-family: 'Roboto';
}

body.using-theme-fonts{
	font-family: 'Roboto Mono'; 
}

body.using-theme-fonts .section-title,
body.using-theme-fonts .entry-title{
	font-family: 'Rubik Mono One';
}

body.using-theme-fonts .section-subtitle{
    font-family: 'Rubik';
}

</style>
 	<?php
}   