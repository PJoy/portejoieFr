<div class="wrap">
    <?php
        require_once ( WPMETASEO_PLUGIN_DIR . 'inc/pages/google-analytics/menu.php' );
    ?>
    <h2><?php _e('Google Analytics Settings','wp-meta-seo') ?></h2>
    <form name="input" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
        <?php wp_nonce_field('gadash_form', 'gadash_security'); ?>    
        <table class="wpms-settings-options">
            <tr>
                <td colspan="2" class="wpms-settings-info">
                    <?php echo __("Use this link to get your access code:", 'wp-meta-seo') . ' <a href="' . $authUrl . '" target="_blank">' . __("Get Access Code", 'wp-meta-seo') . '</a>.'; ?>
                </td>
            </tr>
            <tr>
                <td class="wpms-settings-title"><label for="wpms_ga_code" title="<?php _e("Use the red link to get your access code!", 'wp-meta-seo') ?>"><?php echo _e("Access Code:", 'wp-meta-seo'); ?></label></td>
                <td><input type="text" id="ga_dash_code" name="wpms_ga_code" value="" size="61" required="required" title="<?php _e("Use the red link to get your access code!", 'wp-meta-seo') ?>"></td>
            </tr>
            
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="wpmsga_dash_userapi" type="checkbox" id="wpmsga_dash_userapi" value="1" <?php checked($this->google_alanytics['wpmsga_dash_userapi'],1) ?> ><label class="metaseo_tool" alt="<?php _e('You have the option to create your own Google developer project and use your own API key for tracking (optional)','wp-meta-seo') ?>"><?php _e(' Use your own API Project credentials','wp-meta-seo') ?></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" class="button button-secondary wpmsga_authorize" name="ga_dash_authorize" value="<?php _e("Save Access Code", 'wp-meta-seo'); ?>" />
                </td>
            </tr>
        </table>
    </form>
</div>