<?php
/**
 * @wordpress-plugin
 * Plugin Name:       IU News Alert
  * Description:      Alert bar for NEws
 * Version:           1.0
 * Author:            Ryan Antcliff
 */
 add_action( 'admin_menu', 'news_alert' );

 function news_alert() {
 	add_options_page(
 		'My Options',
 		'News Alerts',
 		'manage_options',
 		'news-alerts.php',
 		'news_alert_page'
 	);
}

function news_alert_page(){
  ?>
  <div class="wrap">
  <h2>Your Plugin Name</h2>

    <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>

      <table class="form-table">

        <tr valign="top">
          <th scope="row">Alert Title</th>
            <td><input type="text" name="alert_title" value="<?php echo get_option('alert_title'); ?>" /></td>
        </tr>

        <tr valign="top">
          <th scope="row">Alert Blurb</th>
            <td><input type="textarea" name="alert_text" value="<?php echo get_option('alert_text'); ?>" /></td>
        </tr>

        <tr valign="top">
          <th scope="row">Alert Url</th>
            <td><input type="url" name="alert_url" value="<?php echo get_option('alert_url'); ?>" /></td>
        </tr>

        <tr valign="top">
          <th scope="row">Alert</th>
            <td><input name="alert_checked" type="checkbox" value="1" <?php checked( '1', get_option( 'alert_checked' ) ); ?> />
            </td>
        </tr>


      </table>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="alert_title,alert_url,alert_text, alert_checked" />

    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

    </form>
  </div>

<?php

}
