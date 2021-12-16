<?php
/*
 * Plugin Name: DevVN - Woocommerce Vietnam Checkout PRO
 * Plugin URI: https://levantoan.com/plugin-tinh-phi-van-chuyen-cho-quan-huyen-trong-woocommerce/
 * Version: 4.4.6
* Requires PHP: 7.2
 * Description: Add province/city, district, commune/ward/town to checkout form and simplify checkout form
 * Author: Le Van Toan
 * Author URI: https://levantoan.com
 * Text Domain: devvn-vncheckout
 * Domain Path: /languages
 * WC requires at least: 3.5.4
 * WC tested up to: 5.8.0
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !defined( 'DEVVN_DWAS_VERSION_NUM' ) )
    define( 'DEVVN_DWAS_VERSION_NUM', '4.4.6' );
if ( !defined( 'DEVVN_DWAS_URL' ) )
    define( 'DEVVN_DWAS_URL', plugin_dir_url( __FILE__ ) );
if ( !defined( 'DEVVN_DWAS_BASENAME' ) )
    define( 'DEVVN_DWAS_BASENAME', plugin_basename( __FILE__ ) );
if ( !defined( 'DEVVN_DWAS_PLUGIN_DIR' ) )
    define( 'DEVVN_DWAS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if ( !defined( 'DEVVN_DWAS_TEXTDOMAIN' ) )
    define( 'DEVVN_DWAS_TEXTDOMAIN', 'devvn-vncheckout' );

if(extension_loaded('ionCube Loader')) {
    include 'vietnam-checkout/vietnam-checkout.php';
    include 'includes/main.php';
}else{
    function devvn_quanhuyen_admin_notice__error() {
        $class = 'notice notice-alt notice-warning notice-error';
        $title = '<h2 class="notice-title">Chú ý!</h2>';
        $message = __( 'Để Plugin <strong>Woocommerce Vietnam Checkout PRO</strong> hoạt động, bắt buộc cần kích hoạt <strong>php extension ionCube</strong>.', 'devvn-vncheckout' );
        $btn = '<p><a href="https://levantoan.com/huong-dan-kich-hoat-extension-ioncube/" target="_blank" rel="nofollow" class="button-primary">Xem hướng dẫn tại đây</a></a></p>';

        printf( '<div class="%1$s">%2$s<p>%3$s</p>%4$s</div>', esc_attr( $class ), $title, $message, $btn );
    }
    add_action( 'admin_notices', 'devvn_quanhuyen_admin_notice__error' );
}