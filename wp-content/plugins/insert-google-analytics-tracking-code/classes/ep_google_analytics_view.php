<?php
/*
 * The Main Plugin View
 *
 * @package Google Analytics
 * @subpackage Google Analytics View
 * @since 1.0.0
 */

if ( !class_exists( 'epGoogleAnalyticsFooterView' ) ) {
	/*
	 * The Footer View Class in the MVC Architecture
	 * Inserts the Google Analytics code block into the footer
	 *
	 * @package Google Analytics
	 * @subpackage Google Analytics View
	 * @since 1.0.0
	 */

	class epGoogleAnalyticsFooterView {
		/*
		 * Method to print the code block html
		 *
		 * @package Google Analytics
	 	 * @subpackage Google Analytics View
	 	 * @since 1.0.0
	 	 */

		public static function render_code_block( $trackingID ) {
			require_once( EP_GOOGLE_ANALYTICS_PATH . '/includes/ep_google_analytics_code_block.php' );
		}
	}
}


if ( !class_exists( 'epGoogleAnalyticsAdminView' ) ) {
	class epGoogleAnalyticsAdminView {
		/*
		 * Function to insert the html into the option page
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics View
		 * @since 1.0.0
		 */

		public static function render_options_page() {
			// Ensure that only people who are authorised to manage options are allowed to access the page
			if ( !current_user_can( 'manage_options' ) ) {
				wp_die( __( 'You do not have the required privileges to access this page.' ) );
			}

			// All html for this plugin is placed inside inlcude files
			require_once( EP_GOOGLE_ANALYTICS_PATH . '/includes/ep_google_analytics_render_options_page.php' );
		}

		/*
		 * Function to insert the html into the tracking id section
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics View
		 * @since 1.0.0
		 */

		public static function render_tracking_section () {
			require_once ( EP_GOOGLE_ANALYTICS_PATH . '/includes/ep_google_analytics_tracking_section.php' );
		}

		/*
		 * Function to insert the html into the tracking id field
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics View
		 * @since 1.0.0
		 */

		public static function render_tracking_field ( $trackingID ) {
			require_once ( EP_GOOGLE_ANALYTICS_PATH . '/includes/ep_google_analytics_tracking_field.php' );
		}
	}
}
