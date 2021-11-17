<?php 
// function breadcrum(){
//     echo "<div class='container'>";
//     flatsome_breadcrumb();
//     echo "</div>";
// }
// add_action('flatsome_before_blog','breadcrum');
// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Đặt Hàng Ngay', 'woocommerce' ); 
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Đặt Hàng Ngay', 'woocommerce' );
}