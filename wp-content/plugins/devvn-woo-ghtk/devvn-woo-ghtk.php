<?php
/*
 * Plugin Name: DevVN - Woocommerce - Giao Hàng Tiết Kiệm (GHTK)
 * Plugin URI: https://levantoan.com/san-pham/plugin-ket-noi-giao-hang-tiet-kiem-voi-woocommerce-ghtk-vs-woocommerce/
 * Version: 2.0.5.1
 * Requires PHP: 7.2
 * Description: Add province/city, district, commune/ward/town to checkout form and simplify checkout form. Sync order and calc shipping code form GHTK
 * Author: Lê Văn Toản
 * Author URI: https://levantoan.com
 * Text Domain: devvn-ghtk
 * Domain Path: /languages
 * WC requires at least: 3.0.0
 * WC tested up to: 5.8.0
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (!defined('DEVVN_GHTK_VERSION_NUM'))
    define('DEVVN_GHTK_VERSION_NUM', '2.0.5.1');
if (!defined('DEVVN_GHTK_URL'))
    define('DEVVN_GHTK_URL', plugin_dir_url(__FILE__));
if (!defined('DEVVN_GHTK_BASENAME'))
    define('DEVVN_GHTK_BASENAME', plugin_basename(__FILE__));
if (!defined('DEVVN_GHTK_PLUGIN_DIR'))
    define('DEVVN_GHTK_PLUGIN_DIR', plugin_dir_path(__FILE__));

if(extension_loaded('ionCube Loader')) {
    include 'devvn-woo-ghtk-main.php';
}else{
    function devvn_ghtk_admin_notice__error() {
        $class = 'notice notice-alt notice-warning notice-error';
        $title = '<h2 class="notice-title">Chú ý!</h2>';
        $message = __( 'Để Plugin <strong>DevVN - Woocommerce - Giao Hàng Tiết Kiệm (GHTK)</strong> hoạt động, bắt buộc cần kích hoạt <strong>php extension ionCube</strong>.', 'devvn-ghtk' );
        $btn = '<p><a href="https://levantoan.com/huong-dan-kich-hoat-extension-ioncube/" target="_blank" rel="nofollow" class="button-primary">Xem hướng dẫn tại đây</a></a></p>';

        printf( '<div class="%1$s">%2$s<p>%3$s</p>%4$s</div>', esc_attr( $class ), $title, $message, $btn );
    }
    add_action( 'admin_notices', 'devvn_ghtk_admin_notice__error' );
}