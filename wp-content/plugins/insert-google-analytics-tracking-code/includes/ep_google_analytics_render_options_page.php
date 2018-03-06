<?php
/*
 * Inserts the html into the Admin > Settings > Google Anaytics options page
 *
 * @package Google Analytics
 * @subpackage Google Anaytics Render Options Page
 * @since 1.0.0
 */
?>

<div class="wrap">
<h1>Google Analytics</h1>
<form method="post" action="options.php">
<?php settings_fields( 'ep_google_analytics_options_group' ); ?>
<?php do_settings_sections( 'ep_google_analytics_admin' ); ?>
<?php submit_button(); ?>
</form>
</div>
