<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use WDRPro\App\Helpers\CoreMethodCheck;

class PurchaseLastOrderAmount extends Base
{
    protected static $cache_order_count = array();
    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_last_order_amount';
        $this->label = __('Last order amount', 'woo-discount-rules-pro');
        $this->group = __('Purchase History', 'woo-discount-rules-pro');
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/last-order-amount.php';
    }

    function check($cart, $options)
    {
        $conditions='';
        if (isset($options->operator) && isset($options->value) && $options->value > 0) {
            $billing_email = self::$woocommerce_helper->getBillingEmailFromPost();
            if($user = get_current_user_id()){
                if(!empty($billing_email) && apply_filters('advanced_woo_discount_rules_check_purchase_history_based_on_email_and_user_id', false)) {
                    //This might affect performance due to OR operation
                    $conditions = array(
                        'relation' => 'OR',
                        array('key' => '_customer_user', 'value' => $user, 'compare' => '='),
                        array('key' => '_billing_email', 'value' => $billing_email, 'compare' => '=')
                    );
                }else{
                    $conditions = array(
                        array('key' => '_customer_user', 'value' => $user, 'compare' => '=')
                    );
                }
            } else {
                if(!empty($billing_email)) {
                    $conditions = array(
                        array('key' => '_billing_email', 'value' => $billing_email, 'compare' => '=')
                    );
                }
            }

            if (!empty($conditions)) {
                $cache_key = CoreMethodCheck::generateBase64Encode($options);
                if(isset(self::$cache_order_count[$cache_key])){
                    $last_order_amount = self::$cache_order_count[$cache_key];
                } else {
                    $args = array(
                        'posts_per_page' => 1,
                        'meta_query' => $conditions,
                    );
                    if (isset($options->status) && is_array($options->status) && !empty($options->status)) {
                        $args['post_status'] = $options->status;
                    }
                    $orders = CoreMethodCheck::getOrdersThroughWPQuery($args);
                    $last_order_amount = 0;
                    if (!empty($orders)) {
                        foreach ($orders as $order) {
                            if (!empty($order) && isset($order->ID)) {
                                $order_obj = self::$woocommerce_helper->getOrder($order->ID);
                                $last_order_amount += self::$woocommerce_helper->getOrderTotal($order_obj);
                            }
                        }
                    }
                    self::$cache_order_count[$cache_key] = $last_order_amount;
                }
                return $this->doComparisionOperation($options->operator, $last_order_amount, $options->value);
            }
        }
        return false;
    }
}