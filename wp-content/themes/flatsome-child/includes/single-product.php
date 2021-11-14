<?php 
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['pwb_tab'] );          // Remove the description tab
    return $tabs;
}