<?php
add_action('init','add_lazyload_func');
function add_lazyload_func(){
    if(!is_admin()):
        require_once 'simple_html_dom.php';
    endif;
}
//add_filter('the_content', 'cm_add_image_placeholders');
function cm_add_image_placeholders($content)
{   
    if(is_admin()):
        return $content;
    else:
        if( empty( get_the_content() ) ) return $content;
        $html = str_get_html($content, '', '', '', false);
        $placeholder = 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
        if ($html) :
            foreach ($html->find('img') as $element) {
                if (strpos($element->class, 'lazy') === false) :
                    $element->class = 'lazy ' . $element->class;
                    $element->srcset = '';
                    $element->sizes = '';
                    $element->{'data-src'} = $element->src;
                    $element->src = $placeholder;
                endif;
            }
            return $html;
        endif;
    endif;
    return $content;
}
// function breadcrum(){
//     echo "<div class='container'>";
//     flatsome_breadcrumb();
//     echo "</div>";
// }
// add_action('flatsome_before_blog','breadcrum');
// To change add to cart text on single product page
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');
function woocommerce_custom_single_add_to_cart_text()
{
    return __('Đặt Hàng Ngay', 'woocommerce');
}

// To change add to cart text on product archives(Collection) page
add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text');
function woocommerce_custom_product_add_to_cart_text()
{
    return __('Đặt Hàng Ngay', 'woocommerce');
}

// Add a custom field in the Product data's General tab (for simple products).
add_action('woocommerce_product_options_general_product_data', 'add_general_product_data_custom_field');
function add_general_product_data_custom_field()
{
    woocommerce_wp_checkbox(array( // Checkbox.
        'id'            => '_not_ready_to_sell',
        'label'         => __('Call to Order', 'woocommerce'),
        'wrapper_class' => 'show_if_simple',
    ));
}

// Save custom field value
add_action('woocommerce_admin_process_product_object', 'save_general_product_data_custom_field', 10, 1);
function save_general_product_data_custom_field($product)
{
    $product->update_meta_data('_not_ready_to_sell', isset($_POST['_not_ready_to_sell']) ? 'yes' : 'no');
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


add_filter('woocommerce_sale_flash', 'woocommerce_custom_sale_text', 10, 3);
function woocommerce_custom_sale_text($text, $post, $_product)
{
    $sale_text = get_field('sale_text',$post->ID);
    if($sale_text):
        $text = '<div class="callout badge badge-circle"><div class="badge-inner secondary on-sale"><span class="onsale">'.$sale_text.'</span></div></div>';
    endif;
    return $text;
}

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10);

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'add_class_to_thumbs', 10, 2 );
function add_class_to_thumbs( $html, $attachment_id ) {
	if ( get_post_thumbnail_id() === intval( $attachment_id ) ) {
        ob_start();
        do_action('flatsome_sale_flash');
        $flatsome_sale_flash = ob_get_clean();
        $html = str_replace('</a></div>','</a>'.$flatsome_sale_flash.'</div>',$html);
	}

	return $html;
}
