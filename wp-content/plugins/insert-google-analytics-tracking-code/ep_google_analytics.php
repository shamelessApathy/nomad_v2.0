<?php

/*
  Plugin Name: Google Analytics
  Plugin URI: https://www.everydaypublishing.com.au/insert-google-analytics-tracking-code-wordpress-plugin/
  Description: Inserts the Google Analytics tracking code using only the website's Tracking ID
  Version: 1.0.5
  Author: Everyday Publishing
  Author URI: https://www.everydaypublishing.com.au/
  License: GPL2
  License URI: https://www.gnu.org/licenses/gpl-1.0.html
  Text Domain: wordpress
  Domain Path: /languages
 */

defined ( 'ABSPATH' ) or die ( 'Get out of my plugin!' );

if ( !defined( 'EP_GOOGLE_ANALYTICS_PATH' ) ) {
	define( 'EP_GOOGLE_ANALYTICS_PATH', dirname( __FILE__ ) );
}

/*
 * The installation routines that are run when the plugin is activated
 *
 * @package Google Analytics
 * @subpackage Google Analytics Controller
 * @since 1.0.0
 */

function ep_google_analytics_activate() {
	add_option( 'ep_google_analytics_options', array( 'trackingID' => '' ) );
	register_deactivation_hook( __FILE__, 'ep_google_analytics_deactivate' );
	register_uninstall_hook( __FILE__, 'ep_google_analytics_uninstall' );
}
register_activation_hook( __FILE__, 'ep_google_analytics_activate' );

/*
 * The uninstall routines that are run when the plugin is deleted
 *
 * @package Google Analytics
 * @subpackage Google Analytics Controller
 * @since 1.0.0
 */

function ep_google_analytics_deactivate() {
	unregister_setting( 'ep_google_analytics_option_group', 'ep_google_analytics_options' );
}

function ep_google_analytics_uninstall() {
	delete_option( 'ep_google_analytics_options' );
}

// Add a settings link to the right of the activate and deactivate links on the plugin page
function ep_google_analytics_settings_link( $links ) {
	$settings_link = array( '<a href="' . admin_url( 'options-general.php?page=ep_google_analytics_admin' ) . '">Settings</a>', );
	return array_merge( $settings_link, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ep_google_analytics_settings_link' );

// Include the controller class
require_once( 'classes/ep_google_analytics_controller.php' );

// Instantiate the controller to begin configuration in the class constructor
$startControl = new epGoogleAnalyticsController;

?>
