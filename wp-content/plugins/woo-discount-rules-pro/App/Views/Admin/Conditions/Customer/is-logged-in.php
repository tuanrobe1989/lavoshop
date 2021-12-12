<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$values = isset($options->value) ? $options->value : false;
echo ($render_saved_condition == true) ? '' : '<div class="user_logged_in">';
?>
    <div class="wdr_user_logged_in_group wdr-condition-type-options">
        <div class="wdr-is-logged-in wdr-select-filed-hight">
            <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value]" width="100%" class="awdr-left-align">
                <option value="yes" <?php echo ($values == "yes") ? "selected" : ""; ?>><?php _e('Yes', 'woo-discount-rules-pro') ?></option>
                <option value="no" <?php echo ($values == "no") ? "selected" : ""; ?>><?php _e('No', 'woo-discount-rules-pro') ?></option>
            </select>
            <span class="wdr_desc_text awdr-clear-both "><?php _e('Customer log in status', 'woo-discount-rules-pro'); ?></span>
        </div>
    </div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>