<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<?php
$operator = isset($options->operator) ? $options->operator : 'greater_than_or_equal';
echo ($render_saved_condition == true) ? '' : '<div class="cart_items_weight">';
?>
    <div class="wdr_cart_weight_group wdr-condition-type-options">
        <div class="wdr-cart-weight wdr-select-filed-hight">
            <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
                <option value="less_than" <?php echo ($operator == "less_than") ? "selected" : ""; ?>><?php _e('Less than ( &lt; )', 'woo-discount-rules-pro') ?></option>
                <option value="less_than_or_equal" <?php echo ($operator == "less_than_or_equal") ? "selected" : ""; ?>><?php _e('Less than or equal ( &lt;= )', 'woo-discount-rules-pro') ?></option>
                <option value="greater_than_or_equal" <?php echo ($operator == "greater_than_or_equal") ? "selected" : ""; ?>><?php _e('Greater than or equal ( &gt;= )', 'woo-discount-rules-pro') ?></option>
                <option value="greater_than" <?php echo ($operator == "greater_than") ? "selected" : ""; ?>><?php _e('Greater than ( &gt; )', 'woo-discount-rules-pro') ?></option>
            </select>
            <span class="wdr_desc_text awdr-clear-both "><?php _e('Weight should be', 'woo-discount-rules-pro'); ?></span>
        </div>

        <div class="cart-weight-value wdr-input-filed-hight">
            <input name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value]" type="text" class="float_only_field awdr-left-align"
                   value="<?php echo (isset($options->value)) ? $options->value : '' ?>" placeholder="<?php _e('0.00', 'woo-discount-rules-pro');?>">
            <span class="wdr_desc_text awdr-clear-both "><?php _e('Weight', 'woo-discount-rules-pro'); ?></span>
        </div>
    </div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>