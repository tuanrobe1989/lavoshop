<?php
//add_action('init', 'add_lazyload_func');
function add_lazyload_func()
{
    if (!is_admin()) :
        require_once 'simple_html_dom.php';
    endif;
}
//add_filter('the_content', 'cm_add_image_placeholders');
function cm_add_image_placeholders($content)
{
    if (is_admin()) :
        return $content;
    else :
        if (empty(get_the_content())) return $content;
        $html = str_get_html($content, '', '', '', false);
        $placeholder = 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
        if ($html) :
            foreach ($html->find('img') as $element) {
                if (strpos($element->class, 'lazyload') === false) :
                    $element->class = 'lazyload ' . $element->class;
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
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text', 99);
function woocommerce_custom_single_add_to_cart_text()
{
    global $product;
    $name = __('Đặt Hàng Ngay', 'woocommerce');
    if (!$product->get_price()) $name = __('Liên Hệ: 18007019', 'woocommerce');
    return $name;
}

// To change add to cart text on product archives(Collection) page
add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text', 99);
function woocommerce_custom_product_add_to_cart_text()
{
    global $product;
    $name = __('Đặt Hàng Ngay', 'woocommerce');
    if (!$product->get_price()) $name = __('Liên Hệ: 18007019', 'woocommerce');
    return $name;
}

add_action('woocommerce_single_product_summary', 'woocommerce_after_add_to_cart_form_func', 40);
function woocommerce_after_add_to_cart_form_func()
{
    global $product;
    if (!$product->get_price()) echo '<a href=""  class="single_add_to_cart_button button button__contact">' . $name = __('Liên Hệ Đặt Hàng: 18007019', 'woocommerce') . '</a>';
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
    $sale_text = get_field('sale_text', $post->ID);
    if ($sale_text) :
        $text = '<div class="callout badge badge-circle"><div class="badge-inner secondary on-sale"><span class="onsale">' . $sale_text . '</span></div></div>';
    endif;
    return $text;
}

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10);

add_filter('woocommerce_single_product_image_thumbnail_html', 'add_class_to_thumbs', 10, 2);
function add_class_to_thumbs($html, $attachment_id)
{
    if (get_post_thumbnail_id() === intval($attachment_id)) {
        ob_start();
        do_action('flatsome_sale_flash');
        $flatsome_sale_flash = ob_get_clean();
        $html = str_replace('</a></div>', '</a>' . $flatsome_sale_flash . '</div>', $html);
    }

    return $html;
}

add_action('woocommerce_product_afterthumb', 'woocommerce_product_afterthumb_func');
add_action('woocommerce_product_thumbnails', 'woocommerce_product_afterthumb_func', 90);
function woocommerce_product_afterthumb_func()
{
    global $product;
    $sale_image = get_field('sale_image', $product->get_id());
    $sale_link = get_field('sale_link', $product->get_id());
    if (!$sale_link) $sale_link = get_permalink($product->get_id());
?>
    <a href="<?php echo $sale_link ?>">
        <figure class="single-product__after_thumb">
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?php echo $sale_image['url'] ?>" title="<?php echo $sale_image['title'] ?>" alt="<?php echo $sale_image['alt'] ?>" class="single-product__after_thumb--img lazyload" />
        </figure>
    </a>
    <?php
}

add_action('after_setup_theme', 'custom_aftersetup_theme', 0);
function custom_aftersetup_theme()
{
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10);
    remove_action('woocommerce_load_shipping_methods', 'action_woocommerce_load_shipping_methods', 10, 1);
}

add_action('woocommerce_shop_loop_item_salecover', 'woocommerce_show_product_loop_sale_flash', 10);





function displaying_cart_items_weight($item_data, $cart_item)
{
    // Product quantity
    $product_qty = $cart_item['quantity'] * 1;

    // Calculate total item weight
    $item_weight = ($cart_item['data']->get_weight() * 1) * $product_qty;

    $item_data[] = array(
        'key'       => __('Weight', 'woocommerce'),
        'value'     => $item_weight,
        'display'   => $item_weight . ' ' . get_option('woocommerce_weight_unit')
    );

    return $item_data;
}
add_filter('woocommerce_get_item_data', 'displaying_cart_items_weight', 10, 2);

function wcw_cart()
{
    global $woocommerce;
    if (WC()->cart->needs_shipping()) : ?>
        <tr class="shipping">
            <th><?php _e('Weight', 'woocommerce'); ?></th>
            <td><span class="label"><?php echo $woocommerce->cart->cart_contents_weight . ' ' . get_option('woocommerce_weight_unit'); ?></span></td>
        </tr>
        <?php endif;
}
add_action('woocommerce_cart_totals_after_order_total', 'wcw_cart');
add_action('woocommerce_review_order_after_order_total', 'wcw_cart');




function hwn_add_thankyou_custom_text_for_orders_paid_with_cash_on_delivery($order_id)
{
    $order = wc_get_order($order_id);
    $status = $order->get_status();
    switch ($status):
        case 'cancelled':
        ?>
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/cancel-checkout.png" class="lazyload" />
        <?php
            break;
        case 'processing':
        ?>
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/thank-you.jpg" class="lazyload" />
        <?php
            break;
        case 'completed':
        ?>
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/thank-you.jpg" class="lazyload" />
            <?php
            break;
    endswitch;
    $payment_method = $order->get_payment_method();

    switch ($payment_method):
        case 'vnpay':
            if ($status == 'processing' || $status == 'completed') :
            ?>
                <div class="woocommerce-message message-wrapper bormess" role="alert">
                    <div class="message-container container success-color medium-text-center">
                        <i class="icon-checkmark"></i> <?php _e('Đã thanh toán', LAVOSHOP) ?>
                    </div>
                </div>
            <?php
            else :
            ?>
                <div class="woocommerce-message message-wrapper bormess" role="alert">
                    <div class="message-container container alert-color medium-text-center">
                        <i class="icon-checkmark"></i> <?php _e('Đã hủy thanh toán', LAVOSHOP) ?>
                    </div>
                </div>
    <?php
            endif;
            break;
    endswitch;
}
add_action('woocommerce_thankyou', 'hwn_add_thankyou_custom_text_for_orders_paid_with_cash_on_delivery', 1);
add_action('woocommerce_thankyou', function () {
    echo '<div class="checkout__notification">';
}, 10);
add_action('woocommerce_thankyou', function () {
    echo '</div>';
}, 11);

add_action('wp_footer', 'add_promotion_form_func');
function add_promotion_form_func()
{
    $str = '';
    if ($_COOKIE['promoform'] != 1 && !is_cart() && !is_checkout()) :
        $str = 'auto_open="true" auto_timer="3000" auto_show="always"';
    endif;
    if (is_front_page()) :
        echo  do_shortcode('[lightbox id="promoform" ' . $str . ' class="promoform" width="600px" padding="20px"][contact-form-7 id="1631" title="Form Khuyến Mãi"][/lightbox]');
    endif;
}

add_filter('text_fly', 'text_fly_func');
function text_fly_func()
{
    return 'GHTK Giao Nhanh';
}
add_filter('text_xteam', 'text_xteam_func');
function text_xteam_func()
{
    return 'Giao nhanh xFast 2h';
}
add_filter('text_road', 'text_road_func');
function text_road_func()
{
    return 'GHTK Tiêu chuẩn';
}

function woocom_extra_register_fields()
{ ?>

    <p class="form-row form-row-first">

        <label for="reg_billing_first_name"><?php _e('First name', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
    </p>

    <p class="form-row form-row-last">

        <label for="reg_billing_last_name"><?php _e('Last name', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name']); ?>" />
    </p>

    <p class="form-row form-row-wide">
        <label for="reg_billing_phone"><?php _e('Phone', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if (!empty($_POST['billing_phone'])) esc_attr_e($_POST['billing_phone']); ?>" />
    </p>

<?php

}

add_action('woocommerce_register_form_start', 'woocom_extra_register_fields');

function woocom_validate_extra_register_fields($username, $email, $validation_errors)

{
    if (isset($_POST['billing_phone']) && empty($_POST['billing_phone'])) {
        $validation_errors->add('billing_mobile_number_error', __('Mobile number cannot be left blank.', 'woocommerce'));
    }

    if (isset($_POST['billing_phone']) && strlen($_POST['billing_phone']) < 9) {
        $validation_errors->add('billing_mobile_number_error', __('Phone number length should not be less than 9 digit', 'woocommerce'));
    }

    if (isset($_POST['billing_phone'])) {
        $hasPhoneNumber = get_users('meta_value=' . $_POST['billing_phone']);
        if (!empty($hasPhoneNumber)) {
            $validation_errors->add('billing_phone_error', __('Mobile number is already used!.', 'woocommerce'));
        }
    }


    if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {

        $validation_errors->add('billing_first_name_error', __('First Name is required!', 'woocommerce'));
    }

    if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {

        $validation_errors->add('billing_last_name_error', __('Last Name is required!', 'woocommerce'));
    }

    return $validation_errors;
}

add_action('woocommerce_register_post', 'woocom_validate_extra_register_fields', 20, 3);


///

//  Allow login via phone number and email

///

function njengah_loginWithPhoneNumber($user, $username, $password)
{

    //  Try logging in via their billing phone number

    if (is_numeric($username)) {

        //  The passed username is numeric - that's a start

        //  Now let's grab all matching users with the same phone number:

        $matchingUsers = get_users(array(

            'meta_key'     => 'billing_phone',

            'meta_value'   => $username,

            'meta_compare' => 'LIKE'

        ));

        //  Let's save time and assume there's only one.

        if (is_array($matchingUsers) && !empty($matchingUsers)) {

            $username = $matchingUsers[0]->user_login;
        }
    } elseif (is_email($username)) {

        //  The passed username is email- that's a start

        //  Now let's grab all matching users with the same email:

        $matchingUsers = get_user_by("email", $username);

        //  Let's save time and assume there's only one.

        if (isset($matchingUsers->user_login)) {

            $username = $matchingUsers->user_login;
        }
    }

    return wp_authenticate_username_password(null, $username, $password);
}

add_filter('authenticate', 'njengah_loginWithPhoneNumber', 20, 3);

function header_cover_func(){
    echo do_shortcode('[block id="topbar"]');
}
add_action('wp_head','header_cover_func');

