<?php

// Add theme support
add_theme_support( 'responsive-embeds' );

// Remove theme support
add_action('after_setup_theme', 'child_WPBC_remove_theme_support', 100);
function child_WPBC_remove_theme_support() {
   remove_theme_support('post-formats');
}
