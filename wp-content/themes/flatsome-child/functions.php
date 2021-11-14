<?php
// Add custom Theme Functions hereadd_filter( 'upload_mimes', 'my_myme_types', 1, 1 );
add_filter( 'upload_mimes', 'my_myme_types', 1, 1 );
add_filter( 'mine_types', 'my_myme_types', 1, 1 );
function my_myme_types( $mime_types ) {
    $mime_types['webp'] = 'image/webp';
    return $mime_types;
}
//ADD SCRIPTS
function add_theme_scripts()
{
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/sources/build/css/main.css', array(), '1.0', 'all');
    $global_params = array(
        'themes_url' => get_template_directory_uri(),
        'ajaxurl' => admin_url( 'admin-ajax.php')
    );
    wp_register_script('script', get_stylesheet_directory_uri() . '/sources/build/js/main.js', array('jquery'), 1.1, true);
    wp_localize_script('script', 'global_params', $global_params);
    wp_enqueue_script('script');
}

add_action('wp_enqueue_scripts', 'add_theme_scripts');
require_once( get_stylesheet_directory() . '/includes/single-product.php' );