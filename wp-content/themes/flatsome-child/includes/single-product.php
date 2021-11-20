<?php
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);

function woo_remove_product_tabs($tabs)
{
    unset($tabs['pwb_tab']);          // Remove the description tab
    return $tabs;
}

//Remove related_products of WooCoomer
add_action('wp_head', 'remove_my_action');
function remove_my_action()
{
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}


add_action('woocommerce_after_single_product_summary', 'add_related_products_func', 30);

function add_related_products_func()
{
    global $product;

    $related_products = get_field('related_products', $product->get_id());

    if ($related_products) :
        $list_id_products = implode(', ', $related_products);
?>
        <div class="product-section">

            <?php
            echo do_shortcode('
            [row]

            [col span__sm="12" class="related related-products-wrapper product-section"]
            
            [title text="SẢN PHẨM LIÊN QUAN" class="product-section-title container-width product-section-title-related pt-half pb-half uppercase"]
            
            [ux_products ids="' . $list_id_products . '"]
            
            
            [/col]
            
            [/row]
                
            ');

            ?>

        </div>

    <?php
    endif;
}

add_action('woocommerce_after_single_product_summary', 'add_related_blogs_func', 40);

function add_related_blogs_func()
{
    global $product;

    $blogs = get_field('related_blogs', $product->get_id());


    if ($blogs) :
        $list_id_blogs = implode(', ', $blogs);
    ?>
        <div class="product-section">

            <?php
            echo do_shortcode('[row]

                [col span__sm="12" class="related related-products-wrapper product-section"]
                
                [title text="BÀI VIẾT LIÊN QUAN" class="product-section-title "]
                
                [blog_posts style="normal" columns="3" columns__md="1" ids="' . $list_id_blogs . '" image_height="56.25%"]
                
                
                [/col]
                
                [/row]');

            ?>

        </div>

<?php
    endif;
}
