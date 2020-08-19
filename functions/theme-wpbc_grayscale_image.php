<?php

add_action('after_setup_theme','WPBC_after_setup_theme__wpbc_grayscale_image');
function WPBC_after_setup_theme__wpbc_grayscale_image() {
  add_image_size('wpbc_grayscale_image', 100, false, false);
  add_image_size('wpbc_blured_image', 101, false, false);
} 

/* Generate a grayscale version */
add_filter('wp_generate_attachment_metadata','WPBC_wp_generate_attachment_metadata__wpbc_grayscale_image');
function WPBC_wp_generate_attachment_metadata__wpbc_grayscale_image($meta) {
  $file = wp_upload_dir();
  $file = trailingslashit($file['path']).$meta['sizes']['wpbc_grayscale_image']['file'];
  list($orig_w, $orig_h, $orig_type) = @getimagesize($file);
  $image = wp_load_image($file);
  imagefilter($image, IMG_FILTER_GRAYSCALE);
  switch ($orig_type) {
    case IMAGETYPE_GIF:
        imagegif( $image, $file );
        break;
    case IMAGETYPE_PNG:
        imagepng( $image, $file );
        break;
    case IMAGETYPE_JPEG:
        imagejpeg( $image, $file );
        break;
  }
  return $meta;
}

/* Generate a blured version "wpbc_blured_image" */

add_filter('wp_generate_attachment_metadata','WPBC_wp_generate_attachment_metadata__wpbc_blured_image');
function WPBC_wp_generate_attachment_metadata__wpbc_blured_image($meta) {
  $file = wp_upload_dir();
  $file = trailingslashit($file['path']).$meta['sizes']['wpbc_blured_image']['file'];
  list($orig_w, $orig_h, $orig_type) = @getimagesize($file);
  $image = wp_load_image($file);
  imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR, 999);
  imagefilter($image, IMG_FILTER_SMOOTH,99);
  switch ($orig_type) {
    case IMAGETYPE_GIF:
        imagegif( $image, $file );
        break;
    case IMAGETYPE_PNG:
        imagepng( $image, $file );
        break;
    case IMAGETYPE_JPEG:
        imagejpeg( $image, $file );
        break;
  }
  return $meta;
}