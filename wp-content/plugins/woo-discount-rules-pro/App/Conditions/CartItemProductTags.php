<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class CartItemProductTags extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_item_product_tags';
        $this->label = __('Product Tags', 'woo-discount-rules-pro');
        $this->group = __('Cart Items', 'woo-discount-rules-pro');
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Products/product-tags.php';
    }

    public function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        return $this->doCartItemsCheck($cart, $options, 'product_tags');
    }
}