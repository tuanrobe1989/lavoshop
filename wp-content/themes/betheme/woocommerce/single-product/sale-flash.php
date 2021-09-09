<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
?>
<?php if ( $product->is_on_sale() ) : 

$salehtml = '<span class="onsale"><i class="icon-star"></i></span>';

if( mfn_opts_get( 'sale-badge-style' ) == 'label' ){
    $salehtml = '<span class="onsale onsale-label">'. __('On Sale', 'woocommerce') .'</span>';
}else if( mfn_opts_get( 'sale-badge-style' ) == 'percent' ){
    $percent = Mfn_Builder_Woo_Helper::getDiscount($product);
    $salehtml = '<span class="onsale onsale-label">-'.$percent.'</span>';
}

?>

	<?php  echo apply_filters( 'woocommerce_sale_flash', $salehtml, $post, $product ); ?>

<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
