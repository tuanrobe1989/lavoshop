<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<tr class="" style="">
    <td scope="row">
        <label for="licence_key" class="awdr-left-align"><?php _e('Licence key', 'woo-discount-rules-pro') ?></label>
        <span class="wdr_desc_text awdr-clear-both"><?php esc_html_e('Add licence key to get auto update', 'woo-discount-rules-pro'); ?> - <a href="https://docs.flycart.org/en/articles/2088290-license-key-activation?utm_source=woo-discount-rules-v2&utm_campaign=doc&utm_medium=text-click&utm_content=licence_activation" target="_blank"><?php esc_html_e('Read Docs', 'woo-discount-rules-pro'); ?></a></span>
    </td>
    <td>
        <input type="text" name="licence_key" id="awdr_licence_key"
               value="<?php echo $configuration->getConfig('licence_key', ''); ?>">
        <input type="button" id="validate_licence_key" class="button button-primary"
               value="<?php esc_html_e('Validate', 'woo-discount-rules-pro'); ?>" data-awdr_nonce="<?php echo \WDRPro\App\Helpers\CoreMethodCheck::create_nonce('awdr_validate_licence_key'); ?>">
        <div class="validate_licence_key_status"><?php echo $licence_key_message; ?></div>
    </td>
</tr>