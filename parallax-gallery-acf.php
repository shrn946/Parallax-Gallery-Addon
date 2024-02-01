<?php
/*
Plugin Name: Parallax Gallery Addon. [ParallaxGalleryACF]
Description: Build an impressive Parallax Gallery utilizing the ACF PRO gallery field.Generate a gallery field named "acf_gallery" utilizing ACF Pro, and exhibit the gallery using this add-on.

Version: 1.0
Author: Hassan Naqvi
*/

// Enqueue scripts and styles
function parallax_gallery_acf_enqueue_scripts() {
    // Enqueue script
    wp_enqueue_script('parallax-gallery-acf-script', plugins_url('script.js', __FILE__), array('jquery'), '1.0', true);

    // Enqueue style
    wp_enqueue_style('parallax-gallery-acf-style', plugins_url('style.css', __FILE__), array(), '1.0');
}
add_action('wp_enqueue_scripts', 'parallax_gallery_acf_enqueue_scripts');



// Add this code to your theme's functions.php file
function display_acf_gallery_images_shortcode() {

    // Check if Elementor is active and in the editor
    if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
        return '';
    }

    // Get the ACF Gallery field value
    $gallery_images = get_field('acf_gallery');

    // Check if the field has values
    if ($gallery_images) {
        $output = '<main class="gallery">';
        $output .= '<div class="gallery-track">';

        // Loop through each image in the gallery
        foreach ($gallery_images as $image) {
            $output .= '<div class="card">';
            $output .= '<div class="card-image-wrapper">';
            $output .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '">';
            $output .= '</div>';
            $output .= '</div>';
        }

        $output .= '</div>';
        $output .= '</main>';
        
        return $output;
    }

    // If the gallery is empty, return an empty string
    return '';
}

// Register the shortcode
function register_parallax_gallery_acf_shortcode() {
    add_shortcode('ParallaxGalleryACF', 'display_acf_gallery_images_shortcode');
}
add_action('init', 'register_parallax_gallery_acf_shortcode');
