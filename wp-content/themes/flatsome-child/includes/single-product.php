<?php
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);

function woo_remove_product_tabs($tabs)
{
    unset($tabs['pwb_tab']);          // Remove the description tab
    return $tabs;
}

add_action('woocommerce_after_single_product', 'add_related_blogs_func');

function add_related_blogs_func()
{
    global $product;

    $blogs = get_field('related_blogs', $product->get_id());

    echo do_shortcode('[blog_posts style="normal" columns="3" columns__md="1" ids="959,913,905,949" image_height="56.25%"]');
}
