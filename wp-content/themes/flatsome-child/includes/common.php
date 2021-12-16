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

// Add a custom field in the Product data's General tab (for simple products).
add_action( 'woocommerce_product_options_general_product_data', 'add_general_product_data_custom_field' );
function add_general_product_data_custom_field() {
    woocommerce_wp_checkbox( array( // Checkbox.
        'id'            => '_not_ready_to_sell',
        'label'         => __( 'Call to Order', 'woocommerce' ),
        'wrapper_class' => 'show_if_simple',
    ) );
}

// Save custom field value
add_action( 'woocommerce_admin_process_product_object', 'save_general_product_data_custom_field', 10, 1 );
function save_general_product_data_custom_field( $product ) {
    $product->update_meta_data( '_not_ready_to_sell', isset( $_POST['_not_ready_to_sell'] ) ? 'yes' : 'no' );
}

// Make not purchasable, products with '_not_ready_to_sell' meta data set to "yes" (for simple products)
// add_filter( 'woocommerce_is_purchasable', 'filter_woocommerce_set_purchasable', 10, 2);
// function filter_woocommerce_set_purchasable( $purchasable, $product ) {
//     return 'yes' === $product->get_meta( '_not_ready_to_sell' ) && $product->is_type('simple') ? false : $purchasable;
//     return $purchasable;

// }

// Change button text to "Call to Order" for simple products not purchasable.
// add_filter( 'woocommerce_product_add_to_cart_text', 'filter_product_add_to_cart_text', 10, 2 );
// function filter_product_add_to_cart_text( $button_text, $product ) {
//     if ( 'yes' === $product->get_meta( '_not_ready_to_sell' ) && $product->is_type('simple') ) {
//         $button_text =  __( 'Call to Order', 'woocommerce' );
//     }
//     return $button_text;
// }
