<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
echo ($render_saved_condition == true) ? '' : '<div class="shipping_city">';
$operator = isset($options->operator) ? $options->operator : 'in_list';
?>
<div class="wdr_shipping_city_group wdr-condition-type-options">
    <div class="wdr-city-method wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', 'woo-discount-rules-pro'); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', 'woo-discount-rules-pro'); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Cities should be', 'woo-discount-rules-pro'); ?></span>
    </div>

    <div class="wdr-city wdr-input-filed-hight">
        <input type="text" style="width: 265px;" name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value]"
               class="awdr-left-align awdr-validation"
               placeholder="<?php _e('Enter Cities ', 'woo-discount-rules-pro');?>"
               value="<?php echo (isset($options->value)) ? $options->value : '' ?>">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Example : Chicago, Houston', 'woo-discount-rules-pro'); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
