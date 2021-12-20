<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$type = isset($options->type) ? $options->type : 'each';
$operator = isset($options->operator) ? $options->operator : 'greater_than_or_equal';
$values = isset($options->product) ? $options->product   : false;
echo ($render_saved_condition == true) ? '' : '<div class="cart_item_product_combination">';
?>
<div class="product_combination_group wdr-condition-type-options">
    <div class="wdr-product-filter_qty wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][type]" class="awdr-left-align">
            <option value="each" <?php echo ($type == "each") ? "selected" : ""; ?>><?php _e('Each', 'woo-discount-rules-pro') ?></option>
            <option value="combine" <?php echo ($type == "combine") ? "selected" : ""; ?>><?php _e('Combine', 'woo-discount-rules-pro') ?></option>
            <option value="any" <?php echo ($type == "any") ? "selected" : ""; ?>><?php _e('Any', 'woo-discount-rules-pro') ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Combination type', 'woo-discount-rules-pro'); ?></span>
    </div>
    <div class="wdr-product_filter_method wdr-select-filed-hight wdr-search-box">
        <select multiple="" name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][product][]"
                class="awdr-product-validation <?php echo ($render_saved_condition == true) ? 'edit-filters' : '' ?>"
                data-placeholder="<?php _e('Search product', 'woo-discount-rules-pro');?>"
                data-list="products"
                data-field="autocomplete"
                style="width: 100%; max-width: 400px;  min-width: 180px;">
            <?php
            if ($values) {
                $item_name = '';
                foreach ($values as $value) {
                    $item_name = '#'.$value.' '.\WDRPro\App\Helpers\CoreMethodCheck::getTitleOfProduct($value);
                    if ($item_name != '') { ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $item_name; ?></option><?php
                    }
                }
            } ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select product', 'woo-discount-rules-pro'); ?></span>
    </div>
    <div class="wdr-product-attributes-selector wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="combination_operator awdr-left-align">
            <option value="less_than" <?php echo ($operator == "less_than") ? "selected" : ""; ?>><?php _e('Less than ( &lt; )', 'woo-discount-rules-pro') ?></option>
            <option value="less_than_or_equal" <?php echo ($operator == "less_than_or_equal") ? "selected" : ""; ?>><?php _e('Less than or equal ( &lt;= )', 'woo-discount-rules-pro') ?></option>
            <option value="greater_than_or_equal" <?php echo ($operator == "greater_than_or_equal") ? "selected" : ""; ?>><?php _e('Greater than or equal ( &gt;= )', 'woo-discount-rules-pro') ?></option>
            <option value="greater_than" <?php echo ($operator == "greater_than") ? "selected" : ""; ?>><?php _e('Greater than ( &gt; )', 'woo-discount-rules-pro') ?></option>
            <option value="equal_to" <?php echo ($operator == "equal_to") ? "selected" : ""; ?>><?php _e('Equal to ( = )', 'woo-discount-rules-pro') ?></option>
            <option value="not_equal_to" <?php echo ($operator == "not_equal_to") ? "selected" : ""; ?>><?php _e('Not equal to ( != )', 'woo-discount-rules-pro') ?></option>
            <option value="in_range" <?php echo ($operator == "in_range") ? "selected" : ""; ?>><?php _e('In range', 'woo-discount-rules-pro') ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Comparison should be', 'woo-discount-rules-pro'); ?></span>
    </div>
    <div class="product_combination_from wdr-input-filed-hight">
        <input name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][from]"
               type="number" class="awdr-left-align product_combination_from_placeholder product_from_qty"
               value="<?php if(isset($options->from) && !empty($options->from)){ echo $options->from;}?>"
               placeholder="<?php _e('Quantity', 'woo-discount-rules-pro');?>" min="0" step="any">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Quantity', 'woo-discount-rules-pro'); ?></span>
    </div>
    <div class="product_combination_to wdr-input-filed-hight" style="<?php echo ($operator != "in_range") ? 'display: none;' : '';?>">
        <input name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][to]"
               type="number" class="awdr-left-align product_to_qty"
               value="<?php if(isset($options->to) && !empty($options->to)){ echo $options->to;}?>"
               placeholder="<?php _e('To', 'woo-discount-rules-pro');?>" min="0" step="any">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Quantity', 'woo-discount-rules-pro'); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
